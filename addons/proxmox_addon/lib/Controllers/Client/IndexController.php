<?php
namespace WHMCS\Module\Addon\ProxmoxAddon\Controllers\Client;

use WHMCS\Module\Addon\ProxmoxAddon\Helpers\FingerprintGenerator;

use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Controller;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Cluster;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Ssh;

use WHMCS\Product\Product;

class IndexController extends Controller 
{
	public function indexGetAction()
	{

		$ssh = Ssh::where('user_id', $_SESSION['uid'])->get();

		return [
			'pagetitle' => 'SSH Keys management',
			'breadcrumb' => ['SSH Keys management'],
			'templatefile' => 'templates/client/index.tpl',
			'requirelogin' => true,
			'vars' => [
				'flash' => $this->flash,
				'ssh' => $ssh
			],
		];
	}

	public function addGetAction()
	{
		return [
			'pagetitle' => 'Add SSH key',
			'breadcrumb' => [
				'index.php?m=proxmox_addon' => 'SSH Keys management',
				'' => 'Add SSH key'
			],
			'templatefile' => 'templates/client/add.tpl',
			'requirelogin' => true,
		];
	}

	public function deleteGetAction()
	{

		$ssh = Ssh::where([
			'user_id' => $_SESSION['uid'],
			'id' => $_REQUEST['id']
		])->first();


		if (!$ssh) {
			$this->flash->set('error', 'Key not found');
			$this->route->redirect('index');
		}

		$ssh->delete();

		$this->flash->set('success', 'Key deleted');
		$this->route->redirect('index');
	}

	public function addPostAction($vars)
	{

		if (empty($_POST['key'])) {
			$this->flash->set('success', 'Inalid key');
			$this->route->redirect('index');
		}

		if (empty($_POST['name'])) {
			$this->flash->set('success', 'Inalid name');
			$this->route->redirect('index');
		}

		$ssh = new Ssh();
		$ssh->user_id = $_SESSION['uid'];
		$ssh->name = $_POST['name'];
		$ssh->key = $_POST['key'];
		$ssh->save();

		$this->flash->set('success', 'Key added');
		$this->route->redirect('index');
	}
}