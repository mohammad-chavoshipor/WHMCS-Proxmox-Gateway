<?php

use WHMCS\Database\Capsule;
use WHMCS\Module\Addon\ProxmoxAddon\Helpers\Dispatcher;
use WHMCS\Module\Addon\ProxmoxAddon\Models\Whmcs\Queue;

require_once 'vendor/autoload.php';

if (!defined("WHMCS")) {
	die("This file cannot be accessed directly");
}

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

function proxmox_addon_config()
{
	return [
		'name' => 'Promox Gateway',
		'description' => '',
		'author' => 'Uneo7',
		'version' => '1.0',
		'fields' => array(
			'username_prefix' => array (
				'FriendlyName' => 'Username prefix',
				'Type' => 'text',
				'Size' => '100',
				'Default' => 'Gateway' 
			),
	
		)
	];
}

function proxmox_addon_activate()
{
	try {
		Capsule::schema()
			->create(
				'mod_promox_addon_ips',
				function ($table) {
					$table->increments('id');
					$table->string('ip');
					$table->string('netmask');
					$table->integer('type');
					$table->string('gateway');
					$table->string('mac');
					$table->boolean('used');
					$table->boolean('active');
					$table->integer('service_id');
					$table->integer('cluster_id');
				}
			);

		 Capsule::schema()
			->create(
				'mod_promox_addon_vms',
				function ($table) {
					$table->increments('id');
					$table->string('vmid');
					$table->integer('service_id');
					$table->integer('node_id');
				}
			);

		Capsule::schema()
			->create(
				'mod_promox_addon_clusters',
				function ($table) {
					$table->increments('id');
					$table->string('name');
				}
			);

		Capsule::schema()
			->create(
				'mod_promox_addon_templates',
				function ($table) {
					$table->increments('id');
					$table->string('name');
					$table->text('image');
					$table->integer('cluster_id');
				}
			);

		Capsule::schema()
			->create(
				'mod_promox_addon_interfaces',
				function ($table) {
					$table->increments('id');
					$table->string('name');
					$table->string('bridge');
					$table->float('rate');
					$table->string('ip4');
					$table->string('ip6');
					$table->integer('cluster_id');
				}
			);

		Capsule::schema()
			->create(
				'mod_promox_addon_servers',
				function ($table) {
					$table->increments('id');
					$table->text('node');
					$table->integer('cluster_id');
					$table->integer('server_id');
					$table->boolean('active');
				}
			);

		Capsule::schema()
			->create(
				'mod_promox_addon_tasks',
				function ($table) {
					$table->increments('id');
					$table->integer('service_id');
					$table->integer('product_id');
					$table->string('task');
					$table->string('status');
					$table->text('params');
					$table->string('proxmox');
					$table->text('message');
				}
			);

		Capsule::schema()
			->create(
				'mod_promox_ssh_key',
				function ($table) {
					$table->increments('id');
					$table->integer('user_id');
					$table->text('fingerprint');
					$table->text('key');
				}
			);

		return [
			'status' => 'success',
			'description' => 'Modulé installé'
		];
	} catch (\Exception $e) {
		return [
			'status' => "error",
			'description' => 'Impossible de créer la table : ' . $e->getMessage(),
		];
	}
}

function proxmox_addon_deactivate()
{
	try {
		Capsule::schema()->dropIfExists('mod_promox_addon_ips');
		Capsule::schema()->dropIfExists('mod_promox_addon_clusters');
		Capsule::schema()->dropIfExists('mod_promox_addon_templates');
		Capsule::schema()->dropIfExists('mod_promox_addon_servers');
		Capsule::schema()->dropIfExists('mod_promox_addon_interfaces');
		Capsule::schema()->dropIfExists('mod_promox_addon_tasks');

		return [
			'status' => 'success',
			'description' => 'Désinstallation terminée'
		];
	} catch (\Exception $e) {
		return [
			"status" => "error",
			"description" => "Impossible de suprimer la table: {$e->getMessage()}",
		];
	}
}

function proxmox_addon_output($vars)
{
	$dispatcher = new Dispatcher(
		__DIR__. '/templates/admin',
		$vars['modulelink'],
		$_REQUEST['action'],
		$_REQUEST['method'],
		$vars
	);

	echo $dispatcher->dispatch('Admin');
}

function proxmox_addon_clientarea($vars)
{

	$dispatcher = new Dispatcher(
		__DIR__. '/templates/client',
		$vars['modulelink'],
		$_REQUEST['action'],
		$_REQUEST['method'],
		$vars
	);

	return $dispatcher->dispatch('Client');
}