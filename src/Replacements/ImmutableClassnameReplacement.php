<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableClassnameReplacement.php
 * Project: Formatting
 * Modified at: 27/07/2025, 20:21
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

class ImmutableClassnameReplacement extends AbstractImmutableReplacement
{
    public const KEY = 'class:name';

    /**
     * @param mixed $value
     * @return string
     */
    public function toString(mixed $value): string
    {
        if (!\is_object($value)) {
            return '';
        }

        try {
            return (new \ReflectionClass($value))->getShortName();
        } catch (\Throwable $cause) {
            return $cause->getMessage();
        }
    }
}
