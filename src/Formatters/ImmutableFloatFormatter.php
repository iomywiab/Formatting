<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableFloatFormatter.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

class ImmutableFloatFormatter extends AbstractImmutableFormatter implements ImmutableFloatFormatterInterface
{
    /**
     * @inheritDoc
     */
    public function toString(float $value): string
    {
        if (null === $this->replacer) {
            return $value.(\floor($value) === $value ? '.0' : '');
        }

        $return = $this->replacer->toString($value);
        \assert('' !== $return);

        return $return;
    }
}
