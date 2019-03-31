<?php

namespace WHMCS\Module\Server\ProxmoxAddon\Helpers;

class View {

	private $dir;

    public function __construct($dir)
	{
		$this->dir = rtrim($dir, '/');
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