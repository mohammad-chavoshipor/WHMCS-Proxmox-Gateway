<?php
namespace WHMCS\Module\Addon\ProxmoxAddon\Controllers;

use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Controller;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Cluster;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Ip;

class IpController extends Controller 
{
	
	public function indexGetAction()
	{
		return $this->view->render('ips/list', [
			'ips' => Ip::All()
		]);
	}

	public function addGetAction()
	{
		return $this->view->render('ips/add', [
			'clusters' => Cluster::all()
		]);
	}

	public function addPostAction()
	{  
		$ip = new Ip();
		$ip->ip = $_POST['ip'];
		$ip->netmask = $_POST['netmask'];
		$ip->mac = $_POST['mac'];
		$ip->gateway = $_POST['gateway'];
		$ip->type = $_POST['type'];
		$ip->cluster_id = $_POST['cluster'];
		$ip->active = (bool)$_POST['active'];
		$ip->save();

		$this->flash->set('success', 'Ip ajoutée');
		$this->route->redirect('ip');

	}

	public function editGetAction()
	{
		$ip = Ip::find($_GET['id']);

		if (!$ip) {
			$this->flash->set('error', 'Impossible de trouver l\'ip demandée');
			$this->route->redirect('ip');
		}

		return $this->view->render('ips/edit', [
			'ip' => $ip
		]);
	}

	public function editPostAction()
	{
		$ip = Ip::find($_GET['id']);

		if (!$ip) {
			$this->flash->set('error', 'Impossible de trouver l\'ip demandée');
			$this->route->redirect('ip');
		}

		$ip->active = (bool)$_POST['active'];
		$ip->mac = $_POST['mac'];
		$ip->save();

		$this->flash->set('success', 'Ip mise à jours');
		$this->route->redirect('ip');
	}

	protected function deleteGetAction()
	{
		$ip = Ip::find($_GET['id']);

		if (!$ip) {
			$this->flash->set('error', 'Impossible de trouver l\'ip demandée');
			$this->route->redirect('ip');
		}

		if ($ip->service->count()) {
			$this->flash->set('error', 'Imossible de suppimer l\'ip tant que des services lui sont encore associés.');
			$this->route->redirect('ip');
		}

		$ip->delete();

		$this->flash->set('success', 'Ip supprimée');
		$this->route->redirect('ip');
	}
}