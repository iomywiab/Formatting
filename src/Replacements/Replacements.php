<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: Replacements.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatterInterface;

class Replacements
{
    /**
     * @param ImmutableValueFormatterInterface|null $valueFormatter
     * @return non-empty-array<non-empty-string,ImmutableReplacementInterface>
     */
    public static function get(?ImmutableValueFormatterInterface $valueFormatter = null): array
    {
        return [
            ImmutableArrayKeyTypeReplacement::KEY            => new ImmutableArrayKeyTypeReplacement(),
            ImmutableArrayKeyExtendedTypesReplacement::KEY   => new ImmutableArrayKeyExtendedTypesReplacement(),
            ImmutableArraySizeReplacement::KEY               => new ImmutableArraySizeReplacement(),
            ImmutableArrayValueTypeReplacement::KEY          => new ImmutableArrayValueTypeReplacement(),
            ImmutableArrayValueExtendedTypesReplacement::KEY => new ImmutableArrayValueExtendedTypesReplacement(),
            ImmutableClassnameReplacement::KEY               => new ImmutableClassnameReplacement(),
            ImmutableExtendedTypeReplacement::KEY            => new ImmutableExtendedTypeReplacement(),
            ImmutableNamespaceReplacement::KEY               => new ImmutableNamespaceReplacement(),
            ImmutableStringLengthReplacement::KEY            => new ImmutableStringLengthReplacement(),
            ImmutableTypeReplacement::KEY                    => new ImmutableTypeReplacement(),
            ImmutableValueReplacement::KEY                   => new ImmutableValueReplacement($valueFormatter),
        ];
    }
}
