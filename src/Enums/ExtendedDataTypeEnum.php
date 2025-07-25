<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ExtendedDataTypeEnum.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Enums;

use Iomywiab\Library\Converting\Enums\DataTypeEnum;

enum ExtendedDataTypeEnum: string
{
    case ARRAY = 'array';
    case BOOLEAN = 'bool';
    case CLOSED_RESOURCE = 'closed-resource';
    case DATETIME = 'datetime';
    case ENUM = 'unit-enum';
    case INT_ENUM = 'int-enum';
    case LIST = 'list';
    case NEGATIVE_FLOAT = 'negative-float';
    case NEGATIVE_INTEGER = 'negative-int';
    case NON_EMPTY_ARRAY = 'non-empty-array';
    case NON_EMPTY_LIST = 'non-empty-list';
    case NON_EMPTY_STRING = 'non-empty-string';
    case NON_NEGATIVE_FLOAT = 'non-negative-float';
    case NON_NEGATIVE_INTEGER = 'non-negative-int';
    case NULL = 'null';
    case OBJECT = 'object';
    case POSITIVE_FLOAT = 'positive-float';
    case POSITIVE_INTEGER = 'positive-int';
    case RESOURCE = 'resource';
    case STRING = 'string';
    case STRING_ENUM = 'string-enum';
    case UNKNOWN = '?';

    /**
     * @param array<array-key,mixed> $value
     * @return self
     */
    private static function fromArray(array $value): self
    {
        if ([] === $value) {
            return self::LIST;
        }

        $index = -1;
        foreach ($value as $key => $ignore) {
            $index++;
            if ($key !== $index) {
                return self::NON_EMPTY_ARRAY;
            }
        }

        return self::NON_EMPTY_LIST;
    }

    /**
     * @param mixed $value
     * @return self
     */
    public static function fromData(mixed $value): self
    {
        $type = DataTypeEnum::fromData($value);

        return match ($type) {
            DataTypeEnum::ARRAY => self::fromArray($value),
            DataTypeEnum::BOOLEAN => self::BOOLEAN,
            DataTypeEnum::FLOAT => match (true) {
                $value < 0.0 => self::NEGATIVE_FLOAT,
                $value > 0.0 => self::POSITIVE_FLOAT,
                default => self::NON_NEGATIVE_FLOAT,
            },
            DataTypeEnum::INTEGER => match (true) {
                $value < 0 => self::NEGATIVE_INTEGER,
                $value > 0 => self::POSITIVE_INTEGER,
                default => self::NON_NEGATIVE_INTEGER,
            },
            DataTypeEnum::NULL => self::NULL,
            DataTypeEnum::OBJECT => match (true) {
                $value instanceof \BackedEnum && (\is_string($value->value)) => self::STRING_ENUM,
                $value instanceof \BackedEnum && (\is_int($value->value)) => self::INT_ENUM,
                $value instanceof \UnitEnum => self::ENUM,
                $value instanceof \DateTimeInterface => self::DATETIME,
                default => self::OBJECT
            },
            DataTypeEnum::RESOURCE => self::RESOURCE,
            DataTypeEnum::RESOURCE_CLOSED => self::CLOSED_RESOURCE,
            DataTypeEnum::STRING => ('' === $value) ? self::STRING : self::NON_EMPTY_STRING,
            DataTypeEnum::UNKNOWN => self::UNKNOWN,
        };
    }

    /**
     * @return DataTypeEnum
     */
    public function toDataType(): DataTypeEnum
    {
        return match ($this) {
            self::ARRAY, self::LIST, self::NON_EMPTY_ARRAY, self::NON_EMPTY_LIST => DataTypeEnum::ARRAY,
            self::BOOLEAN => DataTypeEnum::BOOLEAN,
            self::CLOSED_RESOURCE => DataTypeEnum::RESOURCE_CLOSED,
            self::DATETIME, self::ENUM, self::INT_ENUM, self::OBJECT, self::STRING_ENUM => DataTypeEnum::OBJECT,
            self::NEGATIVE_FLOAT, self::NON_NEGATIVE_FLOAT, self::POSITIVE_FLOAT => DataTypeEnum::FLOAT,
            self::NEGATIVE_INTEGER, self::NON_NEGATIVE_INTEGER, self::POSITIVE_INTEGER => DataTypeEnum::INTEGER,
            self::NON_EMPTY_STRING, self::STRING => DataTypeEnum::STRING,
            self::NULL => DataTypeEnum::NULL,
            self::RESOURCE => DataTypeEnum::RESOURCE,
            self::UNKNOWN => DataTypeEnum::UNKNOWN,
        };
    }
}
