<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'mod_promox_addon_tasks';

    public const STATUS_PENDING = 1;
    public const STATUS_RUNNING = 2;
    public const STATUS_SUCCESS = 3;
    public const STATUS_FAIL = 4;

    public function service()
    {
    	return $this->belongsTo('\WHMCS\Service\Service');
    }

    public function product()
    {
    	return $this->hasMany('\WHMCS\Product\Product');
    }
}