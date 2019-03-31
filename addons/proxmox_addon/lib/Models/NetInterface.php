<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Models;

use Illuminate\Database\Eloquent\Model;

class NetInterface extends Model
{
    protected $table = 'mod_promox_addon_interfaces';
    public $timestamps = false;

    public function cluster()
    {
    	return $this->belongsTo('WHMCS\Module\Addon\ProxmoxAddon\Models\Cluster');
    }
}