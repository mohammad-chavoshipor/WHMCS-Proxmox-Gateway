<?php
namespace WHMCS\Module\Addon\ProxmoxAddon\Controllers;

use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Controller;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Cluster;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Node;
use WHMCS\Product\Server;
use WHMCS\Product\Product;


class ServerController extends Controller 
{
	
	private function check()
	{
		$cluster = Cluster::find($_GET['cluster']);

		if (!$cluster) {
			$this->flash->set('error', 'Impossible de trouver le cluster demandé');
			$this->route->redirect('cluster');
		}

		return $cluster;
	}

	public function indexGetAction()
	{
		$cluster = $this->check();

		return $this->view->render('server/list', [
			'cluster' => $cluster
		]);
	}

	public function addGetAction()
	{
		$cluster = $this->check();

		return $this->view->render('server/add', [
			'servers' => Server::All(),
			'cluster' => $cluster
		]);
	}

	public function addPostAction()
	{
		$cluster = $this->check();

		if (Node::where('server_id', $_POST['server'])->first()) {
			$this->flash->set('danger', 'Ce serveur appartiens déjà à un cluster !');
			$this->route->redirect('server', ['cluster' => $cluster->id]);
		}

		$server = new Node();
		$server->node = $_POST['node'];
		$server->active = (bool)$_POST['active'];
		$server->cluster_id = $cluster->id;
		$server->server_id = $_POST['server'];

		$server->save();

		$this->flash->set('success', 'Serveur ajouté');
		$this->route->redirect('server', ['cluster' => $cluster->id]);

	}

	public function editGetAction()
	{
		$cluster = $this->check();

		$node = Node::find($_GET['id']);

		if (!$node) {
			$this->flash->set('error', 'Impossible de trouver le serveur demandé');
			$this->route->redirect('server', ['cluster' => $cluster->id]);
		}

		return $this->view->render('server/edit', [
			'node' => $node
		]);
	}

	public function editPostAction()
	{
		$cluster = $this->check();
		$node = Node::find($_GET['id']);

		if (!$node) {
			$this->flash->set('error', 'Impossible de trouver le serveur demandé');
			$this->route->redirect('server', ['cluster' => $cluster->id]);
		}

		$node->active = $_POST['active'];
		$node->node = $_POST['node'];
		$node->save();

		$this->flash->set('success', 'Serveur mis à jours');
		$this->route->redirect('server', ['cluster' => $cluster->id]);
	}

	public function deleteGetAction()
	{
		$cluster = $this->check();
		$node = Node::find($_GET['id']);

		if (!$node) {
			$this->flash->set('error', 'Impossible de trouver le serveur demandé');
			$this->route->redirect('server', ['cluster' => $cluster->id]);
		}

		if ($node->server->services->count()) {
			$this->flash->set('error', 'Impossible de supprimer le serveur demandé. Vous devez supprimez tous les services qui lui sont associés.');
			$this->route->redirect('server', ['cluster' => $cluster->id]);
		}

		$node->delete();

		$this->flash->set('success', 'Serveur supprimé');
		$this->route->redirect('server', ['cluster' => $cluster->id]);
	}
}