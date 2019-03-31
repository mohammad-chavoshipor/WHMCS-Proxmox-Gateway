<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Helpers;

abstract class Controller {

	protected $view;
    protected $route;
    protected $flash;
    private $action;
    private $vars;

    public function __construct($templateDir, $route, $action = false, $vars = false)
    {
        $this->route = $route;
        $this->flash = new Flash();

        $this->view = new View(
            $templateDir,
            $this->route,
            $this->flash
        );
        
        $this->action = $action;
        $this->vars = $vars;
    }

    public function json($data)
    {
        header('Content-type: application/json');
        exit(json_encode($data));
    }

    public function dd($var)
    {
        echo '<pre>';
        var_dump($var);
        die;
    }
}