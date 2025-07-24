<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;

interface ImmutableNullFormatterInterface
{
    /**
     * @param mixed $value
     * @return string
     * @throws FormatExceptionInterface
     */
    public function toString(mixed $value): string;
}
