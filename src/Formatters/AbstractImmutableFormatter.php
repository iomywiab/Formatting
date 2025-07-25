<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: AbstractImmutableFormatter.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Formatting\Replacers\ImmutableReplacerInterface;

class AbstractImmutableFormatter
{
    /**
     * @param ImmutableReplacerInterface|null $replacer
     */
    public function __construct(protected readonly ?ImmutableReplacerInterface $replacer = null)
    {
        // no code
    }
}
