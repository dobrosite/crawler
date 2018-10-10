<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2018, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler;

/**
 * Коды событий.
 */
final class CrawlerEvents
{
    /**
     * Из хранилища получен новый документ.
     */
    const FETCH_DOCUMENT = 'dobrosite.crawler.fetch_document';
}
