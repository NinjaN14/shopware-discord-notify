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

    public function __construct($webhookUrl, $username, $messageTemplate)
    {
        $this->webhookUrl = $webhookUrl;
        $this->username = $username;
        $this->messageTemplate = $messageTemplate;
    }
}