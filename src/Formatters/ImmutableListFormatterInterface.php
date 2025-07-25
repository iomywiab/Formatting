<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;

interface ImmutableListFormatterInterface
{
    /**
     * @param array $array
     * @return string
     * @throws FormatExceptionInterface
     */
    public function toString(array $array): string;
}
