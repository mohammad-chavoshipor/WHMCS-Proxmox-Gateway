<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Tasks;

use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Task;

class StartTask extends Task
{

	public function execute(array $params)
	{
		list($status, $error) = $this->request(
			'lxcCurrent',
			$params['node'],
			$params['id']
		);

		if ($error) return [null, $error];
		if ($status->status === 'running') {
			return [
				null, 'Vm already running'
			];
		}

		return $this->request(
			'lxcStart',
			$params['node'],
			$params['id']
		);
	}

}