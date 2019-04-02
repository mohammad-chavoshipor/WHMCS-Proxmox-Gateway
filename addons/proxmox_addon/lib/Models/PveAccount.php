<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Models;

use Illuminate\Database\Eloquent\Model;

class PveAccount extends Model
{
    protected $table = 'mod_promox_addon_accounts';
    public $timestamps = false;
}