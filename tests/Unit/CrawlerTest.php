<?php

/**
 * DobroSite CrawlerUpdater.
 *
 * @copyright 2018, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler\Tests\Unit;

use DobroSite\Crawler\Crawler;
use DobroSite\Crawler\CrawlerEvents;
use DobroSite\Crawler\Document\Document;
use DobroSite\Crawler\Event\LinkEvent;
use DobroSite\Crawler\Source\Source;
use DobroSite\Crawler\UriQueue\UriQueue;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Тесты обходчика.
 *
 * @covers \DobroSite\Crawler\Crawler
 */
class CrawlerTest extends TestCase
{
    /**
     * Проверяет обход источника документов.
     */
    public function testSourceTraversed()
    {
        $document1 = $this->createConfiguredMock(Document::class, ['links' => ['scheme:id2']]);
        $document2 = $this->createConfiguredMock(Document::class, ['links' => []]);

        $queue = $this->createMock(UriQueue::class);
        $queue
            ->expects(self::once())
            ->method('enqueue')
            ->with('scheme:id2');
        $queue
            ->expects(self::exactly(3))
            ->method('dequeue')
            ->willReturnOnConsecutiveCalls('scheme:id1', 'scheme:id2', null);

        $source = $this->createMock(Source::class);
        $source
            ->expects(self::exactly(2))
            ->method('getDocument')
            ->willReturnMap(
                [
                    ['scheme:id1', $document1],
                    ['scheme:id2', $document2]
                ]
            );

        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcher
            ->expects(self::exactly(1))
            ->method('dispatch')
            ->withConsecutive(
                [
                    CrawlerEvents::BEFORE_LINK_ENQUEUE,
                    self::callback(
                        function (LinkEvent $event) {
                            self::assertEquals('scheme:id2', $event->getLink());

                            return true;
                        }
                    )
                ]
            );

        $crawler = new Crawler($source, $queue, $eventDispatcher);
        foreach ($crawler as $document) {
            self::assertInstanceOf(Document::class, $document);
        }
    }
}
