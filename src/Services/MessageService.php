<?php

namespace Rumahweb\Services;

use GuzzleHttp\Client;
use Rumahweb\Concerns\HandlesRequest;

class MessageService {
    
    use HandlesRequest;

    protected Client $client;
    protected $wabaId;

    public function __construct(Client $client, $wabaId)
    {
        $this->client = $client;
        $this->wabaId = $wabaId;
    }

    /**
     * -----------------------------------------------------------------
     * Send Text message
     * @param string $wabaId : whatsapp business account id
     * @param string $to : recipient phone number
     * @param string $message : message text
     * @param string $reply_wamid : opt for reply message
     * -----------------------------------------------------------------
     * */
    public function sendText(string $to, string $message, string $reply_wamid = ''):array
    {
        $endpoint = "/{$this->wabaId}/messages";
        $payload = $this->_initParams($to, $reply_wamid);
        $payload['text']['body'] = $message;

        return $this->request(function () use ($endpoint, $payload) {
            return $this->client->post($endpoint, ['json' => $payload]);
        });
    }

    private function _initParams(string $recipient_phone, string $reply_wamid = ''):array 
    {
        $payload['messaging_product'] = 'whatsapp';
        $payload['recipient_type'] = 'individual';
        $payload['type'] = 'text';
        $payload['to'] = $recipient_phone;

        if ($reply_wamid) {
            $payload['context']["message_id"] = $reply_wamid;
        }

        return $payload;
    }
}