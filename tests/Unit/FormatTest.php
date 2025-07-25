<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: FormatTest.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit;


use Iomywiab\Library\Converting\Convert;
use Iomywiab\Library\Formatting\Enums\SizeUnitEnum;
use Iomywiab\Library\Formatting\Exceptions\FormatException;
use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;
use Iomywiab\Library\Formatting\Format;
use Iomywiab\Library\Testing\DataTypes\Enum4Testing;
use Iomywiab\Library\Testing\DataTypes\IntEnum4Testing;
use Iomywiab\Library\Testing\DataTypes\Stringable4Testing;
use Iomywiab\Library\Testing\DataTypes\StringEnum4Testing;
use PHPUnit\Framework\TestCase;

class FormatTest extends TestCase
{
    /**
     * @throws FormatExceptionInterface
     */
    public function testResourceToString(): void
    {
        $openResource = \fopen('php://memory', 'rb');
        $closedResource = \fopen('php://memory', 'rb');
        if (false !== $closedResource) {
            \fclose($closedResource);
        }

        self::assertStringStartsWith('stream', Format::toString($openResource));
        self::assertStringStartsWith('resource (closed)', Format::toString($closedResource));
    }

    /**
     * @param bool $isValid
     * @param mixed $value
     * @param string $expectedString
     * @param string $expectedDebugString
     * @throws FormatExceptionInterface
     * @dataProvider provideTestDataForString
     */
    public function testToString(bool $isValid, mixed $value, string $expectedString, string $expectedDebugString): void
    {
        try {
            self::assertSame($expectedString, Format::toString($value));
            self::assertSame($expectedDebugString, Format::toDebugString($value));
            self::assertTrue($isValid);
        } catch (\Throwable $cause) {
            if (!$isValid) {
                $this->expectException($cause::class);
            }

            throw $cause;
        }
    }

    /**
     * @throws \Exception
     *
     * @return non-empty-list<non-empty-list<mixed>>
     */
    public static function provideTestDataForString(): array
    {
        $timezone = new \DateTimeZone('UTC');

        return [
            // array
            [true, [], '[]', 'list(0)<,>:[]'],
            [true, [1], '[0=>1]', 'non-empty-list(1)<non-negative-int,positive-int>:[0=>1]'],
            [true, [1, 'a'], '[0=>1, 1=>"a"]', 'non-empty-list(2)<non-negative-int|positive-int,non-empty-string|positive-int>:[0=>1, 1=>"a"]'],

            // boolean
            [true, true, 'true', 'bool:true'],
            [true, false, 'false', 'bool:false'],

            // date
            [true, new \DateTime('1970-01-01', $timezone), '1970-01-01T00:00:00+00:00', 'datetime<DateTime>:1970-01-01T00:00:00+00:00'],
            [true, new \DateTime('2025-06-26', $timezone), '2025-06-26T00:00:00+00:00', 'datetime<DateTime>:2025-06-26T00:00:00+00:00'],
            [true, new Stringable4Testing(), '"stringable"', 'object<Stringable4Testing>:"stringable"'],
            [true, Enum4Testing::ONE, 'ONE', 'unit-enum<Enum4Testing>:ONE'],
            [true, IntEnum4Testing::ONE, 'ONE=1', 'int-enum<IntEnum4Testing>:ONE=1'],
            [true, StringEnum4Testing::ONE, 'ONE="One"', 'string-enum<StringEnum4Testing>:ONE="One"'],

            // float
            [true, -1.0, '-1.0', 'negative-float:-1.0'],
            [true, 1.0, '1.0', 'positive-float:1.0'],
            [true, 0.0, '0.0', 'non-negative-float:0.0'],
            [true, -2.3, '-2.3', 'negative-float:-2.3'],
            [true, 2.3, '2.3', 'positive-float:2.3'],

            // integer
            [true, -1, '-1', 'negative-int:-1'],
            [true, 0, '0', 'non-negative-int:0'],
            [true, 1, '1', 'positive-int:1'],

            // null
            [true, null, Convert::NULL_STRING, Convert::NULL_STRING],

            // string
            [true, '-1', '"-1"', 'non-empty-string(2):"-1"'],
            [true, '0', '"0"', 'non-empty-string(1):"0"'],
            [true, '1', '"1"', 'non-empty-string(1):"1"'],
        ];
    }

    /**
     * @return void
     * @throws FormatException
     */
    public function testToHumanSize(): void {
        self::assertSame('2,000 bytes', Format::toHumanSize(2000, SizeUnitEnum::B));
        self::assertSame('0 bytes', Format::toHumanSize(0));
        self::assertSame('1 byte', Format::toHumanSize(1));
        self::assertSame('1.00 KB', Format::toHumanSize(1<<10));
        self::assertSame('1.00 MB', Format::toHumanSize(1<<20));
        self::assertSame('1.00 GB', Format::toHumanSize(1<<30));
        self::assertSame('1.00 TB', Format::toHumanSize(1<<40));
        self::assertSame('1.00 PB', Format::toHumanSize(1<<50));
        self::assertSame('1.00 EB', Format::toHumanSize(1<<60));
        //self::assertSame('1.00 ZB', Format::toHumanSize(1<<70));
        //self::assertSame('1.00 YB', Format::toHumanSize(1<<80));
        //self::assertSame('1.00 RB', Format::toHumanSize(1<<90));
        //self::assertSame('1.00 QB', Format::toHumanSize(1<<100));
    }

    /**
     * @return void
     * @throws FormatException
     */
    public function testToValueList(): void
    {
        $message = Format::toValueList([1, 'a', true]);
        self::assertSame('1|"a"|true', $message);
    }

}
