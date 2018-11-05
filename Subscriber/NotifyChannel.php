<?php

namespace DiscordNotify\Subscriber;

use DiscordNotify\Components\Discord\Client;
use DiscordNotify\Components\MessageBuilder;
use Enlight\Event\SubscriberInterface;
use Enlight_Event_EventArgs;

/**
 * @author Pascal Krason <p.krason@padr.io>
 */
final class NotifyChannel implements SubscriberInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var MessageBuilder
     */
    private $messageBuilder;

    public function __construct(Client $client, MessageBuilder $messageBuilder)
    {
        $this->client = $client;
        $this->messageBuilder = $messageBuilder;
    }

    public static function getSubscribedEvents()
    {
        return [
            'Shopware_Controllers_Frontend_Checkout::finishAction::after' => 'onFinishedCheckout'
        ];
    }

    public function onFinishedCheckout(Enlight_Event_EventArgs $eventArgs)
    {
        $orderVariables = (array) Shopware()->Session()->sOrderVariables;

        $message = $this->messageBuilder->create($orderVariables);
        if($message === null) {
            return;
        }

        try {
            $this->client->notify($message);
        } catch (Client\UnexpectedResponseException $e) {
            // Todo: Logging
        }
    }

}