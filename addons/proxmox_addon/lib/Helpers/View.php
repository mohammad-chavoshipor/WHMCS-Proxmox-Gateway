<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Helpers;

class View {

	private $dir;
	private $route;
    private $flash;

    public function __construct($dir, Route $route, Flash $flash)
	{
		$this->dir = rtrim($dir, '/');

		$this->route = $route;
        $this->dir = $dir;
        $this->flash = $flash;
    }

	public function render($name, $args = [])
	{
		if (!is_file($this->dir . '/' . $name . '.php')) {
			throw new  \Exception('View : ' . $this->dir . '/' .$name .'.php not found');
		}

		ob_start();
			extract($args);
			include $this->dir.'/'.$name.'.php';
		$content = ob_get_clean();

		return $content;
	}
}