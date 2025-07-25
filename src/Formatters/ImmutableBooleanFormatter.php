<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableBooleanFormatter.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Converting\Convert;

class ImmutableBooleanFormatter extends AbstractImmutableFormatter implements ImmutableBooleanFormatterInterface
{
    /**
     * @inheritDoc
     */
    public function toString(bool $value): string
    {
        $val = $value ? Convert::TRUE_STRING : Convert::FALSE_STRING;

        if (null === $this->replacer) {
            return $val;
        }

        return $this->replacer->toString($value);
    }
}
