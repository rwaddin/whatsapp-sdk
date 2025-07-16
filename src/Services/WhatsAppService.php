<?php

namespace Rumahweb\Services;

use GuzzleHttp\Client;
use Rumahweb\Services\WabaService;
use Rumahweb\Services\MessageService;
use Rumahweb\Services\MessageTemplateService;

class WhatsAppService {
    
    protected $token;
    protected $baseUrl;
    protected Client $client;

    public function __construct(string $token, string $baseUrl)
    {
        $this->token = $token;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => "Bearer {$this->token}",
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    public function waba(): WabaService {
        return new WabaService($this->client);
    }

    public function message(string $wabaId): MessageService {
        if (!$wabaId) {
            throw new \Exception("Missing wabaId");
        }
        return new MessageService($this->client, $wabaId);
    }

    public function template(string $wabaId): MessageTemplateService {
        return new MessageTemplateService($this->client, $wabaId);
    }

}
