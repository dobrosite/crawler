<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2019, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler\UriQueue;

/**
 * Очередь URI в оперативной памяти.
 *
 * @since 0.1
 */
class InMemoryUriQueue implements UriQueue
{
    /**
     * Указатель.
     *
     * @var int
     */
    private $pointer = 0;

    /**
     * Внутренняя очередь.
     *
     * @var string[]
     */
    private $queue = [];

    /**
     * Очищает очередь.
     *
     * @return void
     *
     * @since 0.1
     */
    public function clear()
    {
        $this->queue = [];
        $this->pointer = 0;
    }

    /**
     * Возвращает следующий URI из очереди.
     *
     * @return string|null URI или null, если очередь пуста.
     *
     * @since 0.1
     */
    public function dequeue()
    {
        if (!array_key_exists($this->pointer, $this->queue)) {
            return null;
        }

        return $this->queue[$this->pointer++];
    }

    /**
     * Добавляет URI в очередь.
     *
     * @param string $uri
     *
     * @return void
     *
     * @since 0.1
     */
    public function enqueue($uri)
    {
        if (!in_array($uri, $this->queue)) {
            $this->queue[] = $uri;
        }
    }

    /**
     * Возвращает размер очереди.
     *
     * @return int
     *
     * @since 0.1
     */
    public function size()
    {
        return count($this->queue) - $this->pointer;
    }
}
