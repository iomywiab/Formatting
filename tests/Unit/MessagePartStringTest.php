<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: MessagePartStringTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit;

use Iomywiab\Library\Formatting\Message\ImmutableMessagePartString;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableMessagePartString::class)]
class MessagePartStringTest extends TestCase
{
    /**
     * @return non-empty-list<non-empty-list<mixed>>
     */
    public static function provideTestData(): array
    {
        return [
            [new ImmutableMessagePartString('test'), 'test.'],
            [new ImmutableMessagePartString('test.'), 'test.'],
        ];
    }

    /**
     * @dataProvider provideTestData
     */
    public function testToString(ImmutableMessagePartString $part, string $expectedString): void
    {
        self::assertSame($expectedString, $part->toString());
    }
}
