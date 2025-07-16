<?php

namespace Rumahweb;

class Webhook {

    private $hook;
    public function __construct(array $hook) {
        $this->hook = $hook;
    }

    public function getMessage(){
        try {
            if (!isset($this->hook['entry'][0]['changes'][0]['value'])) {
                throw new \Exception("Webhook message malformed.");
            }

            $hook = $this->hook['entry'][0]['changes'][0]['value'];

            $result = [];
            $result["phone_display"] = $hook["metadata"]["display_phone_number"] ?? "";
            $result["phone_id"] = $hook["metadata"]["phone_number_id"] ?? "";
            $result["hook_type"] = 'message';

            if (isset($hook["contacts"][0])) {
                $result["from_name"] = $hook["contacts"][0]["profile"]["name"] ?? "";
                $result["from_phone"] = $hook["contacts"][0]["wa_id"] ?? "";
            }

            if (isset($hook["messages"][0])) {
                $result["wamid"] = $hook["messages"][0]["id"] ?? "";
                $result["timestamp"] = $hook["messages"][0]["timestamp"] ?? "";
                $result["type"] = $hook["messages"][0]["type"] ?? "";
                $result["text"] = $hook["messages"][0]["text"]["body"] ?? "";
            }

            # for status
            if (isset($hook["statuses"][0])) {
                $result["hook_type"] = 'status';
                $result["wamid"] = $hook["statuses"][0]["id"] ?? "";
                $result["status"] = $hook["statuses"][0]["status"] ?? "";
                $result["timestamp"] = $hook["statuses"][0]["timestamp"] ?? "";
                $result["recipient_phone"] = $hook["statuses"][0]["recipient_id"] ?? "";
            }

            return $result;
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getMessageRaw() {
        return $this->hook;
    }
}