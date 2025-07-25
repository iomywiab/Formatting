<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableReplacementInterface.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

interface ImmutableReplacementInterface
{
    /**
     * @return non-empty-string
     */
    public function getKey(): string;

    /**
     * @param mixed $value
     * @return string
     */
    public function toString(mixed $value): string;
}
