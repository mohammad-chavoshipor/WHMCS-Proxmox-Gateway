<?php


function proxmox_addon_ClientAreaCustomButtonArray()
{
    return array(
        'Contrôles' => 'controls',
        'Paramètres' => 'settings',
        'Sécurité' => 'firewall',
        'Statistiques' => 'stats',
        'Réinstallation' => 'reset',
    );
}

function proxmox_addon_ClientArea(array $params)
{
    return array(
        'tabOverviewReplacementTemplate' => '../templates/client/overview.tpl',
        'vars' => [],
    );
}
