<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableValueFormatter.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Converting\Convert;
use Iomywiab\Library\Converting\Enums\DataTypeEnum;
use Iomywiab\Library\Formatting\Enums\SizeUnitEnum;
use Iomywiab\Library\Formatting\Exceptions\FormatException;
use Iomywiab\Library\Formatting\Exceptions\UnsupportedCaseFormatException;

/**
 * Class to format different types (mostly scalars) to pretty strings.
 * * Please note: This is not for conversion
 * * @see Convert
 */
class ImmutableValueFormatter implements ImmutableValueFormatterInterface
{
    private readonly ImmutableArrayFormatterInterface $arrayFormatter;
    private readonly ImmutableBooleanFormatterInterface $booleanFormatter;
    private readonly ImmutableFloatFormatterInterface $floatFormatter;
    private readonly ImmutableIntegerFormatterInterface $integerFormatter;
    private readonly ImmutableNullFormatterInterface $nullFormatter;
    private readonly ImmutableObjectFormatterInterface $objectFormatter;
    private readonly ImmutableResourceFormatterInterface $resourceFormatter;
    private readonly ImmutableStringFormatterInterface $stringFormatter;

    /**
     * @param ImmutableArrayFormatterInterface|null $arrayFormatter
     * @param ImmutableObjectFormatterInterface|null $objectFormatter
     * @param ImmutableResourceFormatterInterface|null $resourceFormatter
     * @param ImmutableNullFormatterInterface|null $nullFormatter
     * @param ImmutableStringFormatterInterface|null $stringFormatter
     * @param ImmutableBooleanFormatterInterface|null $booleanFormatter
     * @param ImmutableFloatFormatterInterface|null $floatFormatter
     * @param ImmutableIntegerFormatterInterface|null $integerFormatter
     */
    public function __construct(
        ?ImmutableArrayFormatterInterface $arrayFormatter = null,
        ?ImmutableObjectFormatterInterface $objectFormatter = null,
        ?ImmutableResourceFormatterInterface $resourceFormatter = null,
        ?ImmutableNullFormatterInterface $nullFormatter = null,
        ?ImmutableStringFormatterInterface $stringFormatter = null,
        ?ImmutableBooleanFormatterInterface $booleanFormatter = null,
        ?ImmutableFloatFormatterInterface $floatFormatter = null,
        ?ImmutableIntegerFormatterInterface $integerFormatter = null,
    ) {
        $this->stringFormatter = $stringFormatter ?? new ImmutableStringFormatter();
        $this->integerFormatter = $integerFormatter ?? new ImmutableIntegerFormatter();
        $this->arrayFormatter = $arrayFormatter ?? new ImmutableArrayFormatter($this, $this);
        $this->objectFormatter = $objectFormatter ?? new ImmutableObjectFormatter($this->stringFormatter, $this->integerFormatter);
        $this->resourceFormatter = $resourceFormatter ?? new ImmutableResourceFormatter();
        $this->nullFormatter = $nullFormatter ?? new ImmutableNullFormatter();
        $this->booleanFormatter = $booleanFormatter ?? new ImmutableBooleanFormatter();
        $this->floatFormatter = $floatFormatter ?? new ImmutableFloatFormatter();
    }

    /**
     * @inheritDoc
     */
    public function toHumanSize(int $bytes, null|SizeUnitEnum $unit = null): string
    {
        \assert(0 <= $bytes);

        if (null === $unit) {
            $unit = match (true) {
                // @phpstan-ignore voku.BooleanAnd, voku.BooleanAndNode, greater.alwaysFalse, voku.Match, booleanAnd.alwaysFalse
                (1 << 100) > 0 && $bytes >= (1 << 100) => SizeUnitEnum::QB,
                // @phpstan-ignore voku.BooleanAnd, voku.BooleanAndNode, greater.alwaysFalse, voku.Match, booleanAnd.alwaysFalse
                (1 << 90) > 0 && $bytes >= (1 << 90) => SizeUnitEnum::RB,
                // @phpstan-ignore voku.BooleanAnd, voku.BooleanAndNode, greater.alwaysFalse, voku.Match, booleanAnd.alwaysFalse
                (1 << 80) > 0 && $bytes >= (1 << 80) => SizeUnitEnum::YB,
                // @phpstan-ignore voku.BooleanAnd, voku.BooleanAndNode, greater.alwaysFalse, voku.Match, booleanAnd.alwaysFalse
                (1 << 70) > 0 && $bytes >= (1 << 70) => SizeUnitEnum::ZB,
                // @phpstan-ignore greater.alwaysTrue
                (1 << 60) > 0 && $bytes >= (1 << 60) => SizeUnitEnum::EB,
                // @phpstan-ignore greater.alwaysTrue
                (1 << 50) > 0 && $bytes >= (1 << 50) => SizeUnitEnum::PB,
                // @phpstan-ignore greater.alwaysTrue
                (1 << 40) > 0 && $bytes >= (1 << 40) => SizeUnitEnum::TB,
                $bytes >= (1 << 30) => SizeUnitEnum::GB,
                $bytes >= (1 << 20) => SizeUnitEnum::MB,
                $bytes >= (1 << 10) => SizeUnitEnum::KB,
                // @phpstan-ignore greaterOrEqual.alwaysTrue
                $bytes >= 0 => SizeUnitEnum::B,
                default => throw new UnsupportedCaseFormatException($unit),
            };
        }

        $size = match ($unit) {
            // @phpstan-ignore binaryOp.invalid
            SizeUnitEnum::QB => $bytes / (1 << 100),
            // @phpstan-ignore binaryOp.invalid
            SizeUnitEnum::RB => $bytes / (1 << 90),
            // @phpstan-ignore binaryOp.invalid
            SizeUnitEnum::YB => $bytes / (1 << 80),
            // @phpstan-ignore binaryOp.invalid
            SizeUnitEnum::ZB => $bytes / (1 << 70),
            SizeUnitEnum::EB => $bytes / (1 << 60),
            SizeUnitEnum::PB => $bytes / (1 << 50),
            SizeUnitEnum::TB => $bytes / (1 << 40),
            SizeUnitEnum::GB => $bytes / (1 << 30),
            SizeUnitEnum::MB => $bytes / (1 << 20),
            SizeUnitEnum::KB => $bytes / (1 << 10),
            SizeUnitEnum::B => $bytes,
        };

        $decimals = (SizeUnitEnum::B === $unit) ? 0 : 2;
        $postfix = (1 === $bytes) ? 'byte' : $unit->value;

        \assert(\is_float($size) || \is_int($size));

        return \number_format((float)$size, $decimals).' '.$postfix;
    }

    /**
     * @inheritDoc
     */
    public function toString(mixed $value): string
    {
        try {
            $type = DataTypeEnum::fromData($value);

            return match ($type) {
                // @phpstan-ignore argument.type
                DataTypeEnum::ARRAY => /** @var array<array-key,mixed> $value */ $this->arrayFormatter->toString($value),
                // @phpstan-ignore argument.type
                DataTypeEnum::BOOLEAN => /** @var bool $value */ $this->booleanFormatter->toString($value),
                // @phpstan-ignore argument.type
                DataTypeEnum::FLOAT => /** @var float $value */ $this->floatFormatter->toString($value),
                DataTypeEnum::NULL => $this->nullFormatter->toString($value),
                // @phpstan-ignore argument.type
                DataTypeEnum::INTEGER => /** @var int $value */ $this->integerFormatter->toString($value),
                // @phpstan-ignore argument.type
                DataTypeEnum::OBJECT => /** @var object $value */ $this->objectFormatter->toString($value),
                // @phpstan-ignore argument.type
                DataTypeEnum::STRING => /** @var string $value */ $this->stringFormatter->toString($value),
                // @phpstan-ignore argument.type
                DataTypeEnum::RESOURCE => /** @var resource $value */ $this->resourceFormatter->toString($value),
                DataTypeEnum::RESOURCE_CLOSED,
                DataTypeEnum::UNKNOWN => $type->value,
            };
        } catch (\Throwable $cause) {
            throw new FormatException('Unable to print value to string', $cause);
        }
    }
}
