<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting;

use Iomywiab\Library\Formatting\Enums\SizeUnitEnum;
use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;
use Iomywiab\Library\Formatting\Formatters\ImmutableDebugValueFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatterInterface;

/**
 * Class to format different types (mostly scalars) to pretty strings.
 * * Please note: This is not for conversion
 * * @see Convert
 */
class Format
{
    private static ?ImmutableValueFormatterInterface $formatter = null;
    private static ?ImmutableValueFormatterInterface $debugFormatter = null;

    /**
     * @return ImmutableValueFormatterInterface
     */
    public static function getFormatter(): ImmutableValueFormatterInterface
    {
        if (null === self::$formatter) {
            self::$formatter = new ImmutableValueFormatter();
        }

        return self::$formatter;
    }

    /**
     * @return ImmutableValueFormatterInterface
     */
    public static function getDebugFormatter(): ImmutableValueFormatterInterface
    {
        if (null === self::$debugFormatter) {
            self::$debugFormatter = new ImmutableDebugValueFormatter();
        }

        return self::$debugFormatter;
    }

    /**
     * @param ImmutableValueFormatterInterface|null $formatter
     * @return void
     */
    public static function setFormatter(?ImmutableValueFormatterInterface $formatter): void
    {
        self::$formatter = $formatter;
    }

    /**
     * @param ImmutableValueFormatterInterface|null $formatter
     * @return void
     */
    public static function setDebugFormatter(?ImmutableValueFormatterInterface $formatter): void
    {
        self::$debugFormatter = $formatter;
    }

    /**
     * @param mixed $value
     * @return string
     * @throws FormatExceptionInterface
     */
    public static function toString(mixed $value): string
    {
        return self::getFormatter()->toString($value);
    }

    /**
     * @param mixed $value
     * @return string
     * @throws FormatExceptionInterface
     */
    public static function toDebugString(mixed $value): string
    {
        return self::getDebugFormatter()->toString($value);
    }

    /**
     * @param non-negative-int $bytes
     * @param SizeUnitEnum|null $unit
     * @return non-empty-string
     * @throws FormatExceptionInterface
     */
    public static function toHumanSize(int $bytes, null|SizeUnitEnum $unit = null): string
    {
        return self::getFormatter()->toHumanSize($bytes, $unit);
    }
}
