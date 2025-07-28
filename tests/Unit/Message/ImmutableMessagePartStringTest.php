<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableMessagePartStringTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 15:31
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Message;

use Iomywiab\Library\Formatting\Message\ImmutableMessagePartString;
use Iomywiab\Library\Testing\Values\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableMessagePartString::class)]
class ImmutableMessagePartStringTest extends TestCase
{
    /**
     * @return non-empty-array<non-empty-array<mixed>>
     */
    public static function provideTestData(): array
    {
        $validData = [
            ['', ''],
            ['test', 'test.'],
            ['test.', 'test.'],
        ];

        return DataProvider::injectKeys(['inputString', 'expectedString'], $validData);
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
