<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ExtendedDataTypeEnumTest.php
 * Project: Formatting
 * Modified at: 30/07/2025, 13:47
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Enums;

use Iomywiab\Library\Converting\Enums\DataTypeEnum;
use Iomywiab\Library\Formatting\Enums\ExtendedDataTypeEnum;
use Iomywiab\Library\Testing\DataTypes\Enum4Testing;
use Iomywiab\Library\Testing\DataTypes\IntEnum4Testing;
use Iomywiab\Library\Testing\DataTypes\Stringable4Testing;
use Iomywiab\Library\Testing\DataTypes\StringEnum4Testing;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExtendedDataTypeEnum::class)]
class ExtendedDataTypeEnumTest extends TestCase
{
    /**
     * @return \Generator<array{isValid: bool, value: mixed, expectedEnum: ExtendedDataTypeEnum} >
     */
    public static function provideDataForFromData(): \Generator
    {
        yield ['isValid' => true, 'value' => [], 'expectedEnum' => ExtendedDataTypeEnum::LIST];
        yield ['isValid' => true, 'value' => [1], 'expectedEnum' => ExtendedDataTypeEnum::NON_EMPTY_LIST];
        yield ['isValid' => true, 'value' => ['a' => 1], 'expectedEnum' => ExtendedDataTypeEnum::NON_EMPTY_ARRAY];
        yield ['isValid' => true, 'value' => true, 'expectedEnum' => ExtendedDataTypeEnum::BOOLEAN];
        yield ['isValid' => true, 'value' => false, 'expectedEnum' => ExtendedDataTypeEnum::BOOLEAN];
        yield ['isValid' => true, 'value' => -1.2, 'expectedEnum' => ExtendedDataTypeEnum::NEGATIVE_FLOAT];
        yield ['isValid' => true, 'value' => 0.0, 'expectedEnum' => ExtendedDataTypeEnum::NON_NEGATIVE_FLOAT];
        yield ['isValid' => true, 'value' => 1.2, 'expectedEnum' => ExtendedDataTypeEnum::POSITIVE_FLOAT];
        yield ['isValid' => true, 'value' => -3, 'expectedEnum' => ExtendedDataTypeEnum::NEGATIVE_INTEGER];
        yield ['isValid' => true, 'value' => 0, 'expectedEnum' => ExtendedDataTypeEnum::NON_NEGATIVE_INTEGER];
        yield ['isValid' => true, 'value' => 3, 'expectedEnum' => ExtendedDataTypeEnum::POSITIVE_INTEGER];
        yield ['isValid' => true, 'value' => null, 'expectedEnum' => ExtendedDataTypeEnum::NULL];
        yield ['isValid' => true, 'value' => new \stdClass(), 'expectedEnum' => ExtendedDataTypeEnum::OBJECT];
        yield ['isValid' => true, 'value' => new \DateTime(), 'expectedEnum' => ExtendedDataTypeEnum::DATETIME];
        yield ['isValid' => true, 'value' => Enum4Testing::ONE, 'expectedEnum' => ExtendedDataTypeEnum::ENUM];
        yield ['isValid' => true, 'value' => IntEnum4Testing::ONE, 'expectedEnum' => ExtendedDataTypeEnum::INT_ENUM];
        yield ['isValid' => true, 'value' => StringEnum4Testing::ONE, 'expectedEnum' => ExtendedDataTypeEnum::STRING_ENUM];
        yield ['isValid' => true, 'value' => new Stringable4Testing(), 'expectedEnum' => ExtendedDataTypeEnum::OBJECT];
        yield ['isValid' => true, 'value' => '', 'expectedEnum' => ExtendedDataTypeEnum::STRING];
        yield ['isValid' => true, 'value' => 'abc', 'expectedEnum' => ExtendedDataTypeEnum::NON_EMPTY_STRING];
    }

    /**
     * @dataProvider provideDataForFromData
     * @throws \Throwable
     */
    public function testFromData(bool $isValid, mixed $value, ExtendedDataTypeEnum $expectedEnum): void
    {
        try {
            self::assertSame($expectedEnum, ExtendedDataTypeEnum::fromData($value));
            self::assertTrue($isValid);
        } catch (\Throwable $cause) {
            if (!$isValid) {
                $this->expectException($cause::class);
            }

            throw $cause;
        }
    }

    /**
     * @return void
     */
    public function testFromDataForClosedResource(): void
    {
        $closedResource = \fopen('php://memory', 'rb');
        if (false !== $closedResource) {
            \fclose($closedResource);
        }

        self::assertSame(ExtendedDataTypeEnum::CLOSED_RESOURCE, ExtendedDataTypeEnum::fromData($closedResource));
    }

    /**
     * @return void
     */
    public function testFromDataForResource(): void
    {
        $openResource = \fopen('php://memory', 'rb');
        self::assertSame(ExtendedDataTypeEnum::RESOURCE, ExtendedDataTypeEnum::fromData($openResource));
    }

    /**
     * @return void
     */
    public function testToDataType(): void
    {
        // Check completeness (with faked assertions)
        foreach (ExtendedDataTypeEnum::cases() as $case) {
            $type = $case->toDataType();
            self::assertContains($type, [DataTypeEnum::ARRAY, DataTypeEnum::BOOLEAN, DataTypeEnum::RESOURCE_CLOSED, DataTypeEnum::OBJECT, DataTypeEnum::FLOAT, DataTypeEnum::INTEGER, DataTypeEnum::STRING, DataTypeEnum::NULL, DataTypeEnum::RESOURCE, DataTypeEnum::UNKNOWN]);
        }
    }
}
