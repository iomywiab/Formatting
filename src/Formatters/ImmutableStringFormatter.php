<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

class ImmutableStringFormatter extends AbstractImmutableFormatter implements ImmutableStringFormatterInterface
{
    /**
     * @inheritDoc
     */
    public function toString(string $value): string
    {
        if (null === $this->replacer) {
            return '"'.$value.'"';
        }

        return $this->replacer->toString($value);
    }
}
