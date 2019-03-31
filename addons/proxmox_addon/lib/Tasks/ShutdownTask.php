<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Tasks;

use Exception;
use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Task;
use WHMCS\Product\Server;

use Proxmox\Nodes;

class ShutdownTask extends Task
{
	public function execute(array $params)
	{

		list($status, $error) = $this->request(
			'lxcCurrent',
			$params['node'],
			$params['id']
		);

		if ($error) return [null, $error];
		if ($status->status === 'stopped') {
			return [
				null, 'Vm already stopped'
			];
		}

		return $this->request(
			'lxcShutdown',
			$params['node'],
			$params['id']
		);
	}

}