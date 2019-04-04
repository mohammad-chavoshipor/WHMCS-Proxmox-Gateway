<?php
namespace WHMCS\Module\Addon\ProxmoxAddon\Controllers\Admin;

use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Controller;
use WHMCS\Module\Addon\ProxmoxAddon\Models\NetInterface;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Cluster;
use WHMCS\Product\Product;

class InterfaceController extends Controller 
{
	
	public function indexGetAction()
	{
		return $this->view->render('interface/list.tpl', [
			'interfaces' => NetInterface::All()
		]);
	}

	public function addGetAction()
	{
		return $this->view->render('interface/add.tpl', [
			'clusters' => Cluster::all()
		]);
	}

	public function addPostAction()
	{
		$interface = new NetInterface();
		$interface->name = $_POST['name'];
		$interface->cluster_id = $_POST['cluster'];
		$interface->rate = $_POST['rate'];
		$interface->ip4 = $_POST['ip4'];
		$interface->ip6 = $_POST['ip6'];
		$interface->bridge = $_POST['bridge'];

		$interface->save();

		$this->flash->set('success', 'Interface ajoutée');
		$this->route->redirect('interface');

	}

	public function editGetAction()
	{
		$interface = NetInterface::find($_GET['id']);

		if (!$interface) {
			$this->flash->set('error', 'Impossible de trouver l\'interface demandée');
			$this->route->redirect('interface');
		}

		return $this->view->render('interface/edit.tpl', [
			'interface' => $interface
		]);
	}

	public function editPostAction()
	{
		$interface = NetInterface::find($_GET['id']);

		if (!$interface) {
			$this->flash->set('error', 'Impossible de trouver l\'interface demandée');
			$this->route->redirect('interface');
		}

		$interface->name = $_POST['name'];
		$interface->rate = $_POST['rate'];

		$interface->save();

		$this->flash->set('success', 'Interface mise à jours');
		$this->route->redirect('interface');
	}

	protected function deleteGetAction()
	{
		$interface = NetInterface::find($_GET['id']);

		if (!$interface) {
			$this->flash->set('error', 'Impossible de trouver l\'interface demandée');
			$this->route->redirect('interface');
		}

		$interface->delete();

		$this->flash->set('success', 'interface supprimée');
		$this->route->redirect('interface');
	}
}