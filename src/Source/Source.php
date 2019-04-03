<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2018, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler\Source;

use DobroSite\Crawler\Document\Document;
use DobroSite\Crawler\Exception\Source\ReadException;

/**
 * Источник документов.
 *
 * @since 0.1
 */
interface Source
{
    /**
     * Возвращает документ с указанным URI.
     *
     * @param string $uri
     *
     * @return Document
     *
     * @throws ReadException Если не удалось прочитать данные.
     *
     * @since 0.2 вбрасывает исключение ReadException если не удалось прочитать данные.
     * @since 0.1
     */
    public function getDocument($uri);

    /**
     * Корневой URI источника.
     *
     * @return string
     *
     * @since 0.1
     */
    public function rootUri();
}
