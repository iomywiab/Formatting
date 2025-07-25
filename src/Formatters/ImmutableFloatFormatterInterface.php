<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableFloatFormatterInterface.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;

interface ImmutableFloatFormatterInterface
{
    /**
     * @param float $value
     * @return non-empty-string
     * @throws FormatExceptionInterface
     */
    public function toString(float $value): string;
}
