<?php

/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: BoolStringEnumTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
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
        $array = [
            BoolStringEnum::ACTIVATED->value   => true,
            BoolStringEnum::ACTIVE->value      => true,
            BoolStringEnum::DEACTIVATED->value => false,
            BoolStringEnum::DISABLED->value    => false,
            BoolStringEnum::ENABLED->value     => true,
            BoolStringEnum::FALSE->value       => false,
            BoolStringEnum::INACTIVE->value    => false,
            BoolStringEnum::N->value           => false,
            BoolStringEnum::NO->value          => false,
            BoolStringEnum::OFF->value         => false,
            BoolStringEnum::ON->value          => true,
            BoolStringEnum::ONE->value         => true,
            BoolStringEnum::TRUE->value        => true,
            BoolStringEnum::Y->value           => true,
            BoolStringEnum::YES->value         => true,
            BoolStringEnum::ZERO->value        => false,
        ];

        self::assertEquals($array, BoolStringEnum::toArray());
    }

    /**
     * @return void
     */
    public function testToBool(): void
    {
        $array = [
            BoolStringEnum::ACTIVATED->value   => true,
            BoolStringEnum::ACTIVE->value      => true,
            BoolStringEnum::DEACTIVATED->value => false,
            BoolStringEnum::DISABLED->value    => false,
            BoolStringEnum::ENABLED->value     => true,
            BoolStringEnum::FALSE->value       => false,
            BoolStringEnum::INACTIVE->value    => false,
            BoolStringEnum::N->value           => false,
            BoolStringEnum::NO->value          => false,
            BoolStringEnum::OFF->value         => false,
            BoolStringEnum::ON->value          => true,
            BoolStringEnum::ONE->value         => true,
            BoolStringEnum::TRUE->value        => true,
            BoolStringEnum::Y->value           => true,
            BoolStringEnum::YES->value         => true,
            BoolStringEnum::ZERO->value        => false,
        ];

        foreach (BoolStringEnum::cases() as $case) {
            self::assertSame($array[$case->value], $case->toBool());
        }
    }
}
