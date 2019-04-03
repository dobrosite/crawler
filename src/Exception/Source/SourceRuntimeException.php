<?php

/**
 * DobroSite Crawler.
 *
 * @copyright 2019, ООО «Добро.сайт», http://добро.сайт
 */

namespace DobroSite\Crawler\Exception\Source;

use DobroSite\Crawler\Source\Source;
use Throwable;

/**
 * Ошибка времени исполнения при работе с источником.
 *
 * @since 0.2
 */
abstract class SourceRuntimeException extends \RuntimeException
{
    /**
     * Источник, при работе с которым произошла ошибка.
     *
     * @var Source
     */
    private $source;

    /**
     * Создаёт исключение.
     *
     * @param string         $message  Сообщение об ошибке.
     * @param Source         $source   Источник, при работе с которым произошла ошибка.
     * @param int            $code     Код ошибки.
     * @param Throwable|null $previous Предыдущее исключение.
     *
     * @since 0.2
     */
    public function __construct(
        $message,
        Source $source,
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->source = $source;
    }

    /**
     * Возвращает источник, при работе с которым произошла ошибка.
     *
     * @return Source
     *
     * @since 0.2
     */
    public function getSource()
    {
        return $this->source;
    }
}
