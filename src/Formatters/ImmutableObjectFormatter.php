<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableObjectFormatter.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Formatting\Replacers\ImmutableReplacerInterface;

class ImmutableObjectFormatter extends AbstractImmutableFormatter implements ImmutableObjectFormatterInterface
{
    private readonly ImmutableIntegerFormatterInterface $integerFormatter;
    private readonly ImmutableStringFormatterInterface $stringFormatter;

    /**
     * @param ImmutableStringFormatterInterface|null $stringFormatter
     * @param ImmutableIntegerFormatterInterface|null $integerFormatter
     * @param ImmutableReplacerInterface|null $replacer
     */
    public function __construct(
        ?ImmutableStringFormatterInterface $stringFormatter = null,
        ?ImmutableIntegerFormatterInterface $integerFormatter = null,
        ?ImmutableReplacerInterface $replacer = null,
    ) {
        parent::__construct($replacer);

        $this->stringFormatter = $stringFormatter ?? new ImmutableStringFormatter();
        $this->integerFormatter = $integerFormatter ?? new ImmutableIntegerFormatter();
    }

    /**
     * @inheritDoc
     */
    public function toString(object $value): string
    {
        if (null === $this->replacer) {
            return match (true) {
                $value instanceof \DateTimeInterface => $value->format(\DateTimeInterface::ATOM),
                $value instanceof \DateInterval => $value->format('%R'),
                $value instanceof \Throwable => $this->stringFormatter->toString($value->getMessage()), // BEFORE Stringable
                $value instanceof \BackedEnum && \is_int($value->value) => $value->name.'='.$this->integerFormatter->toString($value->value), // BEFORE UnitEnum
                $value instanceof \BackedEnum && \is_string($value->value) => $value->name.'='.$this->stringFormatter->toString($value->value), // BEFORE UnitEnum
                $value instanceof \UnitEnum => $value->name,
                $value instanceof \JsonSerializable => (\is_string($string = $value->jsonSerialize()) ? $string : 'n/a'),
                $value instanceof \Stringable => $this->stringFormatter->toString((string)$value),
                // @phpstan-ignore argument.type
                \method_exists($value, 'toString') => $this->stringFormatter->toString($value->toString()),
                default => 'n/a',
            };
        }

        return $this->replacer->toString($value);
    }
}
