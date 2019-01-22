<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2018, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler\Tests\Unit;

use DobroSite\Crawler\Crawler;
use DobroSite\Crawler\CrawlerEvents;
use DobroSite\Crawler\DataSource\DataSource;
use DobroSite\Crawler\Document\Document;
use DobroSite\Crawler\Event\DocumentEvent;
use DobroSite\Crawler\URI\UriExtractor;
use DobroSite\Crawler\URI\UriQueue;
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
    public function testStorageTraversed()
    {
        $uriQueue = $this->createMock(UriQueue::class);
        $uriQueue
            ->expects(self::once())
            ->method('enqueue')
            ->with('scheme:id2');
        $uriQueue
            ->expects(self::exactly(3))
            ->method('dequeue')
            ->willReturnOnConsecutiveCalls('scheme:id1', 'scheme:id2', null);

        $document1 = $this->createMock(Document::class);
        $document2 = $this->createMock(Document::class);

        $dataSource = $this->createMock(DataSource::class);
        $dataSource
            ->expects(self::exactly(2))
            ->method('getDocument')
            ->willReturnMap(
                [
                    ['scheme:id1', $document1],
                    ['scheme:id2', $document2]
                ]
            );

        $uriExtractor = $this->createMock(UriExtractor::class);
        $uriExtractor
            ->expects(self::exactly(2))
            ->method('extractUris')
            ->withConsecutive(
                self::identicalTo($document1),
                self::identicalTo($document2)
            )
            ->willReturnOnConsecutiveCalls(['scheme:id2'], []);

        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcher
            ->expects(self::exactly(2))
            ->method('dispatch')
            ->withConsecutive(
                [
                    CrawlerEvents::FETCH_DOCUMENT,
                    self::callback(
                        function (DocumentEvent $event) use ($document1) {
                            self::assertSame($document1, $event->getDocument());

                            return true;
                        }
                    )
                ],
                [
                    CrawlerEvents::FETCH_DOCUMENT,
                    self::callback(
                        function (DocumentEvent $event) use ($document2) {
                            self::assertSame($document2, $event->getDocument());

                            return true;
                        }
                    )
                ]
            );

        $crawler = new Crawler($eventDispatcher, $uriExtractor);
        $crawler->process($dataSource, $uriQueue);
    }
}
