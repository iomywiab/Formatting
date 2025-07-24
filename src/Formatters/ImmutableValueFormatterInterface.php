<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Converting\Convert;
use Iomywiab\Library\Formatting\Enums\SizeUnitEnum;
use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;

/**
 * Class to format different types (mostly scalars) to pretty strings.
 * * Please note: This is not for conversion
 * * @see Convert
 */
interface ImmutableValueFormatterInterface
{
    /**
     * @param mixed $value
     * @return string
     * @throws FormatExceptionInterface
     */
    public function toString(mixed $value): string;

    /**
     * @param non-negative-int $bytes
     * @param SizeUnitEnum|null $unit
     * @return non-empty-string
     * @throws FormatExceptionInterface
     */
    public function toHumanSize(int $bytes, null|SizeUnitEnum $unit = null): string;
}
