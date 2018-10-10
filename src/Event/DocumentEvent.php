<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2018, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler\Event;

use DobroSite\Crawler\Document\Document;
use Symfony\Component\EventDispatcher\Event;

/**
 * Событие, связанное с документом.
 */
class DocumentEvent extends Event
{
    /**
     * Документ, с которым связано событие.
     *
     * @var Document
     */
    private $document;

    /**
     * Создаёт новое событие.
     *
     * @param Document $document Документ, с которым связано событие.
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * Возвращает документ, с которым связано событие.
     *
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }
}
