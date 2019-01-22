<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2018, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler;

use DobroSite\Crawler\DataSource\DataSource;
use DobroSite\Crawler\Event\DocumentEvent;
use DobroSite\Crawler\URI\UriExtractor;
use DobroSite\Crawler\URI\UriQueue;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Обходчик хранилищ.
 *
 * Главный класс, выполняющий рекурсивный обход хранилищ и вбрасывающий события для обработки
 * найденных документов.
 *
 * @since 0.1
 */
class Crawler
{
    /**
     * Диспетчер событий.
     *
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * Средство извлечения URI из документов.
     *
     * @var UriExtractor
     */
    private $uriExtractor;


    /**
     * Создаёт обходчика.
     *
     * @param EventDispatcherInterface $eventDispatcher Диспетчер событий.
     * @param UriExtractor             $uriExtractor    Средство извлечения URI из документов.
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        UriExtractor $uriExtractor
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->uriExtractor = $uriExtractor;
    }

    /**
     * Выполняет обход источника данных.
     *
     * @param DataSource $dataSource Обрабатываемый источник данных (хранилище).
     * @param UriQueue   $uriQueue   Очередь URI документов, которые надо обработать.
     *
     * @since 0.1
     */
    public function process(DataSource $dataSource, UriQueue $uriQueue)
    {
        while ($uri = $uriQueue->dequeue()) {
            $document = $dataSource->getDocument($uri);

            $event = new DocumentEvent($document);
            $this->eventDispatcher->dispatch(CrawlerEvents::FETCH_DOCUMENT, $event);

            $uris = $this->uriExtractor->extractUris($document);
            foreach ($uris as $uri) {
                $uriQueue->enqueue($uri);
            }
        }
    }
}
