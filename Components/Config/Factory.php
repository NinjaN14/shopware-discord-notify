<?php

namespace DiscordNotify\Components\Config;

use DiscordNotify\Components\Config;
use DiscordNotify\DiscordNotify;
use Shopware\Components\Plugin\CachedConfigReader;
use Shopware\Models\Shop\Shop;

/**
 * @author Pascal Krason <p.krason@padr.io>
 */
class Factory
{
    public static function create()
    {
        $shop = Shopware()->Container()->get('shop');
        if (!$shop) {
            $shop = Shopware()->Container()->get('models')->getRepository(Shop::class)->getActiveDefault();
        }

        /** @var CachedConfigReader $reader */
        $reader = Shopware()->Container()->get('shopware.plugin.cached_config_reader');

        $config = $reader->getByPluginName(DiscordNotify::PLUGIN_NAME, $shop);
        return Config::createFromArray($config);
    }
}