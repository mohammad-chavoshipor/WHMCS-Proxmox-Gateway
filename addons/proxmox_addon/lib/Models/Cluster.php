<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Models;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    protected $table = 'mod_promox_addon_clusters';
    public $timestamps = false;

    public function nodes()
    {
    	return $this->hasMany(Node::class);
    }

    public function interfaces()
    {
    	return $this->hasMany(NetInterface::class);
    }
}