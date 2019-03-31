<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Helpers;

use Exception;

use WHMCS\Product\Server;

use Proxmox\Nodes;
use Proxmox\Request;

abstract class Task implements TaskInterface {

	public $nodes;
	public $server;

	public function __construct(Server $server)
	{
		$this->nodes = new Nodes();
		$this->server = $server;
		
		$password = localAPI('DecryptPassword', [
			'password2' => $server->password
		]);

		Request::Login([
			'hostname' => $server->ipaddress,
		    'username' => $server->username,
		    'password' => $password['password'],
		]);      
	}

	public function getNode() 
	{
		return $this->nodes->listNodes()->data[0]->node;
	}

	public function request($action, ...$args)
	{

		try {
	    
	    	$response = call_user_func_array([$this->nodes, $action], $args);
	    	if (!$response->data) {

	    		return [
	    			null,
	    			$response->errors ? 'API responded with an unknown error (See logs module for more details).' : 'API responded with an unknown error.'
	    		];

	    		if ($response->errors) {
	    			logModuleCall(
			            'proxmox_addon',
			            __FUNCTION__,
			            $params,
			            'API responded with an unknown error.'
			        );
	    		}
	    	} 

	    	return [
	    		$response->data,
	    	];

	    } catch (Exception $e) {

	        $errorMsg = $e->getMessage();

	        if ($e->getMessage() === 'Request params empty') {
	            $errorMsg = 'Promox is unreachable !';
	        }

	        logModuleCall(
	            'proxmox_addon',
	            __FUNCTION__,
	            $params,
	            $e->getMessage(),
	            $e->getTraceAsString()
	        );

	        return [
	    		null,
	    		$errorMsg
	    	];
	    }

	}

}