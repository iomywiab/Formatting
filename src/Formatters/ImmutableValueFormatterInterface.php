<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableValueFormatterInterface.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

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
