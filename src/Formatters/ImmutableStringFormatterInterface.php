<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

interface ImmutableStringFormatterInterface
{
    /**
     * @param string $value
     * @return string
     */
    public function toString(string $value): string;
}
