<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Models;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    protected $table = 'mod_promox_addon_servers';
    public $timestamps = false;

    public function server()
    {
    	return $this->belongsTo('WHMCS\Product\Server');
    }
}