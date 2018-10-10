<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2018, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler\URI;

use DobroSite\Crawler\Document\Document;

/**
 * Средство извлечения URI из документов.
 *
 * @since 0.1
 */
interface UriExtractor
{
    /**
     * Извлекает URI из документа.
     *
     * @param Document $document
     *
     * @return string[]
     *
     * @since 0.1
     */
    public function extractUris(Document $document);
}
