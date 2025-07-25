<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableArrayValueExtendedTypesReplacement.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

use Iomywiab\Library\Formatting\Enums\ExtendedDataTypeEnum;

class ImmutableArrayValueExtendedTypesReplacement extends ImmutableArrayValueTypeReplacement
{
    public const KEY = 'array:value:type:extended';

    /**
     * @param mixed $value
     * @return non-empty-string
     */
    protected function getTypeString(mixed $value): string
    {
        return ExtendedDataTypeEnum::fromData($value)->value;
    }
}
