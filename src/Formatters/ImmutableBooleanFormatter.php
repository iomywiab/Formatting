<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Converting\Convert;

class ImmutableBooleanFormatter extends AbstractImmutableFormatter implements ImmutableBooleanFormatterInterface
{
    /**
     * @inheritDoc
     */
    public function toString(bool $value): string
    {
        $val = $value ? Convert::TRUE_STRING : Convert::FALSE_STRING;

        if (null === $this->replacer) {
            return $val;
        }

        return $this->replacer->toString($value);
    }
}
