<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Helpers;
use Smarty;

class View {

    private $smarty;

    public function __construct($dir, Route $route = null, Flash $flash = null, $vars = null)
	{
		$templates = rtrim($dir, '/');
		$var = dirname(dirname(__DIR__)) . '/templates';

		$this->vars = $vars;

		$this->smarty = new Smarty();
		$this->smarty->setTemplateDir($dir);
		$this->smarty->setCompileDir("$var/templates_c");

		$this->smarty->assign('route', $route);
		$this->smarty->assign('flash', $flash);
		$this->smarty->assign('action', $_GET['action'] ?? null);
		$this->smarty->assign('trans', $vars['_lang']);
    }

	public function render($name, $args = [])
	{
		$this->smarty->assign($args);
		return $this->smarty->fetch($name);
	}
}