<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2018, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler\URI;

/**
 * Очередь URI.
 *
 * @since 0.1
 */
interface UriQueue
{
    /**
     * Возвращает следующий URI из очереди.
     *
     * @return string|null URI или null, если очередь пуста.
     */
    public function dequeue();

    /**
     * Добавляет URI в очередь.
     *
     * @param string $uri
     *
     * @return void
     */
    public function enqueue($uri);
}
