<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2018, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler;

/**
 * Коды событий обходчика.
 *
 * @since 0.1
 */
final class CrawlerEvents
{
    /**
     * Ссылка готовится встать в очередь на обработку.
     *
     * @since 0.1
     */
    const BEFORE_LINK_ENQUEUE = 'dobrosite.crawler.before_link_enqueue';
}
