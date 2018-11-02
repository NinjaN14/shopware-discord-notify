<?php

namespace DiscordNotify\Subscriber;

use DiscordNotify\Components\Discord\Client;
use Enlight\Event\SubscriberInterface;
use Enlight_Event_EventArgs;

final class NotifyChannel implements SubscriberInterface
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public static function getSubscribedEvents()
    {
        return [
            'Shopware_Controllers_Frontend_Checkout::finishAction::after' => 'onFinishedCheckout'
        ];
    }

    public function onFinishedCheckout(Enlight_Event_EventArgs $eventArgs)
    {
        try {
            $this->client->notify();
        } catch (Client\UnexpectedResponseException $e) {
            // Todo: Logging
        }
    }
}