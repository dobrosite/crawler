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
 *
 * @since 0.1
 */
interface DataSource
{
    /**
     * Возвращает документ с указанным URI.
     *
     * @param string $uri
     *
     * @return Document
     *
     * @since 0.1
     */
    public function getDocument($uri);
}
