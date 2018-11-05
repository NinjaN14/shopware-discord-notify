<?php

namespace DiscordNotify\Components;

/**
 * @author Pascal Krason <p.krason@padr.io>
 */
final class Config
{
    /**
     * @var string
     */
    public $webhookUrl;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $messageTemplate;

    public static function createFromArray(array $data)
    {
        $instance = new self();
        $instance->webhookUrl = $data['webhookUrl'];
        $instance->username = $data['username'];
        $instance->messageTemplate = $data['messageTemplate'];

        return $instance;
    }
}