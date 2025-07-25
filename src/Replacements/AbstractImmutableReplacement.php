<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: AbstractImmutableReplacement.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
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
        return static::KEY;
    }
}
