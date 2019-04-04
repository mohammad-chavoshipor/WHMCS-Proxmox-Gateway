<?php

use WHMCS\Module\Addon\ProxmoxAddon\Models\Vm;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Template;
use WHMCS\Module\Addon\ProxmoxAddon\Tasks\VncTask;
use WHMCS\Module\Addon\ProxmoxAddon\Tasks\RunningTask;
use WHMCS\Module\Addon\ProxmoxAddon\Tasks\RrdTask;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Account;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Task;

use WHMCS\Service\Service;

function proxmox_addon_ClientArea(array $params)
{

	$service = Service::find($params['serviceid']);

	if ($service->domainStatus === 'Active') {
		switch ($_REQUEST['method']) {
			case 'start':
				$result = proxmox_addon_start($params);

				if ($result === 'success') {
					json(['success' => true]);
				}

				json([
					'success' => false,
					'error' => $result
				]);
				break;
			case 'shutdown':
				$result = proxmox_addon_shutdown($params);
				if ($result === 'success') {
					json(['success' => true]);
				}

				json([
					'success' => false,
					'error' => $result
				]);
				break;
			case 'restart':
				$result = proxmox_addon_reboot($params);
				if ($result === 'success') {
					json(['success' => true]);
				}

				json([
					'success' => false,
					'error' => $result
				]);
				break;
			case 'kill':
				$result = proxmox_addon_stop($params);
				if ($result === 'success') {
					json(['success' => true]);
				}

				json([
					'success' => false,
					'error' => $result
				]);
				break;
			case 'reinstall':
				$result = proxmox_addon_reinstall($params);
				if ($result === 'success') {
					json(['success' => true]);
				}

				json([
					'success' => false,
					'error' => $result
				]);
				break;
			case 'data':
				promox_addon_datas($params);
				break;

			case 'rrd':

				$server = $service->serverModel;
				$vm = Vm::where('service_id', $service->id)->first();

				$rrd = new RrdTask($server);

				list($rrd, $error) = $rrd->execute([
					'id' => $vm->vmid,
					'node' => $vm->node->node,
					'timeframe' => $_REQUEST['timeframe'] ?? 'hour'
				]);

				if ($error) {
					json([
						'success' => false,
						'error' => $error
					]);
				}

				json([
					'success' => true,
					'rrd' => $rrd
				]);

				break;

			case 'stats':
				return array(
					'tabOverviewReplacementTemplate' => '../templates/client/stats.tpl',
					'vars' => [
						'params' => $params
					],
				);
				break;
		}
	}

	return array(
		'tabOverviewReplacementTemplate' => '../templates/client/overview.tpl',
		'vars' => [
			'params' => $params
		],
	);
}

function json($data)
{
	header('Content-type: application/json');
	exit(json_encode($data));
}

function promox_addon_datas($params)
{
	$vm = Vm::where('service_id', $params['serviceid'])->first();
	$templates = Template::select('id', 'name')->where('cluster_id', $vm->node->cluster_id)->get();
	$vnc = new VncTask($vm->node->server);
	$status = new RunningTask($vm->node->server);

	$reinstall = Task::where([
		['service_id', '=', $vm->service_id],
		['task', '=', 'resinstallLxc'],
		['status', '<', 3]
	])->first();

	$install = Task::where([
		['service_id', '=', $vm->service_id],
		['task', '=', 'createLxc'],
		['status', '<', 3]
	])->first();

	$tasks =  Task::select('task', 'status', 'message', 'created_at', 'updated_at')
		->where([
			['service_id', '=', $vm->service_id],
		])
		->get();

	list($status, $error) = $status->execute([
		'id' => $vm->vmid,
		'node' => $vm->node->node,
	]);

	if ($error) {
		json([
			'success' => false,
			'error' => $error
		]);
	}

	if ($status->status === "running") {
		list($url, $error) = $vnc->execute([
			'id' => $vm->vmid,
			'node' => $vm->node->node,
			'client' => $params['userid']
		], true);

		if ($error) {
			json([
				'success' => false,
				'error' => $error
			]);
		}
	}

	json([
		'success' => true,
		'url' => $url ?? null,
		'status' => $status,
		'templates' => $templates,
		'reinstall' => (bool)$reinstall,
		'install' => (bool)$install,
		'tasks' => $tasks
	]);

}