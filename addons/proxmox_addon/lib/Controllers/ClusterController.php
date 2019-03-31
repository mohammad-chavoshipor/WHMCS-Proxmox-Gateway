<?php
namespace WHMCS\Module\Addon\ProxmoxAddon\Controllers;

use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Controller;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Cluster;
use WHMCS\Product\Product;

class ClusterController extends Controller 
{
	
	public function indexGetAction()
	{
		return $this->view->render('cluster/list', [
			'clusters' => Cluster::All()
		]);
	}

	public function addGetAction()
	{
		return $this->view->render('cluster/add');
	}

	public function addPostAction()
	{

		$cluster = new Cluster();
		$cluster->name = $_POST['name'];

		$cluster->save();

		$this->flash->set('success', 'Cluster ajouté');
		$this->route->redirect('cluster');

	}

	public function editGetAction()
	{
		$cluster = Cluster::find($_GET['id']);

		if (!$cluster) {
			$this->flash->set('error', 'Impossible de trouver le cluster demandé');
			$this->route->redirect('cluster');
		}

		return $this->view->render('cluster/edit', [
			'cluster' => $cluster
		]);
	}

	public function editPostAction()
	{
		$cluster = Cluster::find($_GET['id']);

		if (!$cluster) {
			$this->flash->set('error', 'Impossible de trouver le cluster demandé');
			$this->route->redirect('cluster');
		}

		$cluster->name = $_POST['name'];
		$cluster->save();

		$this->flash->set('success', 'Cluster mis à jours');
		$this->route->redirect('cluster');
	}

	protected function deleteGetAction()
	{
		$cluster = Cluster::find($_GET['id']);

		if (!$cluster) {
			$this->flash->set('error', 'Impossible de trouver le cluster demandé');
			$this->route->redirect('cluster');
		}

		if ($cluster->nodes->count()) {
			$this->flash->set('error', 'Imossible de suppimer le cluster tant que des serveurs lui sont encore associés.');
			$this->route->redirect('cluster');
		}

		$cluster->delete();

		$this->flash->set('success', 'Cluster supprimé');
		$this->route->redirect('index');
	}
}