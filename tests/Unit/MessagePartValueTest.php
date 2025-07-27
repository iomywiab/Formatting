<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: MessagePartValueTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit;

use Iomywiab\Library\Formatting\Formatters\ImmutableBooleanFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableFloatFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableIntegerFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableNullFormatter;
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
class MessagePartValueTest extends TestCase
{
    /**
     * @return non-empty-list<non-empty-list<mixed>>
     */
    public static function provideTestData(): array
    {
        return [
            [new ImmutableMessagePartValue('name', null), 'name=null'],
            [new ImmutableMessagePartValue('name', true), 'name=true'],
            [new ImmutableMessagePartValue('name', false), 'name=false'],
            [new ImmutableMessagePartValue('name', -2.3), 'name=-2.3'],
            [new ImmutableMessagePartValue('name', -1.0), 'name=-1.0'],
            [new ImmutableMessagePartValue('name', 0.0), 'name=0.0'],
            [new ImmutableMessagePartValue('name', 1.0), 'name=1.0'],
            [new ImmutableMessagePartValue('name', 2.3), 'name=2.3'],
            [new ImmutableMessagePartValue('name', -1), 'name=-1'],
            [new ImmutableMessagePartValue('name', 0), 'name=0'],
            [new ImmutableMessagePartValue('name', 1), 'name=1'],
            [new ImmutableMessagePartValue('name', ''), 'name=""'],
            [new ImmutableMessagePartValue('name', 'abc'), 'name="abc"'],
        ];
    }

    /**
     * @dataProvider provideTestData
     */
    public function testToString(ImmutableMessagePartValue $part, string $expectedString): void
    {
        self::assertSame($expectedString, $part->toString());
    }
}
