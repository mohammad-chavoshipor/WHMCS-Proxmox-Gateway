<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Models\Whmcs;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $table = 'tblmodulequeue';

   	public function service()
    {
    	return $this->belongsTo('\WHMCS\Service\Service');
    }
}
