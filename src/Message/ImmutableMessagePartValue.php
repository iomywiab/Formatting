<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Message;

use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatterInterface;

class ImmutableMessagePartValue implements ImmutableMessagePartInterface
{
    private readonly ?ImmutableValueFormatterInterface $formatter;

    /**
     * @param string $name (actually non-empty-string, but then PHPStan wrongly complains)
     */
    public function __construct(
        private readonly string $name,
        private readonly mixed $value,
        ?ImmutableValueFormatterInterface $formatter = null,
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
