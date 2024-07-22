<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PostLevelEnum extends Enum
{
    public const INTERN = '1';
    public const FRESHER = '2';
    public const JUNIOR = '3';
    public const MIDDLE = '4';
    public const SENIOR = '5';
    public const LEADER = '6';
    public const MANAGER = '7';
}
