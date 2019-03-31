<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Tasks;

use Exception;
use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Task;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Vm;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Node;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Template;

use WHMCS\Product\Server;
use WHMCS\Service\Service;

use Proxmox\Nodes;

class ReinstallTask extends Task
{

	public function execute(array $params)
	{
		$service = Service::find($params['service']);
		$server = Node::find($params['node']);
		$vm = Vm::where('service_id', $params['service'])->first();

		list($data, $error) = $this->request(
			'lxcConfig',
			$server->node,
			$vm->vmid
		);

		if ($error) return [null, $error];
	
		$net = [];
		$net['net0'] = $data->net0 ?? null;
		$net['net1'] = $data->net1 ?? null;
		$net['net2'] = $data->net2 ?? null;
		$net['net3'] = $data->net3 ?? null;
		$net = array_filter($net);

		$drop = new DropTask($this->server);
		list($data, $error) = $drop->execute([
			'node'    		=> $server->node,
			'id' 	  		=> $vm->vmid,
	        'service' 		=> $params['service'],
	        'preserve-data' => true
		]);

		if ($error) return [null, $error];


		$create = new CreateTask($this->server);
		list($data, $error) = $create->execute([
			'node'    	=> $params['node'],
			'id' 	  	=> $vm->vmid,
	        'service' 	=> $params['service'],
			'template' 	=> $params['template'],
	        'net' 		=> $net
		]);

		if ($error) return [null, $error];

		return [$data];

		
	}

}