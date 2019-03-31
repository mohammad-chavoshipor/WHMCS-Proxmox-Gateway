<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Tasks;

use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Task;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Cluster;
use WHMCS\Module\Addon\ProxmoxAddon\Models\NetInterface;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Ip;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Vm;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Node;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Template;

use WHMCS\Product\Server;
use WHMCS\Service\Service;

use Proxmox\Nodes;

class CreateTask extends Task
{

	private function buildInterface(Cluster $cluster, $interface, $name, $service)
	{
		$interface = NetInterface::find($interface);
		$net = "bridge={$interface->bridge},name=$name";

		if ($interface->ip4 === 'static') {
			$ip = $this->getIp($service, $cluster, 4);
			if (!$ip) {
				log_queue($service->id, 'CreateAccount', "No enough IPv4 adresses available in cluster : {$cluster->name}");
				return false;
			}

			if ($ip->mac) $net .= ",hwaddr={$ip->mac}";
			
			$net .= ",ip={$ip->ip}/{$ip->netmask},gw={$ip->gateway}";
			$this->ip4 = $ip;

		} else {
			$net .= ',ip=dhcp';
		}

		if ($interface->ip6 === 'static') {
			$ip = $this->getIp($service, $cluster, 4);
			if (!$ip) {
				log_queue($service->id, 'CreateAccount', "No enough IPv6 adresses available in cluster : {$cluster->name}");
				return false;
			}

			if ($ip->mac) $net .= ",hwaddr={$ip->mac}";
			
			$net .= ",ip6={$ip->ip}/{$ip->netmask},gw6={$ip->gateway}";
			$this->ip6 = $ip;

		} else if ($interface->ip6 === 'dhcp') {
			$net .= ',ip6=dhcp';
		} else {
			$net .= ',ip6=auto';
		}

		if ($interface->rate) $net .= ",rate={$interface->rate}";

		return $net;
	}

	private function parseDescription($description, Service $service)
	{
		$description = str_replace('{$client_name}', "{$service->client->firstName} {$service->client->lastName}", $description);
		$description = str_replace('{$client_id}', $service->client->id, $description);
		$description = str_replace('{$client_email}', $service->client->email, $description);
		$description = str_replace('{$service_id}', $service->id, $description);
		$description = str_replace('{$product_name}', $service->product->name, $description);
		$description = str_replace('{$product_id}', $service->product->id, $description);
		
		return $description;
	}

	private function getIp(Service $service, Cluster $cluster, $type)
	{

		$ip = Ip::where([
			'used' => false,
			'active' => true,
			'type' => $type,
			'cluster_id' => $cluster->id
		])->first();

		if (!$ip) return false;

		if ($service->dedicatedip) {
			$service->assignedips .= $ip->ip . '
';
		} else {
			$service->dedicatedip = $ip->ip;
		}

		$ip->used = true;
		$ip->service_id = $service->id;
		$ip->save();

		$service->username = 'root';
		$service->save();

		return $ip;
	}

	public function execute(array $params)
	{

		$service = Service::find($params['service']);
		$server = Node::find($params['node']);
		$template = Template::find($params['template']);

		if (!$template) {
			$template = Template::where('cluster_id', $server->cluster_id)->first();
		}

		$nextId = (new \Proxmox\Cluster)->nextVmid();

		$product = $service->product;
		$cluster = Cluster::find($product->configoption2);

		$description = $this->parseDescription($product->configoption4, $service);
		$password = localAPI('DecryptPassword', [
			'password2' => $service->password
		]);

		$create = [
            'vmid'        => $params['id'] ?? $nextId->data,

            'onboot' 	  => (bool) $product->configoption3,
            'description' => $description,
            'start'       => true,
          	'hostname'    => $service->domain ?? $nextId->data,

            'rootfs'      => "{$product->configoption7}:{$product->configoption6}",
			'ostemplate'  => $template->image,

            'memory'      => $product->configoption8,
            'swap'        => $product->configoption9,
            'password' 	  => $password['password'],			
		];

		if ($product->configoption5) {
			$create['cores'] = $product->configoption5;
		}

		if ($params['net']) {
			$create = array_merge($create, $params['net']);
		} else {
			if ($product->configoption13 && $product->configoption13 > -1) $create['net0'] = $this->buildInterface($cluster, $product->configoption13 , 'eth0', $service);
			if ($product->configoption14 && $product->configoption14 > -1) $create['net1'] = $this->buildInterface($cluster, $product->configoption14 , 'eth1', $service);
			if ($product->configoption15 && $product->configoption15 > -1) $create['net2'] = $this->buildInterface($cluster, $product->configoption15 , 'eth2', $service);
			if ($product->configoption16 && $product->configoption16 > -1) $create['net3'] = $this->buildInterface($cluster, $product->configoption16 , 'eth3', $service);

			if (
				($product->configoption13 && $product->configoption13 > -1 && $create['net0'] === false) || 
				($product->configoption14 && $product->configoption14  > -1 && $create['net1'] === false) || 
				($product->configoption15 && $product->configoption15  > -1 && $create['net2'] === false) || 
				($product->configoption16 && $product->configoption16  > -1 && $create['net3'] === false)
			) {

				$ips = Ip::where('service_id', $service->id)->get();
				foreach ($ips as $ip) {
					$ip->service_id = null;
					$ip->used = false;
					$ip->save();
				}

				$service->dedicatedip = '';
				$service->assignedips = '';
				$service->save();

				return [
					null, 
					"VM Creation failed with error : Network creation failed"
				];
			}
		}
var_dump($create);

		list($data, $error) = $this->request(
			'createLxc',
			$server->node,
			$create
		);

		if ($error) {
			log_queue($service->id, 'CreateAccount', "VM Creation failed with error : $error");
			return [
				null, 
				"VM Creation failed with error : $error"
			];
		}
		if (!$params['id']) {
			$id = explode(':', $data)[6];
			$vm = new Vm();
			$vm->vmid = $id;
			$vm->service_id = $service->id;
			$vm->node_id = $server->id;
			$vm->save();
		}
	

		return [
			$data
		];
	}
}