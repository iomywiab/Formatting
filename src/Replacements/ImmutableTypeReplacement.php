<?php

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
