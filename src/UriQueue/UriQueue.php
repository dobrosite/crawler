<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2018, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler\UriQueue;

/**
 * Очередь URI.
 *
 * @since 0.1
 */
interface UriQueue
{
    /**
     * Очищает очередь.
     *
     * @return void
     *
     * @since 0.1
     */
    public function clear();

    /**
     * Возвращает следующий URI из очереди.
     *
     * @return string|null URI или null, если очередь пуста.
     *
     * @since 0.1
     */
    public function dequeue();

    /**
     * Добавляет URI в очередь.
     *
     * @param string $uri
     *
     * @return void
     *
     * @since 0.1
     */
    public function enqueue($uri);

    /**
     * Возвращает размер очереди.
     *
     * @return int
     *
     * @since 0.1
     */
    public function size();
}
