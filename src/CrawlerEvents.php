<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2018, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler;

/**
 * Коды событий.
 *
 * @since 0.1
 */
final class CrawlerEvents
{
    /**
     * Из хранилища получен новый документ.
     *
     * @since 0.1
     */
    const FETCH_DOCUMENT = 'dobrosite.crawler.fetch_document';
}
