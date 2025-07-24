<?php

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
     * @return non-empty-string
     * @throws FormatExceptionInterface
     */
    public function toString(mixed $value): string
    {
        return $this->formatter->toString($value);
    }
}
