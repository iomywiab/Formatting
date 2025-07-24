<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Converting\Convert;

class ImmutableNullFormatter implements ImmutableNullFormatterInterface
{
    /**
     * @inheritDoc
     */
    public function toString(mixed $value): string
    {
        return Convert::NULL_STRING;
    }
}
