<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2018, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler;

use DobroSite\Crawler\Event\LinkEvent;
use DobroSite\Crawler\Source\Source;
use DobroSite\Crawler\Document\Document;
use DobroSite\Crawler\UriQueue\UriQueue;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Обходчик хранилищ.
 *
 * Главный класс, выполняющий рекурсивный обход хранилищ и вбрасывающий события для обработки
 * найденных документов.
 *
 * @since 0.1
 */
class Crawler implements \Iterator
{
    /**
     * Текущий документ.
     *
     * @var Document|null
     */
    private $document;

    /**
     * Диспетчер событий.
     *
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * Источник документов.
     *
     * @var Source
     */
    private $source;

    /**
     * Очередь URI.
     *
     * @var UriQueue
     */
    private $uriQueue;

    /**
     * Создаёт обходчика.
     *
     * @param Source                        $source   Источник документов.
     * @param UriQueue                      $uriQueue Очередь URI.
     * @param EventDispatcherInterface|null $eventDispatcher
     *
     * @since 0.1
     */
    public function __construct(
        Source $source,
        UriQueue $uriQueue,
        EventDispatcherInterface $eventDispatcher = null
    ) {
        $this->source = $source;
        $this->uriQueue = $uriQueue;
        $this->eventDispatcher = $eventDispatcher ?: new EventDispatcher();
    }

    /**
     * Добавляет слушателя событий.
     *
     * @param string   $eventName Имя события.
     * @param callable $listener  Слушатель.
     * @param int      $priority  Приоритет (больше значение — раньше будет вызван слушатель).
     *
     * @return $this
     *
     * @since 0.1
     */
    public function addEventListener($eventName, $listener, $priority = 0)
    {
        $this->eventDispatcher->addListener($eventName, $listener, $priority);

        return $this;
    }

    /**
     * Возвращает текущий документ или null, если больше документов нет.
     *
     * @return Document|null
     *
     * @since 0.1
     */
    public function current()
    {
        return $this->document;
    }

    /**
     * Возвращает URI текущего документа или null, если больше документов нет.
     *
     * @return string|null
     *
     * @since 0.1
     */
    public function key()
    {
        return $this->document
            ? $this->document->uri()
            : null;
    }

    /**
     * Перемещается к следующему документу.
     *
     * @return void
     *
     * @since 0.1
     */
    public function next()
    {
        $this->document = null;
        $uri = $this->uriQueue->dequeue();
        if ($uri !== null) {
            $this->document = $this->source->getDocument($uri);
            $this->enqueueLinks($this->document->links());
        }
    }

    /**
     * Перемещается к первому документу.
     *
     * @return void
     *
     * @since 0.1
     */
    public function rewind()
    {
        if ($this->uriQueue->size() === 0) {
            $this->uriQueue->enqueue($this->source->rootUri());
        }
        $this->next();
    }

    /**
     * Возвращает true, если есть доступные документы.
     *
     * @return bool
     *
     * @since 0.1
     */
    public function valid()
    {
        return $this->document !== null;
    }

    /**
     * Добавляет ссылки в очередь на обработку.
     *
     * @param string[] $links
     *
     * @return void
     */
    private function enqueueLinks(array $links)
    {
        foreach ($links as $link) {
            $event = new LinkEvent($link);
            $this->eventDispatcher->dispatch(CrawlerEvents::BEFORE_LINK_ENQUEUE, $event);
            if ($event->isPropagationStopped()) {
                continue;
            }
            $this->uriQueue->enqueue($link);
        }
    }
}
