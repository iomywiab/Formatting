<?php

/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: BoolStringEnumTest.php
 * Project: Formatting
 * Modified at: 30/07/2025, 13:53
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Enums;

use Iomywiab\Library\Formatting\Enums\BoolStringEnum;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BoolStringEnum::class)]
class BoolStringEnumTest extends TestCase
{
    public static function provideTestData(): \Generator
    {
        yield ['enum' => BoolStringEnum::ACTIVATED, 'expectedBool' => true];
        yield ['enum' => BoolStringEnum::ACTIVE, 'expectedBool' => true];
        yield ['enum' => BoolStringEnum::DEACTIVATED, 'expectedBool' => false];
        yield ['enum' => BoolStringEnum::DISABLED, 'expectedBool' => false];
        yield ['enum' => BoolStringEnum::ENABLED, 'expectedBool' => true];
        yield ['enum' => BoolStringEnum::FALSE, 'expectedBool' => false];
        yield ['enum' => BoolStringEnum::INACTIVE, 'expectedBool' => false];
        yield ['enum' => BoolStringEnum::N, 'expectedBool' => false];
        yield ['enum' => BoolStringEnum::NO, 'expectedBool' => false];
        yield ['enum' => BoolStringEnum::OFF, 'expectedBool' => false];
        yield ['enum' => BoolStringEnum::ON, 'expectedBool' => true];
        yield ['enum' => BoolStringEnum::ONE, 'expectedBool' => true];
        yield ['enum' => BoolStringEnum::TRUE, 'expectedBool' => true];
        yield ['enum' => BoolStringEnum::Y, 'expectedBool' => true];
        yield ['enum' => BoolStringEnum::YES, 'expectedBool' => true];
        yield ['enum' => BoolStringEnum::ZERO, 'expectedBool' => false];

    }

    /**
     * @return void
     */
    public function testFromBool(): void
    {
        self::assertSame(BoolStringEnum::TRUE, BoolStringEnum::fromBool(true));
        self::assertSame(BoolStringEnum::FALSE, BoolStringEnum::fromBool(false));
    }

    /**
     * @return void
     */
    public function testToArray(): void
    {
        $expected = [];
        foreach (BoolStringEnum::cases() as $case) {
            $expected [$case->value] = $case->toBool();
        }
        self::assertEquals($expected, BoolStringEnum::toArray());
    }

    /**
     * @param BoolStringEnum $enum
     * @param bool $expectedBool
     * @return void
     * @dataProvider provideTestData
     */
    public function testToBool(BoolStringEnum $enum, bool $expectedBool): void
    {
        self::assertSame($expectedBool, $enum->toBool());
    }
}
