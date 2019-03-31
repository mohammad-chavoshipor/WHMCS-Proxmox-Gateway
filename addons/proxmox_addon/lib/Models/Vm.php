<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Models;

use Illuminate\Database\Eloquent\Model;

class Vm extends Model
{
    protected $table = 'mod_promox_addon_vms';
    public $timestamps = false;

    public function service()
    {
    	return $this->belongsTo('\WHMCS\Service\Service');
    }

    public function node()
    {
    	return $this->belongsTo('WHMCS\Module\Addon\ProxmoxAddon\Models\Node');
    }

}