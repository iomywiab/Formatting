<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableStringLengthReplacement.php
 * Project: Formatting
 * Modified at: 27/07/2025, 20:21
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

class ImmutableStringLengthReplacement extends AbstractImmutableReplacement
{
    public const KEY = 'string:length';

    /**
     * @param mixed $value
     * @return string
     */
    public function toString(mixed $value): string
    {
        if (!\is_string($value)) {
            return '';
        }

        try {
            return (string)\mb_strlen($value);
        } catch (\Throwable $cause) {
            return $cause->getMessage();
        }
    }
}
