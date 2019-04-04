<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Helpers;

class Dispatcher {

    protected $templateDir;
    protected $route;
    private $action;
    private $vars;
    private $method;

    public function __construct($templateDir, $moduleLink, $action = false, $method = false, $vars = false)
    {
        $this->templateDir = $templateDir;
        $this->route = new Route($moduleLink);
        $this->action = $action;
        $this->vars = $vars;
        $this->method = $method;
    }


    public function dispatch($namespace)
    {
        if (!$this->action) $this->action = 'index';
        if (!$this->method) $this->method = 'index';

        $method = $this->method . 'GetAction';
        if ($_POST) $method = $this->method . 'PostAction';

        $class = "WHMCS\Module\Addon\ProxmoxAddon\Controllers\\$namespace\\{$this->action}Controller";

        if (class_exists($class)) {
            $class = new $class(
                $this->templateDir,
                $this->route,
                $this->action,
                $this->vars
            );
            
            return $class->$method($this->vars);
        }
        

        return '<div class="alert alert-danger"><strong> Erreur :</strong> Impossible de trouver l\'action demandée</div>';
    }
}