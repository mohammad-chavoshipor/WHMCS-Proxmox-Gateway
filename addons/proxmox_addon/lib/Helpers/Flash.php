<?php

namespace WHMCS\Module\Addon\ProxmoxAddon\Helpers;


class Flash
{

    public function set($key, $message)
    {
        $_SESSION['mod_limit_flashbag'][$key] = $message;
    }

    public function has($key)
    {
        return isset($_SESSION['mod_limit_flashbag'][$key]);
    }

    public function get($key)
    {
        $message =  $_SESSION['mod_limit_flashbag'][$key];
        unset( $_SESSION['mod_limit_flashbag'][$key]);
        return $message;
    }

}