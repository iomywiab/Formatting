<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableMessagePartStringTest.php
 * Project: Formatting
 * Modified at: 30/07/2025, 13:30
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Message;

use Iomywiab\Library\Formatting\Message\ImmutableMessagePartString;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableMessagePartString::class)]
class ImmutableMessagePartStringTest extends TestCase
{
    /**
     * @return \Generator<non-empty-array<mixed>>
     */
    public static function provideTestData(): \Generator
    {
        yield ['inputString' => '', 'expectedString' => ''];
        yield ['inputString' => 'test', 'expectedString' => 'test.'];
        yield ['inputString' => 'test.', 'expectedString' => 'test.'];
    }

    /**
     * @dataProvider provideTestData
     */
    public function testToString(string $inputString, string $expectedString): void
    {
        $part = new ImmutableMessagePartString($inputString);
        self::assertSame($expectedString, $part->toString());
    }
}
