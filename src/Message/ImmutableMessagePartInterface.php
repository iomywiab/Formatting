<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Message;

interface ImmutableMessagePartInterface
{
    /**
     * @return string
     */
    public function toString(): string;
}
