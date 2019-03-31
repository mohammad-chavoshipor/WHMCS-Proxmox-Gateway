<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Models;

use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    protected $table = 'mod_promox_addon_ips';
    public $timestamps = false;

    public function cluster()
    {
    	return $this->belongsTo('WHMCS\Module\Addon\ProxmoxAddon\Models\Cluster');
    }

    public function service()
    {
        return $this->belongsTo('WHMCS\Service\Service');
    }
}