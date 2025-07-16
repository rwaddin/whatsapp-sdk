<?php

namespace Rumahweb\Services;

use GuzzleHttp\Client;
use Rumahweb\Concerns\HandlesRequest;

class WabaService {
    use HandlesRequest;

    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get(string $wabaId): array {
        $endpoint = "/{$wabaId}";
        return $this->request(function () use ($endpoint) {
            return $this->client->get($endpoint);
        });
    }

    public function phone_numbers(string $wabaId): array {
        $endpoint = "/{$wabaId}/phone_numbers";

        return $this->request(function () use ($endpoint) {
            return $this->client->get($endpoint);
        });
    }

    public function owned(string $wabaId): array {
        $endpoint = "/{$wabaId}/owned_whatsapp_business_accounts";

        return $this->request(function () use ($endpoint) {
            return $this->client->get($endpoint);
        });
    }

    public function shared(string $wabaId): array {
        $endpoint = "/{$wabaId}/client_whatsapp_business_accounts";

        return $this->request(function () use ($endpoint) {
            return $this->client->get($endpoint);
        });
    }
}