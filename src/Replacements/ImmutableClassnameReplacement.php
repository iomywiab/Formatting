<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

class ImmutableClassnameReplacement extends AbstractImmutableReplacement
{
    public const KEY = 'class:name';

    /**
     * @param mixed $value
     * @return non-empty-string
     */
    public function toString(mixed $value): string
    {
        if (!\is_object($value)) {
            return '';
        }

        try {
            return (new \ReflectionClass($value))->getShortName();
        } catch (\Throwable $cause) {
            return $cause->getMessage();
        }
    }
}
