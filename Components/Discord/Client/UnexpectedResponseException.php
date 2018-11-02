<?php

namespace DiscordNotify\Components\Discord\Client;

use Exception;

/**
 * @author Pascal Krason <p.krason@padr.io>
 */
class UnexpectedResponseException extends Exception
{
    public static function createFromCurlHandle($curl): self
    {
        return new self('Bad response from Discord API - Error Code: '. curl_getinfo($curl, CURLINFO_HTTP_CODE));
    }
}