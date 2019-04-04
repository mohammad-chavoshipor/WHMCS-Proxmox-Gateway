<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Models;

use Illuminate\Database\Eloquent\Model;

class Ssh extends Model
{
    protected $table = 'mod_promox_ssh_key';
    public $timestamps = false;

    public function user()
    {
    	return $this->belongsTo('\WHMCS\User');
    }

}