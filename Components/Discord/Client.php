<?php

namespace DiscordNotify\Components\Discord;

use DiscordNotify\Components\Config;
use DiscordNotify\Components\Discord\Client\UnexpectedResponseException;

/**
 * @author Pascal Krason <p.krason@padr.io>
 */
final class Client
{
    /**
     * @var array
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $message
     *
     * @return bool
     * @throws UnexpectedResponseException
     */
    public function notify($message): bool
    {
        $payload = $this->getPayload($this->config->username, $message);
        $handle = $this->createCurlHandle($this->config, $payload);

        $response = curl_exec($handle);
        if(curl_getinfo($handle, CURLINFO_HTTP_CODE) != 204) {
            throw UnexpectedResponseException::createFromCurlHandle($handle);
        }

        $decoded = json_decode($response, true);
        if($decoded === false) {
            return false;
        }

        curl_close($handle);

        return true;
    }

    private function createCurlHandle(Config $config, string $payload)
    {
        $handle = curl_init();

        curl_setopt($handle, CURLOPT_URL, $config->webhookUrl);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $payload);

        return $handle;
    }

    private function getPayload($username, $mesage): string
    {
        $payload = [
            'name' => $username,
            'content' => $mesage,
        ];

        return json_encode($payload);
    }
}