<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CompanyCountryEnum extends Enum
{
    public const VN = 'Vietnam';
    public const JP = 'Japan';
    public const CN = 'China';
    public const US = 'United State';
    public const KR = 'South Korean';
    public const UK = 'United Kingdom';
    public const CA = 'Canada';
    public const AU = 'Australia';
    public const SG = 'Singapore';
    public const DE = 'Deutschland';
    public const FR = 'France';
    public const RU = 'Russia';
}
