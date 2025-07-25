<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableNullFormatter.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Converting\Convert;

class ImmutableNullFormatter implements ImmutableNullFormatterInterface
{
    /**
     * @inheritDoc
     */
    public function toString(mixed $value): string
    {
        return Convert::NULL_STRING;
    }
}
