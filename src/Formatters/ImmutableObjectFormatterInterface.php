<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;

interface ImmutableObjectFormatterInterface
{
    /**
     * @param object $value
     * @return string
     * @throws FormatExceptionInterface
     */
    public function toString(object $value): string;
}
