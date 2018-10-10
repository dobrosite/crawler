<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2018, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler;

use DobroSite\Crawler\DataSource\DataSource;
use DobroSite\Crawler\Event\DocumentEvent;
use DobroSite\Crawler\UriCollection\UriCollection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Обходчик хранилищ.
 *
 * Главный класс, выполняющий рекурсивный обход хранилищ и вбрасывающий события для обработки
 * найденных документов.
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
     * Создаёт обходчика.
     *
     * @param EventDispatcherInterface $eventDispatcher Диспетчер событий.
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Выполняет обход хранилища.
     *
     * @param DataSource    $dataSource    Обрабатываемый источник данных (хранилище).
     * @param UriCollection $uriCollection Коллекция URI документов, которые надо обработать.
     */
    public function process(DataSource $dataSource, UriCollection $uriCollection)
    {
        foreach ($uriCollection as $uri) {
            $document = $dataSource->getDocument($uri);

            $event = new DocumentEvent($document);
            $this->eventDispatcher->dispatch(CrawlerEvents::FETCH_DOCUMENT, $event);
        }
    }
}
