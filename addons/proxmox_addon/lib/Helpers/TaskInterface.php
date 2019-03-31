<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Helpers;
use WHMCS\Product\Server;

interface TaskInterface {

	function __construct(Server $server);
	function execute(array $params);

}