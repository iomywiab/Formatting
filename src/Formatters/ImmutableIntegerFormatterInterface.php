<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;

interface ImmutableIntegerFormatterInterface
{
    /**
     * @param int $value
     * @return non-empty-string
     * @throws FormatExceptionInterface
     */
    public function toString(int $value): string;
}
