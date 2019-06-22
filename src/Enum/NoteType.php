<?php

declare(strict_types=1);

namespace App\Enum;

use Grachevko\Enum\Enum;

/**
 * @method static self info()
 *
 * @author Konstantin Grachev <me@grachevko.ru>
 */
final class NoteType extends Enum
{
    private const SUCCESS = 1;
    private const INFO = 2;
    private const WARNING = 3;
    private const DANGER = 4;

    /**
     * @var array
     */
    protected static $name = [
        self::SUCCESS => 'Лучи добра',
        self::INFO => 'Информация',
        self::WARNING => 'Внимание',
        self::DANGER => 'Тревога',
    ];
}
