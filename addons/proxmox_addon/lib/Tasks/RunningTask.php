<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Tasks;

use Exception;
use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Task;
use WHMCS\Product\Server;

use Proxmox\Nodes;

class RunningTask extends Task
{

	public function execute(array $params)
	{
		return $this->request(
			'lxcCurrent',
			$params['node'],
			$params['id']
		);

	}

}