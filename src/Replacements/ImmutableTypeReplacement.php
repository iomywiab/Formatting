<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableTypeReplacement.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

use Iomywiab\Library\Converting\Enums\DataTypeEnum;

class ImmutableTypeReplacement extends AbstractImmutableReplacement
{
    public const KEY = 'type';

    /**
     * @param mixed $value
     * @return non-empty-string
     */
    public function toString(mixed $value): string
    {
        return DataTypeEnum::fromData($value)->toPhpDocName();
    }
}
