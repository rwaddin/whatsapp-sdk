<?php

namespace Rumahweb\Services;

use GuzzleHttp\Client;
use Rumahweb\Concerns\HandlesRequest;

class MessageTemplateService {
    use HandlesRequest;

    private $client;
    private $wabaId;

    public function __construct(Client $client, string $wabaId)
    {
        $this->client = $client;    
        $this->wabaId = $wabaId;
    }

    public function send(string $template_name, array $params) {
        $templateParams["to"] = $params["to"] ?? false;
        $templateParams["type"] = "template";
        $templateParams["recipient_type"] = "individual";
        $templateParams["messaging_product"] = "whatsapp";
        $templateParams["template"]["name"] = $template_name;
        $templateParams["template"]["language"]["policy"] = "deterministic";
        $templateParams["template"]["language"]["code"] = "id";

        if (isset($params["header"])) {
            $header = [];
            $header["type"] = "header";
            $header["parameters"] = $params["header"];
            $templateParams["template"]["components"][] = $header;
        }
        if (isset($params["body"])) {
            $body = [];
            $body["type"] = "body";
            $body["parameters"] = $params["body"];
            $templateParams["template"]["components"][] = $body;
        }

        return $this->request(function () use ($templateParams) {
            return $this->client->post("/{$this->wabaId}/messages", [
                'json' => $templateParams
            ]);
        });
    }
}