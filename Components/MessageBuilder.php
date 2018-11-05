<?php

namespace DiscordNotify\Components;

use Adbar\Dot;

/**
 * @author Pascal Krason <p.krason@padr.io>
 */
final class MessageBuilder
{
    /**
     * @var string
     */
    private $messageTemplate;

    public function __construct(array $config)
    {
        $this->messageTemplate = $config['messageTemplate'];
    }

    public function create(array $items)
    {
        $dot = new Dot($items);

        $variables = $this->getVariablesFromTemplate($this->messageTemplate);
        if(!$variables) {
            return $this->messageTemplate;
        }

        $resolved = $this->resolveParameters($variables[2], $dot);

        return str_replace(array_keys($resolved), array_values($resolved), $this->messageTemplate);
    }

    private function getVariablesFromTemplate($message)
    {
        $regex = '/(\{\{([\w.]+)\}\})/m';
        preg_match_all($regex, $message, $matches, PREG_PATTERN_ORDER, 0);
        return $matches;
    }

    private function resolveParameters(array $variables, Dot $dot)
    {
        $search = [];

        foreach($variables as $variable) {
            $search['{{' . $variable . '}}'] = $dot->get($variable);
        }

        return $search;
    }
}