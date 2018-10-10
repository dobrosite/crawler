<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2018, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler;

use DobroSite\Crawler\DataSource\DataSource;
use DobroSite\Crawler\Document\Document;
use DobroSite\Crawler\Event\DocumentEvent;
use DobroSite\Crawler\UriCollection\UriCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Тесты обходчика хранилищ.
 */
class CrawlerTest extends TestCase
{
    /**
     * Проверяет обход хранилища.
     */
    public function testProcess()
    {
        $uriCollection = $this->createMock(UriCollection::class);

        $uriCollection
            ->expects(self::exactly(2))
            ->method('valid')
            ->willReturnOnConsecutiveCalls(true, false);

        $uriCollection
            ->expects(self::once())
            ->method('current')
            ->willReturn('scheme:id');

        $document = $this->createMock(Document::class);

        $dataSource = $this->createMock(DataSource::class);

        $dataSource
            ->expects(self::once())
            ->method('getDocument')
            ->with('scheme:id')
            ->willReturn($document);

        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $eventDispatcher
            ->expects(self::once())
            ->method('dispatch')
            ->with(
                CrawlerEvents::FETCH_DOCUMENT,
                self::callback(
                    function (DocumentEvent $event) use ($document) {
                        self::assertSame($document, $event->getDocument());

                        return true;
                    }
                )
            );

        $crawler = new Crawler($eventDispatcher);
        $crawler->process($dataSource, $uriCollection);
    }
}
