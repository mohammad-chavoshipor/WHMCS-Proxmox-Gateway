# WHMCS Proxmox Gateway

Because fuck modulegarden.

##Requirements
WHMCS 7+, Proxmox 5+

Works only with LXC for the moment. Quemu support will be added soon.

##Installation
* Step 1 : Upload the module into your whmcs folder and enable the module. 
* Step 2 : Upload the proxmox folder content into `/usr/share/novnc-pve` (on your proxmox server obviously)
* Step 3: Setup a crontab calling every minutes /modules/servers/proxmox_addon/cron.php

##New features 
Just open an issue if you need something.

##Documentation
WIP