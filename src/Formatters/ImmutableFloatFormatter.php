<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

class ImmutableFloatFormatter extends AbstractImmutableFormatter implements ImmutableFloatFormatterInterface
{
    /**
     * @inheritDoc
     */
    public function toString(float $value): string
    {
        if (null===$this->replacer) {
            return $value.(\floor($value) === $value ? '.0' : '');
        }

        return $this->replacer->toString($value);
    }
}
