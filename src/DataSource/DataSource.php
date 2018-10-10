<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2018, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler\DataSource;

use DobroSite\Crawler\Document\Document;

/**
 * Источник данных.
 */
interface DataSource
{
    /**
     * Возвращает документ с указанным URI.
     *
     * @param string $uri
     *
     * @return Document
     */
    public function getDocument($uri);
}
