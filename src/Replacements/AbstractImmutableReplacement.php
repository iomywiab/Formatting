<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: AbstractImmutableReplacement.php
 * Project: Formatting
 * Modified at: 27/07/2025, 21:05
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

abstract class AbstractImmutableReplacement implements ImmutableReplacementInterface
{
    public const KEY = '';

    public function __construct()
    {
        \assert('' !== static::KEY);
    }

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        // @phpstan-ignore return.type
        return static::KEY;
    }
}
