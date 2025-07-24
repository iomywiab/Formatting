<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Message;

class ImmutableMessagePartString implements ImmutableMessagePartInterface
{
    /**
     * @param string $string
     */
    public function __construct(private readonly string $string)
    {
        // no code
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        if ('' === $this->string) {
            return '';
        }

        return \str_ends_with($this->string, '.')
            ? $this->string
            : $this->string.'.';
    }
}
