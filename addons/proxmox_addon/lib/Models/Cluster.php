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

    public function ips()
    {
        return $this->hasMany(Ip::class);
    }

    public function unusedIps()
    {
        $ips = $this->hasMany(Ip::class);

        $count = 0;
        foreach ($ips->get() as $ip) {
            if (!$ip->used) $count++;
        }

        return $count;
    }

    public function interfaces()
    {
    	return $this->hasMany(NetInterface::class);
    }
}