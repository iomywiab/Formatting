<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableIntegerFormatter.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

class ImmutableIntegerFormatter extends AbstractImmutableFormatter implements ImmutableIntegerFormatterInterface
{
    /**
     * @inheritDoc
     */
    public function toString(int $value): string
    {
        if (null === $this->replacer) {
            return (string)$value;
        }

        $return = $this->replacer->toString($value);
        \assert('' !== $return);

        return $return;
    }
}
