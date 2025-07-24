<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

class ImmutableArraySizeReplacement extends AbstractImmutableReplacement
{
    public const KEY = 'array:size';

    /**
     * @param mixed $value
     * @return non-empty-string
     */
    public function toString(mixed $value): string
    {
        if (!\is_array($value)) {
            return '';
        }

        try {
            return (string)\count($value);
        } catch (\Throwable $cause) {
            return $cause->getMessage();
        }
    }
}
