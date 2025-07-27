<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableArraySizeReplacement.php
 * Project: Formatting
 * Modified at: 27/07/2025, 20:21
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

class ImmutableArraySizeReplacement extends AbstractImmutableReplacement
{
    public const KEY = 'array:size';

    /**
     * @param mixed $value
     * @return string
     */
    public function toString(mixed $value): string
    {
        if (!\is_array($value)) {
            return '';
        }

        try {
            return (string)\count($value);
        } catch (\Throwable $cause) {
            return $cause->getMessage();
        }
    }
}
