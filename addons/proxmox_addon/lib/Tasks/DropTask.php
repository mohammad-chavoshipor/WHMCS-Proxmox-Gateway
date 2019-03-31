<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Tasks;

use Exception;
use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Task;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Vm;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Ip;

use WHMCS\Service\Service;

class DropTask extends Task
{
	public function execute(array $params)
	{

		if (!$params['preserve-data']) {
			$vm = Vm::where('vmid', $params['id'])->first();
			$vm->delete();

			$ips = Ip::where('service_id', $params['service'])->get();
			foreach ($ips as $ip) {
				$ip->service_id = null;
				$ip->used = false;
				$ip->save();
			}

			$service = Service::find($params['service']);

			$service->dedicatedip = '';
			$service->assignedips = '';
			$service->save();
		}

		list($status, $error) = $this->request(
			'lxcCurrent',
			$params['node'],
			$params['id']
		);

		if ($error) return [
			null, $error
		];

		list($stop, $error) = $this->request(
			'lxcShutdown',
			$params['node'],
			$params['id']
		);

		if ($error) return [
			null, $error
		];

		list($task, $error) = $this->request(
			'tasksStatus',
			$params['node'],
			$stop
		);

		if ($error) return [
			null, $error
		];

		$try = 0;
		while ($task->status === 'running') {
			sleep(1);

			if ($try > 30) {
			  	return [
					null, 'Shutdown took more than 30 seconds'
				];
			}

			list($task, $error) = $this->request(
				'tasksStatus',
				$params['node'],
				$stop
			);

			if ($error) return [
				null, $error
			];

			$try ++;
		}

		if ($error) return [
			null, $error
		];;
	
		list($data, $error) = $this->request(
			'deleteLxc',
			$params['node'],
			$params['id']
		);

		if ($error) return [
			null, $error
		];

		return [$data];

	}
}