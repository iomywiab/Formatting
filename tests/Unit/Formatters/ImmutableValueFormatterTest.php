<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableValueFormatterTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 15:11
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Formatters;

use Iomywiab\Library\Formatting\Enums\ExtendedDataTypeEnum;
use Iomywiab\Library\Formatting\Enums\SizeUnitEnum;
use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;
use Iomywiab\Library\Formatting\Formatters\AbstractImmutableFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableArrayFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableBooleanFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableFloatFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableIntegerFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableObjectFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableResourceFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableStringFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Formatting\Replacements\AbstractImmutableReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableArrayKeyExtendedTypesReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableArrayKeyTypeReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableArraySizeReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableArrayValueExtendedTypesReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableArrayValueTypeReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableClassnameReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableExtendedTypeReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableStringLengthReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableTypeReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableValueReplacement;
use Iomywiab\Library\Formatting\Replacements\Replacements;
use Iomywiab\Library\Formatting\Replacers\ImmutableTemplateReplacer;
use Iomywiab\Library\Testing\DataTypes\Enum4Testing;
use Iomywiab\Library\Testing\DataTypes\IntEnum4Testing;
use Iomywiab\Library\Testing\DataTypes\Stringable4Testing;
use Iomywiab\Library\Testing\DataTypes\StringEnum4Testing;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableValueFormatter::class)]
#[UsesClass(AbstractImmutableFormatter::class)]
#[UsesClass(ImmutableArrayFormatter::class)]
#[UsesClass(ImmutableObjectFormatter::class)]
#[UsesClass(AbstractImmutableReplacement::class)]
#[UsesClass(ImmutableValueReplacement::class)]
#[UsesClass(Replacements::class)]
#[UsesClass(ImmutableTemplateReplacer::class)]
#[UsesClass(ExtendedDataTypeEnum::class)]
#[UsesClass(ImmutableArrayKeyTypeReplacement::class)]
#[UsesClass(ImmutableArraySizeReplacement::class)]
#[UsesClass(ImmutableArrayValueTypeReplacement::class)]
#[UsesClass(ImmutableExtendedTypeReplacement::class)]
#[UsesClass(ImmutableIntegerFormatter::class)]
#[UsesClass(ImmutableArrayKeyExtendedTypesReplacement::class)]
#[UsesClass(ImmutableArrayValueExtendedTypesReplacement::class)]
#[UsesClass(ImmutableStringFormatter::class)]
#[UsesClass(ImmutableBooleanFormatter::class)]
#[UsesClass(ImmutableTypeReplacement::class)]
#[UsesClass(ImmutableClassnameReplacement::class)]
#[UsesClass(ImmutableFloatFormatter::class)]
#[UsesClass(ImmutableStringLengthReplacement::class)]
#[UsesClass(ImmutableResourceFormatter::class)]
class ImmutableValueFormatterTest extends TestCase
{
    /**
     * @return non-empty-list<non-empty-array<int|non-empty-string,mixed>>
     * @throws \Exception
     */
    public static function provideTestData(): array
    {
        $openResource = \fopen('php://memory', 'rb');
        $resourceId = (false === $openResource) ? 'n/a' : \get_resource_id($openResource);
        $closedResource = \fopen('php://memory', 'rb');
        if (false !== $closedResource) {
            \fclose($closedResource);
        }

        $validData = [
            // ARRAY
            [[], '[]'],
            [[1], '[0=>1]'],
            [['a' => 1], '["a"=>1]'], // TODO items formatting

            // BOOLEAN
            [true, 'true'],
            [false, 'false'],

            // ENUM
            [Enum4Testing::ONE, 'ONE'],
            [IntEnum4Testing::ONE, 'ONE=1'],
            [StringEnum4Testing::ONE, 'ONE="One"'],

            // EXCEPTION
            [new \Exception('test'), '"test"'],

            // FLOAT
            [-1.2, '-1.2'],
            [-1.0, '-1.0'],
            [0.0, '0.0'],
            [1.0, '1.0'],
            [1.2, '1.2'],

            // INTEGER
            [-1, '-1'],
            [0, '0'],
            [1, '1'],
            ['', '""'],
            ['abc', '"abc"'],

            // OBJECT
            [new \DateTime('1970-01-01', new \DateTimeZone('UTC')), '1970-01-01T00:00:00+00:00'],
            [new Stringable4Testing(), '"stringable"'],

            // RESOURCE
            [$openResource, 'stream(id:'.$resourceId.')'],
            [$closedResource, 'resource (closed)'],
        ];

        $data = [];
        foreach ($validData as $item) {
            $data[] = ['isValid' => true, 'value' => $item[0], 'expectedString' => $item[1]];
        }

        return $data;
    }

    /**
     * @param bool $isValid
     * @param mixed $value
     * @param string $expectedString
     * @return void
     * @throws FormatExceptionInterface
     * @dataProvider provideTestData
     */
    public function testFormatter(bool $isValid, mixed $value, string $expectedString): void
    {
        $formatter = new ImmutableValueFormatter();
        self::assertSame($expectedString, $formatter->toString($value));
    }

    /**
     * @return void
     * @throws FormatExceptionInterface
     */
    public function testToHumanSize(): void
    {
        $formatter = new ImmutableValueFormatter();
        self::assertSame('2,000 bytes', $formatter->toHumanSize(2000, SizeUnitEnum::B));
        self::assertSame('0 bytes', $formatter->toHumanSize(0));
        self::assertSame('1 byte', $formatter->toHumanSize(1));
        self::assertSame('1.00 KB', $formatter->toHumanSize(1 << 10));
        self::assertSame('1.00 MB', $formatter->toHumanSize(1 << 20));
        self::assertSame('1.00 GB', $formatter->toHumanSize(1 << 30));
        self::assertSame('1.00 TB', $formatter->toHumanSize(1 << 40));
        self::assertSame('1.00 PB', $formatter->toHumanSize(1 << 50));
        self::assertSame('1.00 EB', $formatter->toHumanSize(1 << 60));
        //self::assertSame('1.00 ZB', $formatter->toHumanSize(1<<70));
        //self::assertSame('1.00 YB', $formatter->toHumanSize(1<<80));
        //self::assertSame('1.00 RB', $formatter->toHumanSize(1<<90));
        //self::assertSame('1.00 QB', $formatter->toHumanSize(1<<100));
    }
}
