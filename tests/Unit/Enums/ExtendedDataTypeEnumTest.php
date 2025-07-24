<?php

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Enums;

use Iomywiab\Library\Converting\Enums\DataTypeEnum;
use Iomywiab\Library\Formatting\Enums\ExtendedDataTypeEnum;
use Iomywiab\Library\Testing\DataTypes\Enum4Testing;
use Iomywiab\Library\Testing\DataTypes\IntEnum4Testing;
use Iomywiab\Library\Testing\DataTypes\Stringable4Testing;
use Iomywiab\Library\Testing\DataTypes\StringEnum4Testing;
use PHPUnit\Framework\TestCase;

class ExtendedDataTypeEnumTest extends TestCase
{
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
    public function testFromDataForClosedResource(): void
    {
        $closedResource = \fopen('php://memory', 'rb');
        if (false !== $closedResource) {
            \fclose($closedResource);
        }

        self::assertSame(ExtendedDataTypeEnum::CLOSED_RESOURCE, ExtendedDataTypeEnum::fromData($closedResource));
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
     * @return non-empty-list<non-empty-list<mixed>>
     */
    public static function provideDataForFromData(): array
    {
        return [
            [true, [], ExtendedDataTypeEnum::LIST],
            [true, [1], ExtendedDataTypeEnum::NON_EMPTY_LIST],
            [true, ['a' => 1], ExtendedDataTypeEnum::NON_EMPTY_ARRAY],
            [true, true, ExtendedDataTypeEnum::BOOLEAN],
            [true, false, ExtendedDataTypeEnum::BOOLEAN],
            [true, -1.2, ExtendedDataTypeEnum::NEGATIVE_FLOAT],
            [true, 0.0, ExtendedDataTypeEnum::NON_NEGATIVE_FLOAT],
            [true, 1.2, ExtendedDataTypeEnum::POSITIVE_FLOAT],
            [true, -3, ExtendedDataTypeEnum::NEGATIVE_INTEGER],
            [true, 0, ExtendedDataTypeEnum::NON_NEGATIVE_INTEGER],
            [true, 3, ExtendedDataTypeEnum::POSITIVE_INTEGER],
            [true, null, ExtendedDataTypeEnum::NULL],
            [true, new \stdClass(), ExtendedDataTypeEnum::OBJECT],
            [true, new \DateTime(), ExtendedDataTypeEnum::DATETIME],
            [true, Enum4Testing::ONE, ExtendedDataTypeEnum::ENUM],
            [true, IntEnum4Testing::ONE, ExtendedDataTypeEnum::INT_ENUM],
            [true, StringEnum4Testing::ONE, ExtendedDataTypeEnum::STRING_ENUM],
            [true, new Stringable4Testing(), ExtendedDataTypeEnum::OBJECT],
            [true, '', ExtendedDataTypeEnum::STRING],
            [true, 'abc', ExtendedDataTypeEnum::NON_EMPTY_STRING],
        ];
    }

    /**
     * @return void
     */
    public function testToDataType(): void {
        // Check completeness (with faked assertions)
        foreach (ExtendedDataTypeEnum::cases() as $case) {
            $type = $case->toDataType();
            /** @noinspection PhpConditionAlreadyCheckedInspection */
            /** @noinspection UnnecessaryAssertionInspection */
            self::assertInstanceOf(DataTypeEnum::class, $type);
        }
    }

}
