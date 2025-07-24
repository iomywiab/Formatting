<?php

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Formatters;

use Iomywiab\Library\Formatting\Enums\SizeUnitEnum;
use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;
use Iomywiab\Library\Formatting\Formatters\ImmutableDebugValueFormatter;
use Iomywiab\Library\Testing\DataTypes\Enum4Testing;
use Iomywiab\Library\Testing\DataTypes\IntEnum4Testing;
use Iomywiab\Library\Testing\DataTypes\Stringable4Testing;
use Iomywiab\Library\Testing\DataTypes\StringEnum4Testing;
use PHPUnit\Framework\TestCase;

class ImmutableDebugValueFormatterTest extends TestCase
{
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
        if (8 === $this->dataName()) {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $breakpoint = true;
        }
        $formatter = new ImmutableDebugValueFormatter();
        self::assertSame($expectedString, $formatter->toString($value));
    }

    /**
     * @return array
     * @throws \Exception
     */
    public static function provideTestData(): array
    {
        $openResource = \fopen('php://memory', 'rb');
        $closedResource = \fopen('php://memory', 'rb');
        if (false !== $closedResource) {
            \fclose($closedResource);
        }

        $validData = [
            // ARRAY
            [[], 'list(0)<,>:[]'],
            [[1], 'non-empty-list(1)<non-negative-int,positive-int>:[0=>1]'],
            [['a'=>1], 'non-empty-array(1)<non-empty-string,positive-int>:["a"=>1]'], // TODO items formatting

            // BOOLEAN
            [true, 'bool:true'],
            [false, 'bool:false'],

            // ENUM
            [Enum4Testing::ONE, 'unit-enum<Enum4Testing>:ONE'],
            [IntEnum4Testing::ONE, 'int-enum<IntEnum4Testing>:ONE=1'],
            [StringEnum4Testing::ONE, 'string-enum<StringEnum4Testing>:ONE="One"'],

            // EXCEPTION
            [new \Exception('test'), 'object<Exception>:"test"'],

            // FLOAT
            [-1.2, 'negative-float:-1.2'],
            [-1.0, 'negative-float:-1.0'],
            [0.0, 'non-negative-float:0.0'],
            [1.0, 'positive-float:1.0'],
            [1.2, 'positive-float:1.2'],

            // INTEGER
            [-1, 'negative-int:-1'],
            [0, 'non-negative-int:0'],
            [1, 'positive-int:1'],
            ['', 'string(0):""'],
            ['abc', 'non-empty-string(3):"abc"'],

            // OBJECT
            [new \DateTime('1970-01-01', new \DateTimeZone('UTC')), 'datetime<DateTime>:1970-01-01T00:00:00+00:00'],
            [new Stringable4Testing(), 'object<Stringable4Testing>:"stringable"'],

            // RESOURCE
            [$openResource, 'stream(id:'.\get_resource_id($openResource).')'],
            [$closedResource, 'resource (closed)'],
        ];

        $data = [];
        foreach ($validData as $item) {
            $data[] = ['isValid'=>true, 'value'=>$item[0], 'expectedString'=>$item[1]];
        }

        return $data;
    }

    /**
     * @return void
     * @throws FormatExceptionInterface
     */
    public function testToHumanSize(): void {
        $formatter = new ImmutableDebugValueFormatter();
        self::assertSame('2,000 bytes', $formatter->toHumanSize(2000, SizeUnitEnum::B));
        self::assertSame('0 bytes', $formatter->toHumanSize(0));
        self::assertSame('1 byte', $formatter->toHumanSize(1));
        self::assertSame('1.00 KB', $formatter->toHumanSize(1<<10));
        self::assertSame('1.00 MB', $formatter->toHumanSize(1<<20));
        self::assertSame('1.00 GB', $formatter->toHumanSize(1<<30));
        self::assertSame('1.00 TB', $formatter->toHumanSize(1<<40));
        self::assertSame('1.00 PB', $formatter->toHumanSize(1<<50));
        self::assertSame('1.00 EB', $formatter->toHumanSize(1<<60));
        //self::assertSame('1.00 ZB', $formatter->toHumanSize(1<<70));
        //self::assertSame('1.00 YB', $formatter->toHumanSize(1<<80));
        //self::assertSame('1.00 RB', $formatter->toHumanSize(1<<90));
        //self::assertSame('1.00 QB', $formatter->toHumanSize(1<<100));
    }
}
