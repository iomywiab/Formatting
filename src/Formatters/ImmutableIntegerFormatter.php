<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

class ImmutableIntegerFormatter extends AbstractImmutableFormatter implements ImmutableIntegerFormatterInterface
{
    /**
     * @inheritDoc
     */
    public function toString(int $value): string
    {
        if (null === $this->replacer) {
            return (string)$value;
        }

        return $this->replacer->toString($value);
    }
}
