<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Helpers;

class Route {

	private $root;

	public function __construct($moduleLink)
    {
        $this->root = $moduleLink;
    }

	public function to($action, $args = [])
	{

	    $args = http_build_query($args);
	    if ($args) {
			return $this->root."&action=$action&$args";
	    }

		return $this->root."&action=$action";
	}

	public function redirect($action, $args = [])
	{
		header('Location:'. $this->to($action, $args));
		exit;
	}
}