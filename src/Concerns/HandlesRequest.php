<?php

namespace Rumahweb\Concerns;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

trait HandlesRequest
{
    protected function request(callable $callback): array
    {
        try {
            $response = $callback();
            return json_decode($response->getBody(), true);
        } 
        
        catch (ClientException $e) {
            return json_decode($e->getResponse() ? $e->getResponse()->getBody() : null, true);
        } 
        
        catch (RequestException $e) {
            throw new \RuntimeException(
                'Request failed: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        } 
        
        catch (\Throwable $e) {
            throw new \RuntimeException(
                'Unhandled error: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}

