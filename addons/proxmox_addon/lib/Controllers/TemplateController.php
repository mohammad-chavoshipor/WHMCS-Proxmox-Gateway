<?php
namespace WHMCS\Module\Addon\ProxmoxAddon\Controllers;

use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Controller;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Cluster;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Template;

class TemplateController extends Controller 
{
		
	public function indexGetAction()
	{
		return $this->view->render('template/list', [
			'templates' => Template::All()
		]);
	}

	public function addGetAction()
	{
		return $this->view->render('template/add', [
			'clusters' => Cluster::all()
		]);
	}

	public function addPostAction()
	{  
		$template = new Template();
		$template->name = $_POST['name'];
		$template->image = $_POST['image'];
		$template->cluster_id = $_POST['cluster'];
		$template->save();

		$this->flash->set('success', 'Template ajoutée');
		$this->route->redirect('template');
	}

	public function editGetAction()
	{
		$template = Template::find($_GET['id']);

		if (!$template) {
			$this->flash->set('error', 'Impossible de trouver la template demandée');
			$this->route->redirect('template');
		}

		return $this->view->render('template/edit', [
			'template' => $template,
			'clusters' => Cluster::all()
		]);
	}

	public function editPostAction()
	{
		$template = Template::find($_GET['id']);

		if (!$template) {
			$this->flash->set('error', 'Impossible de trouver la template demandée');
			$this->route->redirect('template');
		}

		$template->name = $_POST['name'];
		$template->image = $_POST['image'];
		$template->cluster_id = $_POST['cluster'];
		$template->save();

		$this->flash->set('success', 'Template mise à jours');
		$this->route->redirect('template');
	}

	protected function deleteGetAction()
	{
		$template = Template::find($_GET['id']);

		if (!$template) {
			$this->flash->set('error', 'Impossible de trouver la template demandée');
			$this->route->redirect('template');
		}

		$template->delete();

		$this->flash->set('success', 'Template supprimée');
		$this->route->redirect('template');
	}
}