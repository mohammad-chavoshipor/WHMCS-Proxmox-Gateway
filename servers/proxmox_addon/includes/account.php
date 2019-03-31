<?php

use DateTime;

use WHMCS\Module\Addon\ProxmoxAddon\Models\Task;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Node;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Vm;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Ip;

use WHMCS\Module\Addon\ProxmoxAddon\Tasks\ShutdownTask;
use WHMCS\Module\Addon\ProxmoxAddon\Tasks\StartTask;
use WHMCS\Module\Addon\ProxmoxAddon\Tasks\StopTask;
use WHMCS\Module\Addon\ProxmoxAddon\Tasks\DropTask;

use WHMCS\Product\Server;

function proxmox_addon_CreateAccount(array $params)
{

    $server = Server::find($params['serverid']);

    if (!$server) {
        log_queue($params['serviceid'], 'CreateAccount', "Server id : {$params['serverid']} not found");
        return "Server id : {$params['serverid']} not found";
    }

    $vm = Vm::where('service_id', $params['serviceid'])->first();
    if ($vm) {
        return "VM Creation failed with error : A vm is already associated with this service.";
    }

    $task = new Task();
    $task->service_id = $params['serviceid'];
    $task->server_id = $params['serverid'];
    $task->product_id = $params['pid'];
    $task->status = Task::STATUS_PENDING;
    $task->task = 'createLxc';
    $task->proxmox = '';

    $task->save();

	return 'success';
}

function proxmox_addon_SuspendAccount(array $params)
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

function proxmox_addon_UnsuspendAccount(array $params)
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

function proxmox_addon_TerminateAccount(array $params)
{
    $server = Server::find($params['serverid']);
    $vm = Vm::where('service_id', $params['serviceid'])->first();
    $node = Node::where('server_id', $params['serverid'])->first();

    if (!$server) return 'Server not found';
    if (!$vm) return 'Vm not found';
    if (!$node) return 'Node not found';
    
    $task = new DropTask($server);
    list($data, $error) = $task->execute([
        'id' => $vm->vmid,
        'service' => $params['serviceid'],
        'node' => $node->node
    ]);

    if ($error) return $error;

    $task = new Task();
    $task->service_id = $params['serviceid'];
    $task->server_id = $params['serverid'];
    $task->product_id = $params['pid'];
    $task->status = Task::STATUS_SUCCESS;
    $task->task = 'deleteLxc';
    $task->proxmox = $data;
    $task->message = 'OK';

    $task->save();

    return 'success';
}