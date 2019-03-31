<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'mod_promox_addon_templates';
    public $timestamps = false;

    public function cluster()
    {
    	return $this->belongsTo('WHMCS\Module\Addon\ProxmoxAddon\Models\Cluster');
    }
}