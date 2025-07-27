<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableMessagePartValue.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Message;

use Iomywiab\Library\Formatting\Formatters\ImmutableListFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatterInterface;

class ImmutableMessagePartValue implements ImmutableMessagePartInterface
{
    private readonly ImmutableValueFormatterInterface|ImmutableListFormatter $formatter;

    /**
     * @param string $name (actually non-empty-string, but then PHPStan wrongly complains)
     */
    public function __construct(
        private readonly string $name,
        private readonly mixed $value,
        ImmutableValueFormatterInterface|ImmutableListFormatter|null $formatter = null,
    ) {
        \assert('' !== $this->name);

        $this->formatter = $formatter ?? new ImmutableValueFormatter();
    }

    /**
     * @return non-empty-string
     */
    public function toString(): string
    {
        try {
            $value = $this->formatter->toString($this->value);
        } catch (\Throwable) {
            $value = 'n/a';
        }

        return \lcfirst($this->name).'='.$value;
    }
}
