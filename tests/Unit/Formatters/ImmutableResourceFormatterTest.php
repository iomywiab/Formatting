<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableResourceFormatterTest.php
 * Project: Formatting
 * Modified at: 30/07/2025, 13:16
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Formatters;

use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;
use Iomywiab\Library\Formatting\Formatters\ImmutableResourceFormatter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableResourceFormatter::class)]
#[UsesClass(ImmutableResourceFormatter::class)]
class ImmutableResourceFormatterTest extends TestCase
{
    /**
     * @return \Generator<non-empty-array<mixed>>
     */
    public static function provideTestData(): \Generator
    {
        yield ['input' => null, 'expectedPrefix' => ''];
        yield ['input' => STDOUT, 'expectedPrefix' => 'stream(id:'];
    }

    /**
     * @param mixed $input
     * @param string $expectedPrefix
     * @return void
     * @dataProvider provideTestData
     * @throws FormatExceptionInterface
     */
    public function testToString(mixed $input, string $expectedPrefix): void
    {
        $part = new ImmutableResourceFormatter();
        if ('' === $expectedPrefix) {
            // @phpstan-ignore argument.type
            self::assertSame('', $part->toString($input));

            return;
        }
        // @phpstan-ignore argument.type
        self::assertStringStartsWith($expectedPrefix, $part->toString($input));
    }
}
