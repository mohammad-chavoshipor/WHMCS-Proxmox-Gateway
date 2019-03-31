<?php

use WHMCS\Module\Addon\ProxmoxAddon\Models\NetInterface;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Template;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Cluster;
use WHMCS\Module\Server\ProxmoxAddon\Helpers\View;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Task;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Vm;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Node;

use WHMCS\Module\Addon\ProxmoxAddon\Tasks\VncTask;

use WHMCS\Product\Product;
use WHMCS\Product\Server;

function proxmox_addon_ConfigOptions()
{

    if (isset($_REQUEST['action']) && ($_REQUEST['action'] != 'save') && preg_match('/configproducts.php/', $_SERVER['SCRIPT_FILENAME'])) {

        $view = new View(dirname(__DIR__) . '/templates');
        $product = Product::find($_REQUEST['id']);
        $clusters = Cluster::all();

        $interfaces = NetInterface::where('cluster_id', $product->configoption2)->get();

        echo json_encode([
            'mode' => 'advanced',
            'content' => $view->render('admin/product', [
                'product' => $product,
                'clusters' => $clusters,
                'interfaces' => $interfaces,
            ])
        ]);

        exit;
    }

    return [
        'type', 'cluster', 'boot', 'notes', 'cores', 'disk', 'rootfs', 'ram', 'swap', 'bakups', 'backupfs', 'bakups_time', 'eth0', 'eth1', 'eth2', 'eth3'
    ];
}

function proxmox_addon_AdminServicesTabFields(array $params)
{
    $vm = Vm::where('service_id', $params['serviceid'])->first();
    $node = Node::find($vm->node_id);
    $cluster = Cluster::find($node->cluster_id);

    $output = [];
    if (!$vm) {
        $output['<strong style="color:#e74c3c;font-size: 14px;">Errors</strong>'] = '<strong style="color:#e74c3c;font-size: 14px;">VM not found</strong>';
    }
    
    $output['<strong>Avanced Commands</strong>'] = generateAvancedCommands($vm);
    $output['<strong>Proxmox id</strong>'] = "<strong>{$vm->vmid}</strong>";
    $output['<strong>Cluster</strong>'] = $cluster->name;
    $output['<strong>Proxmox node</strong>'] = $node->node;
    $output['<strong>Status</strong>'] = '
        <script>
            $.get("addonmodules.php?module=proxmox_addon&action=api&method=status&id='.$vm->vmid.'", function(data) {
                if(data.status === "running") {
                    $("#status").html(`<span class="label label-success">Running</span>`);
                } else if (data.status === "stopped"){
                    $("#status").html(`<span class="label label-danger">Stopped</span>`);
                } else {
                    $("#status").html(`<span class="label label-default">Error</span>`);
                }
            });
        </script>
        <div id="status"><img src="images/loader.gif"> &nbsp; Working...</div>
    ';
    $output['<strong>Tasks history</strong>'] = generateTaskTable($params['serviceid']);

    return $output;

}

function generateAvancedCommands(Vm $vm = null)
{

    if (!$vm) return '<button class="btn btn-default" disabled>Reinstall</button>';
    $task = Task::where([
        ['service_id', '=', $vm->service_id],
        ['task', '=', 'resinstallLxc'],
        ['status', '<', 3]
    ])->first();
    if ($task) return '<button class="btn btn-default" disabled>Reinstall in progress ...</button>';

    $templates = Template::where('cluster_id', $vm->node->cluster_id)->get();
    $vnc = new VncTask($vm->node->server);
    list($url, $error) = $vnc->execute([
        'id' => $vm->vmid,
        'node' => $vm->node->node
    ]);


    $output = '
    <script>
        function openConsole() {
            window.open("'.$url.'", "Console", "width=800,height=600");
            window.close();
        }
        function runReinstall() {
            $("#module_reinstall .btn-primary").attr("disabled", true);
            

            $.post("clientsservices.php", {
                    modop: "custom",
                    token: csrfToken,
                    id: $("input[name=id]").val(),
                    userid: $("input[name=userid]").val(),
                    ajax: 1,
                    ac: "reinstall",
                    os: $("#os-list").val()
                })
                .done(function( data ) {
                    location.reload();
                });
        }
    </script>
    <div class="modal fade" id="module_reinstall" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content panel panel-primary">
                <div class="modal-header panel-heading">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title">Confirm reinstall</h4>
                </div>
                <div class="modal-body panel-body">
                <p><strong>Please select an os :</strong></p>
                <select id="os-list" class="form-control">';
                    foreach ($templates as $template) {
                       $output .= '<option value="'.$template->id.'">'.$template->name .'</option><br>';
                    }
    $output .= '</select>
                </div>
                <div class="modal-footer panel-footer">
                    <button type="button" class="btn btn-primary" onclick="runReinstall()">
                        Reinstall
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-default" onclick="jQuery(\'#module_reinstall\').modal(\'show\');">Reinstall</button>
    <button type="button" class="btn btn-default" onclick="openConsole()">Console</button>
    ';


    return $output;
}

function generateTaskTable($service) 
{
    $output =  '<div class="tablebg"><table id="sortabletbl1" class="datatable" width="100%" cellspacing="1" cellpadding="3" border="0"><tbody><tr><th width="40">#</th><th>Name</th><th>Status</th><th>Result</th></tr>';

    $tasks = Task::where('service_id', $service)->orderBy('id', 'desc')->get();

    if (!$tasks->count()) {
        $output .= '<tr><td colspan="7">No Records Found</td></tr>';
    }

    foreach ($tasks as $task) {

        switch ($task->status) {
            case 1:
                $status = '<span class="label label-default">Pending</span>';
                break;

            case 2:
                $status = '<span class="label label-warning">Running</span>';
                break;
            
            case 3:
                $status = '<span class="label label-success">Success</span>';
                break;

            case 4:
                $status = '<span class="label label-danger">Failed</span>';
                break;
        
        }

        $output .= "<tr>
            <td class='text-center'>{$task->id}</td>
            <td class='text-center'>{$task->task}</td>
            <td class='text-center'>$status</td>
            <td class='text-center'>{$task->message}</td>
        </tr>";
    }

    $output .= '</tbody></table></div>';
    return $output;
}