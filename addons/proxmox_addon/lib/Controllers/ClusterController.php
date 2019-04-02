<?php
namespace WHMCS\Module\Addon\ProxmoxAddon\Controllers;

use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Controller;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Cluster;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Ip;
use WHMCS\Product\Product;

class ClusterController extends Controller 
{
	
	public function indexGetAction()
	{
		return $this->view->render('cluster/list.tpl', [
			'clusters' => Cluster::All()
		]);
	}

	public function addGetAction()
	{
		return $this->view->render('cluster/add.tpl');
	}

	public function addPostAction()
	{

		$cluster = new Cluster();
		$cluster->name = $_POST['name'];

		$cluster->save();

		$this->flash->set('success', $this->trans['flash']['cluster']['success']);
		$this->route->redirect('cluster');

	}

	public function editGetAction()
	{
		$cluster = Cluster::find($_GET['id']);

		if (!$cluster) {
			$this->flash->set('error', $this->trans['flash']['cluster']['not_found']);
			$this->route->redirect('cluster');
		}

		return $this->view->render('cluster/edit.tpl', [
			'cluster' => $cluster
		]);
	}

	public function editPostAction()
	{
		$cluster = Cluster::find($_GET['id']);

		if (!$cluster) {
			$this->flash->set('error', $this->trans['flash']['cluster']['not_found']);
			$this->route->redirect('cluster');
		}

		$cluster->name = $_POST['name'];
		$cluster->save();

		$this->flash->set('success', $this->trans['flash']['cluster']['updated']);
		$this->route->redirect('cluster');
	}

	protected function deleteGetAction()
	{
		$cluster = Cluster::find($_GET['id']);

		if (!$cluster) {
			$this->flash->set('error', $this->trans['flash']['cluster']['not_found']);
			$this->route->redirect('cluster');
		}

		if ($cluster->nodes->count()) {
			$this->flash->set('error', $this->trans['flash']['cluster']['error']);
			$this->route->redirect('cluster');
		}

		$cluster->delete();

		$this->flash->set('success', $this->trans['flash']['cluster']['deleted']);
		$this->route->redirect('index');
	}
}