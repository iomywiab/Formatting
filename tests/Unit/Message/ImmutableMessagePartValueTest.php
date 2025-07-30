<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableMessagePartValueTest.php
 * Project: Formatting
 * Modified at: 30/07/2025, 13:30
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Message;

use Iomywiab\Library\Formatting\Formatters\AbstractImmutableFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableArrayFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableBooleanFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableFloatFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableIntegerFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableNullFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableObjectFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableStringFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Formatting\Message\ImmutableMessagePartValue;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableMessagePartValue::class)]
#[UsesClass(ImmutableNullFormatter::class)]
#[UsesClass(ImmutableValueFormatter::class)]
#[UsesClass(ImmutableBooleanFormatter::class)]
#[UsesClass(ImmutableFloatFormatter::class)]
#[UsesClass(ImmutableIntegerFormatter::class)]
#[UsesClass(ImmutableStringFormatter::class)]
#[UsesClass(AbstractImmutableFormatter::class)]
#[UsesClass(ImmutableArrayFormatter::class)]
#[UsesClass(ImmutableObjectFormatter::class)]
class ImmutableMessagePartValueTest extends TestCase
{
    /**
     * @return \Generator<non-empty-array<mixed>>
     */
    public static function provideTestData(): \Generator
    {
        yield ['name' => 'name', 'value' => null, 'expectedString' => 'name=null'];
        yield ['name' => 'name', 'value' => true, 'expectedString' => 'name=true'];
        yield ['name' => 'name', 'value' => false, 'expectedString' => 'name=false'];
        yield ['name' => 'name', 'value' => -2.3, 'expectedString' => 'name=-2.3'];
        yield ['name' => 'name', 'value' => -1.0, 'expectedString' => 'name=-1.0'];
        yield ['name' => 'name', 'value' => 0.0, 'expectedString' => 'name=0.0'];
        yield ['name' => 'name', 'value' => 1.0, 'expectedString' => 'name=1.0'];
        yield ['name' => 'name', 'value' => 2.3, 'expectedString' => 'name=2.3'];
        yield ['name' => 'name', 'value' => -1, 'expectedString' => 'name=-1'];
        yield ['name' => 'name', 'value' => 0, 'expectedString' => 'name=0'];
        yield ['name' => 'name', 'value' => 1, 'expectedString' => 'name=1'];
        yield ['name' => 'name', 'value' => '', 'expectedString' => 'name=""'];
        yield ['name' => 'name', 'value' => 'abc', 'expectedString' => 'name="abc"'];
    }

    /**
     * @dataProvider provideTestData
     */
    public function testToString(string $name, mixed $value, string $expectedString): void
    {
        $part = new ImmutableMessagePartValue($name, $value);
        self::assertSame($expectedString, $part->toString());
    }
}
