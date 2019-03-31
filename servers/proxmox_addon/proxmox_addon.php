<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

require_once 'vendor/autoload.php';

use WHMCS\Module\Addon\ProxmoxAddon\Models\Whmcs\Queue;

use Proxmox\Request;
use Proxmox\Cluster;
use Proxmox\Nodes;

require_once 'includes/actions.php';
require_once 'includes/admin.php';
require_once 'includes/client.php';
require_once 'includes/account.php';

function log_queue($service, $action, $error) {

    $queue = Queue::where([
        'service_id' => $service,
        'module_action' => $action,
        'module_name' => 'promox_addon',
        'completed' => false
    ])->first();

    if ($queue) {

        $queue->num_retries += 1;
        $queue->last_attempt = new DateTime();
        $queue->last_attempt_error = $error;

    } else {

        $queue = new Queue();
        $queue->service_type = 'service';
        $queue->service_id = $service;
        $queue->module_name = 'promox_addon';
        $queue->module_action = $action;
        $queue->last_attempt = new DateTime();
        $queue->last_attempt_error = $error;

    }

    $queue->save();
}

function proxmox_addon_MetaData()
{
    return array(
        'DisplayName' => 'Proxmox Addon',
        'RequiresServer' => true,
    );
}

function proxmox_addon_ChangePackage(array $params)
{
    try {
        // Call the service's change password function, using the values
        // provided by WHMCS in `$params`.
        //
        // A sample `$params` array may be defined as:
        //
        // ```
        // array(
        //     'username' => 'The service username',
        //     'configoption1' => 'The new service disk space',
        //     'configoption3' => 'Whether or not to enable FTP',
        // )
        // ```
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'proxmox_addon',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

function proxmox_addon_TestConnection(array $params)
{
    try {

        Request::Login([
            'hostname' => $params['serverip'],
            'username' => $params['serverusername'],
            'password' => $params['serverpassword'],
        ]);

        if (Cluster::Status()) {
            $success = true;
            $errorMsg = '';
        } else {
            $success = false;
            $errorMsg = 'Proxmox API unrechable, check the server\'s credentials.';
        }

    } catch (Exception $e) {

        $errorMsg = $e->getMessage();
        $success = false;

        if ($e->getMessage() === 'Request params empty') {
            $errorMsg = 'Promox is unreachable, check the server\'s IP address';
        }

        logModuleCall(
            'proxmox_addon',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );
    }

    return array(
        'success' => $success,
        'error' => $errorMsg,
    );
}