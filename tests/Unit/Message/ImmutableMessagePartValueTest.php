<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableMessagePartValueTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 15:31
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
use Iomywiab\Library\Testing\Values\DataProvider;
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
     * @return non-empty-array<non-empty-array<mixed>>
     */
    public static function provideTestData(): array
    {
        $validData = [
            ['name', null, 'name=null'],
            ['name', true, 'name=true'],
            ['name', false, 'name=false'],
            ['name', -2.3, 'name=-2.3'],
            ['name', -1.0, 'name=-1.0'],
            ['name', 0.0, 'name=0.0'],
            ['name', 1.0, 'name=1.0'],
            ['name', 2.3, 'name=2.3'],
            ['name', -1, 'name=-1'],
            ['name', 0, 'name=0'],
            ['name', 1, 'name=1'],
            ['name', '', 'name=""'],
            ['name', 'abc', 'name="abc"'],
        ];

        return DataProvider::injectKeys(['name', 'value', 'expectedString'], $validData);
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
