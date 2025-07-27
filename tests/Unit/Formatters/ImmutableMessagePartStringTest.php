<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableMessagePartStringTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Formatters;

use Iomywiab\Library\Formatting\Message\ImmutableMessagePartString;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableMessagePartString::class)]
class ImmutableMessagePartStringTest extends TestCase
{
    public function testToString(): void
    {
        self::assertSame('', (new ImmutableMessagePartString(''))->toString());
        self::assertSame('abc.', (new ImmutableMessagePartString('abc'))->toString());
        self::assertSame('abc.', (new ImmutableMessagePartString('abc.'))->toString());
    }
}
