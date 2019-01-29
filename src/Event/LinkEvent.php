<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2019, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Событие, связанное со ссылкой.
 *
 * @since 0.1
 */
class LinkEvent extends Event
{
    /**
     * Ссылка, с которой связано событие.
     *
     * @var string
     */
    private $link;

    /**
     * Создаёт новое событие.
     *
     * @param string $link Ссылка, с которой связано событие.
     *
     * @since 0.1
     */
    public function __construct($link)
    {
        $this->link = (string) $link;
    }

    /**
     * Возвращает документ, с которым связано событие.
     *
     * @return string
     *
     * @since 0.1
     */
    public function getLink()
    {
        return $this->link;
    }
}
