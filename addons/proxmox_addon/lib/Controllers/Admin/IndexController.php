<?php
namespace WHMCS\Module\Addon\ProxmoxAddon\Controllers\Admin;

use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Controller;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Cluster;
use WHMCS\Product\Product;

class IndexController extends Controller 
{
	public function indexGetAction()
	{
		return $this->view->render('index.tpl');
	}
}