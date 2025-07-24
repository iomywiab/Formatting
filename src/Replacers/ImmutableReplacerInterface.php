<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacers;

interface ImmutableReplacerInterface
{
    /**
     * @param mixed $value
     * @return string
     */
    public function toString(mixed $value): string;

}
