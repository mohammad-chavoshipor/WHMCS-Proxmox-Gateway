<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Tasks;

use Exception;
use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Task;
use WHMCS\Product\Server;

use Proxmox\Nodes;

class RebootTask extends Task
{

	public function execute(array $params)
	{
		list($status, $error) = $this->request(
			'lxcCurrent',
			$params['node'],
			$params['id']
		);

		if ($error) return [
			null, $error
		];

		if ($status->status === 'stopped') {
			return $this->request(
				'lxcStart', 
				$params['node'],
				$params['id']
			);
		}

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

		return $this->request(
			'lxcStart', 
			$params['node'],
			$params['id']
		);
	}

}