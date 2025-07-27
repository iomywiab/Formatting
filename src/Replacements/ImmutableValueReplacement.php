<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableValueReplacement.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatterInterface;

class ImmutableValueReplacement extends AbstractImmutableReplacement
{
    public const KEY = 'value';

    private readonly ImmutableValueFormatterInterface $formatter;

    public function __construct(?ImmutableValueFormatterInterface $formatter = null)
    {
        parent::__construct();

        $this->formatter = $formatter ?? new ImmutableValueFormatter();
    }

    /**
     * @param mixed $value
     * @return string
     * @throws FormatExceptionInterface
     */
    public function toString(mixed $value): string
    {
        return $this->formatter->toString($value);
    }
}
