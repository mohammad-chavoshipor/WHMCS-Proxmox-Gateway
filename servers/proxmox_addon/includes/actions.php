<?php

use WHMCS\Module\Addon\ProxmoxAddon\Tasks\ShutdownTask;
use WHMCS\Module\Addon\ProxmoxAddon\Tasks\RebootTask;
use WHMCS\Module\Addon\ProxmoxAddon\Tasks\StartTask;
use WHMCS\Module\Addon\ProxmoxAddon\Tasks\StopTask;

use WHMCS\Module\Addon\ProxmoxAddon\Models\Vm;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Node;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Task;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Template;

use WHMCS\Product\Server;

function proxmox_addon_AdminCustomButtonArray()
{
    return array(
        "Démarrer" => "start",
        "Arrêter" => "shutdown",
        "Redémarrer" => "reboot",
        "Tuer" => "stop",
    );
}

function proxmox_addon_reinstall(array $params)
{
    $server = Server::find($params['serverid']);

    if (!$server) {
        log_queue($params['serviceid'], 'Reinstall', "Server id : {$params['serverid']} not found");
        return "Server id : {$params['serverid']} not found";
    }

    $vm = Vm::where('service_id', $params['serviceid'])->first();
    if (!$vm) {
        return 'VM Reinstallation failed with error : VM Not found !';
    }

    $template = Template::find($_REQUEST['os']);
    if (!$template) {
        return 'VM Reinstallation failed with error : Template not found !';
    }

    $reinstall = Task::where([
        ['service_id', '=', $vm->service_id],
        ['task', '=', 'resinstallLxc'],
        ['status', '<', 3]
    ])->first();

    if (!$template) {
        return 'VM Reinstallation failed with error : Reinstall already in progress!';
    }

    $task = new Task();
    $task->service_id = $params['serviceid'];
    $task->server_id = $params['serverid'];
    $task->product_id = $params['pid'];
    $task->params = $_REQUEST['os'];
    $task->status = Task::STATUS_PENDING;
    $task->task = 'resinstallLxc';
    $task->proxmox = '';

    $task->save();

    return 'success';
}

function proxmox_addon_start(array $params)
{
    $server = Server::find($params['serverid']);
    $vm = Vm::where('service_id', $params['serviceid'])->first();
    $node = Node::where('server_id', $params['serverid'])->first();

    if (!$server) return 'Server not found';
    if (!$vm) return 'Vm not found';
    if (!$node) return 'Node not found';
    
    $task = new StartTask($server);
    list($data, $error) = $task->execute([
        'id' => $vm->vmid,
        'node' => $node->node
    ]);

    if ($error) return $error;

    return 'success';
}

function proxmox_addon_shutdown(array $params)
{
    $server = Server::find($params['serverid']);
    $vm = Vm::where('service_id', $params['serviceid'])->first();
    $node = Node::where('server_id', $params['serverid'])->first();


    if (!$server) return 'Server not found';
    if (!$vm) return 'Vm not found';
    if (!$node) return 'Node not found';


    $task = new ShutdownTask($server);
    list($data, $error) = $task->execute([
        'id' => $vm->vmid,
        'node' => $node->node
    ]);

    if ($error) return $error;

    return 'success';
}

function proxmox_addon_stop(array $params)
{
    $server = Server::find($params['serverid']);
    $vm = Vm::where('service_id', $params['serviceid'])->first();
    $node = Node::where('server_id', $params['serverid'])->first();


    if (!$server) return 'Server not found';
    if (!$vm) return 'Vm not found';
    if (!$node) return 'Node not found';
    
    $task = new StopTask($server);
    list($data, $error) = $task->execute([
        'id' => $vm->vmid,
        'node' => $node->node
    ]);

    if ($error) return $error;

    return 'success';
}

function proxmox_addon_reboot(array $params)
{
    $server = Server::find($params['serverid']);
    $vm = Vm::where('service_id', $params['serviceid'])->first();
    $node = Node::where('server_id', $params['serverid'])->first();


    if (!$server) return 'Server not found';
    if (!$vm) return 'Vm not found';
    if (!$node) return 'Node not found';

    
    $task = new RebootTask($server);
    list($data, $error) = $task->execute([
        'id' => $vm->vmid,
        'node' => $node->node
    ]);

    if ($error) return $error;

    return 'success';
}