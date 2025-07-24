<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

interface ImmutableReplacementInterface
{
    /**
     * @return non-empty-string
     */
    public function getKey(): string;

    /**
     * @param mixed $value
     * @return string
     */
    public function toString(mixed $value): string;
}
