<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

abstract class AbstractImmutableReplacement implements ImmutableReplacementInterface
{
    public const KEY = '';

    public function __construct()
    {
        \assert('' !== static::KEY);
    }

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return static::KEY;
    }
}
