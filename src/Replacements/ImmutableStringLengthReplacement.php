<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

class ImmutableStringLengthReplacement extends AbstractImmutableReplacement
{
    public const KEY = 'string:length';

    /**
     * @param mixed $value
     * @return non-empty-string
     */
    public function toString(mixed $value): string
    {
        if (!\is_string($value)) {
            return '';
        }

        try {
            return (string)\mb_strlen($value);
        } catch (\Throwable $cause) {
            return $cause->getMessage();
        }
    }
}
