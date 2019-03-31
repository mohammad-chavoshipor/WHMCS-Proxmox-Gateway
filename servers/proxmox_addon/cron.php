<?php

require_once 'vendor/autoload.php';

define('__ROOTDIR__', substr(dirname(__FILE__), 0, strpos(dirname(__FILE__), 'modules' . DIRECTORY_SEPARATOR . 'servers' . DIRECTORY_SEPARATOR)));

require_once __ROOTDIR__ . '/init.php';
require_once __ROOTDIR__ . 'includes/modulefunctions.php';

use WHMCS\Product\Server;

function log_queue($service, $action, $error) {

    $queue = WHMCS\Module\Addon\ProxmoxAddon\Models\Whmcs\Queue::where([
        'service_id' => $service,
        'module_action' => $action,
        'module_name' => 'promox_addon',
        'completed' => false
    ])->first();

    if ($queue) {

        $queue->num_retries += 1;
        $queue->last_attempt = new DateTime();
        $queue->last_attempt_error = $error;

    } else {

        $queue = new WHMCS\Module\Addon\ProxmoxAddon\Models\Whmcs\Queue();
        $queue->service_type = 'service';
        $queue->service_id = $service;
        $queue->module_name = 'promox_addon';
        $queue->module_action = $action;
        $queue->last_attempt = new DateTime();
        $queue->last_attempt_error = $error;

    }

    $queue->save();
}

$tasks = WHMCS\Module\Addon\ProxmoxAddon\Models\Task::where('status', WHMCS\Module\Addon\ProxmoxAddon\Models\Task::STATUS_PENDING)->get();
$check_tasks = WHMCS\Module\Addon\ProxmoxAddon\Models\Task::where('status', WHMCS\Module\Addon\ProxmoxAddon\Models\Task::STATUS_RUNNING)->get();
$actions = [
    'createLxc' => WHMCS\Module\Addon\ProxmoxAddon\Tasks\CreateTask::class,
	'resinstallLxc' => WHMCS\Module\Addon\ProxmoxAddon\Tasks\ReinstallTask::class,
];

echo "<pre>";
echo "{$tasks->count()} tasks to execute\n";
echo "{$check_tasks->count()} tasks to check\n";

foreach ($tasks as $task) {
	$server = Server::find($task->server_id);
	$node = WHMCS\Module\Addon\ProxmoxAddon\Models\Node::where('server_id', $task->server_id)->first();

	$action = new $actions[$task->task]($server);

	list($data, $error) = $action->execute([
		'service' => $task->service_id,
		'node' => $node->id,
		'template' => $task->params,
	]);

    if ($error) {
        $task->status = WHMCS\Module\Addon\ProxmoxAddon\Models\Task::STATUS_FAIL;
        $task->proxmox = $data;
        $task->message = $error;
        $task->save();
        continue;
    }

    $task->status = WHMCS\Module\Addon\ProxmoxAddon\Models\Task::STATUS_RUNNING;
    $task->proxmox = $data;
    $task->save();
}


foreach ($check_tasks as $task) {
    $server = Server::find($task->server_id);
    $node = WHMCS\Module\Addon\ProxmoxAddon\Models\Node::where('server_id', $task->server_id)->first();

    $status = new WHMCS\Module\Addon\ProxmoxAddon\Tasks\StatusTask($server);

    list($status, $error) = $status->execute([
        'node' => $node->node,
        'id' => $task->proxmox
    ]);

    if ($error) {
        $task->status = WHMCS\Module\Addon\ProxmoxAddon\Models\Task::STATUS_FAIL;
        $task->proxmox = $data;
        $task->message = $error;
        $task->save();
        continue;
    }
    
    if ($status->status === 'running') continue;
    if ($status->status === 'stopped' && $status->exitstatus === 'OK') {
        $task->status = WHMCS\Module\Addon\ProxmoxAddon\Models\Task::STATUS_SUCCESS;
        $task->message = $status->exitstatus;
        $task->save();
        continue;
    }

    $task->status = WHMCS\Module\Addon\ProxmoxAddon\Models\Task::STATUS_FAIL;
    $task->message = $status->exitstatus;
    $task->save();

}
