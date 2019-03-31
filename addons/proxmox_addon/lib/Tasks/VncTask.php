<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Tasks;

use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Task;
use Proxmox\Access;

class VncTask extends Task
{

	public function execute(array $params)
	{

		$password = localAPI('DecryptPassword', [
			'password2' => $this->server->password
		]);

		$ticket = Access::createTicket([
		    'username' => $this->server->username,
		    'password' => $password['password'],
		    'realm' => 'pam'
		]);

		list($vnc, $error) = $this->request(
			'createLxcVncproxy',
			$params['node'],
			$params['id']
		);

		if ($error) return [null, $error];

		return ["https://{$this->server->ipaddress}:8006/novnc/mgnovnc.html?vncticket={$vnc->data->ticket}&token={$ticket->data->ticket}&port={$vnc->data->port}&node=promox&vmid={$params['id']}&virtualization=lxc&UserName={$vnc->data->user}&CSRFPreventionToken={$ticket->data->CSRFPreventionToken}"];
	}

}