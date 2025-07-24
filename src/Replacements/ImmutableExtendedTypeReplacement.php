<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

use Iomywiab\Library\Formatting\Enums\ExtendedDataTypeEnum;

class ImmutableExtendedTypeReplacement extends AbstractImmutableReplacement
{
    public const KEY = 'type:extended';

    /**
     * @param mixed $value
     * @return non-empty-string
     */
    public function toString(mixed $value): string
    {
        return ExtendedDataTypeEnum::fromData($value)->value;
    }
}
