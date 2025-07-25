<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableMessagePartString.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

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
