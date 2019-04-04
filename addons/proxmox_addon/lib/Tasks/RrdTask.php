<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Tasks;

use Exception;
use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Task;
use WHMCS\Product\Server;

use Proxmox\Nodes;

class RrdTask extends Task
{

	public function execute(array $params)
	{
		return $this->request(
			'lxcRrdData',
			$params['node'],
			$params['id'],
			$params['timeframe']
		);

	}

}