<?php
namespace WHMCS\Module\Addon\ProxmoxAddon\Controllers;

use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Controller;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Cluster;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Vm;

use WHMCS\Module\Addon\ProxmoxAddon\Tasks\RunningTask;
use WHMCS\Product\Server;

use Proxmox\Request;
use Proxmox\Nodes;

class ApiController extends Controller 
{
	
	public function networkGetAction()
	{

		$cluster = Cluster::find($_REQUEST['id']);

		if (!$cluster) {
			$this->json([
				'success' => false,
				'message' => 'Cluster not found'
			]);
		}

		if (!$cluster->nodes->count()) {
			$this->json([
				'success' => false,
				'message' => 'No server available in this cluster'
			]);
		}

		$server = $cluster->nodes->first()->server;
		$password = localAPI('DecryptPassword', [
			'password2' => $server->password
		]);

		Request::Login([
			'hostname' => $server->ipaddress,
		    'username' => $server->username,
		    'password' => $password['password'],
		]);
		
		$nodes = new Nodes();
		$net = $nodes->network(
			$nodes->listNodes()->data[0]->node,
			'bridge'
		);

		$interfaces = [];
		foreach ($net->data as $interface) {
			$interfaces[] = $interface->iface;
		}

		$this->json([
			'success' => true,
			'interfaces' => $interfaces
		]);
	}

	public function interfacesGetAction()
	{

		$cluster = Cluster::find($_REQUEST['id']);

		if (!$cluster) {
			$this->json([
				'success' => false,
				'message' => 'Cluster not found'
			]);
		}

		if (!$cluster->interfaces->count()) {
			$this->json([
				'success' => false,
				'message' => 'No interfaces available in this cluster'
			]);
		}

		$interfaces = [];
		foreach ($cluster->interfaces as $interface) {
			$interfaces[] = [
				'id' => $interface->id,
				'name' => $interface->name
			];
		}

		$this->json([
			'success' => true,
			'interfaces' => $interfaces
		]);
	}

	public function statusGetAction()
	{
		$id = $_GET['id'];
		$vm = Vm::where('vmid', $id)->first();

		if (!$vm) {
			$this->json([
				'success' => true,
				'status' => 'error'
			]);
		}

		$server = Server::find($vm->service->server);

		$task = new RunningTask($server);
		list($data, $error) = $task->execute([
			'id' => $id,
			'node' => $vm->node->node,
		]);

		$this->json([
			'success' => true,
			'status' => $data->status ?? 'error'
		]);
	}
}