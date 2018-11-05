<?php

namespace DiscordNotify\Subscriber;

use DiscordNotify\Components\Discord\Client;
use DiscordNotify\Components\MessageBuilder;
use Enlight\Event\SubscriberInterface;
use Enlight_Event_EventArgs;
use Shopware\Components\Logger;

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
            $this->getLogger()->debug('Missing order variables');
            return;
        }

        try {
            $this->client->notify($message);
        } catch (Client\UnexpectedResponseException $e) {
            $this->getLogger()->error($e->getMessage());
        }
    }

    /**
     * @return Logger
     */
    private function getLogger()
    {
        return Shopware()->Container()->get('pluginlogger');
    }

}