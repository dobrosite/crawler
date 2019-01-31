<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2018, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler\Document;

/**
 * Документ.
 *
 * @since 0.1
 */
interface Document
{
    /**
     * Тело документа.
     *
     * @return string
     *
     * @since 0.1
     */
    public function content();

    /**
     * Ссылки, содержащиеся в документе.
     *
     * @return string[]
     *
     * @since 0.1
     */
    public function links();

    /**
     * URI документа.
     *
     * @return string
     *
     * @since 0.1
     */
    public function uri();
}
