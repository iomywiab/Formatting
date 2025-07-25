<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableStringFormatter.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

class ImmutableStringFormatter extends AbstractImmutableFormatter implements ImmutableStringFormatterInterface
{
    /**
     * @inheritDoc
     */
    public function toString(string $value): string
    {
        if (null === $this->replacer) {
            return '"'.$value.'"';
        }

        return $this->replacer->toString($value);
    }
}
