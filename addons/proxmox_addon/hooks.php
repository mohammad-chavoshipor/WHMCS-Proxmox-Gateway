<?php
if (!defined("WHMCS"))
	die("This file cannot be accessed directly");


use WHMCS\View\Menu\Item as MenuItem;
use WHMCS\Service\Service;

add_hook('ClientAreaSecondaryNavbar', 1, function (MenuItem $secondarySidebar)
{
	$navItem = $secondarySidebar->getChild('Account');
	if (is_null($navItem)) return;
	
	$navItem->addChild('ssh-keys', array(
		'label' => 'SSH keys',
		'uri' => '#'
	));

});


add_hook('ClientAreaPrimarySidebar', 1, function (MenuItem $menu)
{

	if ($_REQUEST['action'] !== 'productdetails') return;

	$service = Service::find($_REQUEST['id']);
	if (!$service) return;
	if ($service->product->servertype !== 'proxmox_addon') return;

	$menu
		->removeChild('Service Details Overview')
		->removeChild('Service Details Actions');

	$menu->addChild('server-management', array(
		'label' => 'Server management',
		'icon' => 'fas fa-server',
	));

	$submenu = $menu->getChild('server-management');

	$submenu->addChild('dashboard', array(
		'uri' => "clientarea.php?action=productdetails&id={$_REQUEST['id']}",
		'order' => 0,
		'label' => 'Dashboard',
		'icon' => 'fas fa-tachometer-alt',
	));

	if (!$_REQUEST['method']) {
		$submenu->getChild('dashboard')->setClass('active');
	}
	
	$submenu->addChild('stats', array(
		'uri' => "clientarea.php?action=productdetails&id={$_REQUEST['id']}&method=stats",
		'order' => 1,
		'label' => 'Statistics',
		'icon' => 'fas fa-chart-pie',
	));

	if ($_REQUEST['method'] === 'stats') {
		$submenu->getChild('stats')->setClass('active');
	}
	
	$submenu->addChild('firewall', array(
		'uri' => "clientarea.php?action=productdetails&id={$_REQUEST['id']}&method=firewall",
		'order' => 2,
		'label' => 'Firewall',
		'icon' => 'fas fa-shield',
	));

	if ($_REQUEST['method'] === 'firewall') {
		$submenu->getChild('firewall')->setClass('active');
	}
	
	$submenu->addChild('backups', array(
		'uri' => "clientarea.php?action=productdetails&id={$_REQUEST['id']}&method=backups",
		'order' => 3,
		'label' => 'Bakups',
		'icon' => 'fas fa-box',
	));

	if ($_REQUEST['method'] === 'backups') {
		$submenu->getChild('backups')->setClass('active');
	}
});

add_hook('ClientAreaSecondarySidebar', 1, function (MenuItem $menu)
{

	if ($_REQUEST['action'] !== 'productdetails') return;
	$service = Service::find($_REQUEST['id']);

	if (!$service) return;
	if($service->product->servertype !== 'proxmox_addon') return;

	$menu->addChild('product-details', array(
		'label' => 'Product details',
		'icon' => 'fas fa-receipt',
	));

	$submenu = $menu->getChild('product-details');

	$submenu->addChild('upgrade', array(
		'uri' => "upgrade.php?type=package&id={$_REQUEST['id']}",
		'order' => 0,
		'label' => 'Upgrade',
		'icon' => 'fas fa-wrench',
	));
	
	$submenu->addChild('cancel', array(
		'uri' => "clientarea.php?action=cancel&id={$_REQUEST['id']}",
		'order' => 1,
		'label' => 'Cancel',
		'icon' => 'fas fa-times-circle',
	));
});