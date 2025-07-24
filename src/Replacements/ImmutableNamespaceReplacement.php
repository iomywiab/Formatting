<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

class ImmutableNamespaceReplacement extends AbstractImmutableReplacement
{
    public const KEY = 'namespace';

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
            return (new \ReflectionClass($value))->getNamespaceName();
        } catch (\Throwable $cause) {
            return $cause->getMessage();
        }
    }
}
