<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2019, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler\Tests\Unit\UriQueue;

use DobroSite\Crawler\UriQueue\InMemoryUriQueue;
use PHPUnit\Framework\TestCase;

/**
 * Модульные тесты очереди URI в оперативной памяти.
 *
 * @covers \DobroSite\Crawler\UriQueue\InMemoryUriQueue
 */
class InMemoryUriQueueTest extends TestCase
{
    /**
     * Проверяет что очередь очищается.
     */
    public function testCleared()
    {
        $queue = new InMemoryUriQueue();

        $queue->enqueue('URI:1');
        $queue->enqueue('URI:2');
        $queue->enqueue('URI:3');

        $queue->clear();

        self::assertEquals(0, $queue->size());
    }

    /**
     * Проверяет что дубликаты не добавляются в очередь даже после их извлечения.
     */
    public function testDuplicateElementsIgnoredAfterDequeue()
    {
        $queue = new InMemoryUriQueue();

        $queue->enqueue('URI:1');
        $queue->enqueue('URI:2');
        $queue->enqueue('URI:3');

        $queue->dequeue();
        $queue->dequeue();
        $queue->dequeue();

        $queue->enqueue('URI:1');
        $queue->enqueue('URI:2');
        $queue->enqueue('URI:3');

        self::assertEquals(0, $queue->size());
    }

    /**
     * Проверяет что дубликаты не добавляются в очередь.
     */
    public function testDuplicateElementsIgnoredOnEnqueue()
    {
        $queue = new InMemoryUriQueue();

        $queue->enqueue('URI:1');
        $queue->enqueue('URI:2');
        $queue->enqueue('URI:1');
        $queue->enqueue('URI:3');
        $queue->enqueue('URI:2');

        self::assertEquals(3, $queue->size());
        self::assertEquals('URI:1', $queue->dequeue());
        self::assertEquals('URI:2', $queue->dequeue());
        self::assertEquals('URI:3', $queue->dequeue());
    }

    /**
     * Проверяет что по умолчанию очередь пуста.
     */
    public function testEmptyByDefault()
    {
        $queue = new InMemoryUriQueue();

        self::assertNull($queue->dequeue());
        self::assertEquals(0, $queue->size());
    }

    /**
     * Проверяет что элементы извлекаются из очереди в порядке добавления.
     */
    public function testFirstInFirstOut()
    {
        $queue = new InMemoryUriQueue();

        $queue->enqueue('URI:1');
        $queue->enqueue('URI:2');
        $queue->enqueue('URI:3');

        self::assertEquals('URI:1', $queue->dequeue());
        self::assertEquals('URI:2', $queue->dequeue());
        self::assertEquals('URI:3', $queue->dequeue());
    }

    /**
     * Проверяет что размер очереди увеличивается при добавлении элементов.
     */
    public function testSizeIncrementedOnEnqueue()
    {
        $queue = new InMemoryUriQueue();

        self::assertEquals(0, $queue->size());

        $queue->enqueue('URI:1');
        self::assertEquals(1, $queue->size());

        $queue->enqueue('URI:2');
        self::assertEquals(2, $queue->size());
    }
}
