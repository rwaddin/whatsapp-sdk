<?php

namespace Rumahweb;

use Rumahweb\Services\WhatsAppService;

class WhatsApp
{
    protected static ?WhatsAppService $instance = null;

    public static function init(string $token, string $baseUrl = 'https://graph.facebook.com/v23.0'): WhatsAppService
    {
        self::$instance = new WhatsAppService($token, $baseUrl);
        return self::$instance;
    }

    public static function __callStatic($method, $args)
    {
        if (!self::$instance) {
            throw new \Exception("WhatsApp facade not initialized. Call WhatsApp::init(\$token) first.");
        }

        return call_user_func_array([self::$instance, $method], $args);
    }
}