<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableListFormatterInterface.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;

interface ImmutableListFormatterInterface
{
    /**
     * @param array<array-key,mixed> $array
     * @return string
     * @throws FormatExceptionInterface
     */
    public function toString(array $array): string;
}
