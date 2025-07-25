<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableReplacerInterface.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacers;

interface ImmutableReplacerInterface
{
    /**
     * @param mixed $value
     * @return string
     */
    public function toString(mixed $value): string;

}
