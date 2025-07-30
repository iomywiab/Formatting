<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableFloatFormatterTest.php
 * Project: Formatting
 * Modified at: 30/07/2025, 13:16
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Formatters;

use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;
use Iomywiab\Library\Formatting\Formatters\AbstractImmutableFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableArrayFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableFloatFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableObjectFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Formatting\Replacements\AbstractImmutableReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableValueReplacement;
use Iomywiab\Library\Formatting\Replacements\Replacements;
use Iomywiab\Library\Formatting\Replacers\ImmutableTemplateReplacer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableFloatFormatter::class)]
#[UsesClass(AbstractImmutableFormatter::class)]
#[UsesClass(ImmutableArrayFormatter::class)]
#[UsesClass(ImmutableObjectFormatter::class)]
#[UsesClass(ImmutableValueFormatter::class)]
#[UsesClass(AbstractImmutableReplacement::class)]
#[UsesClass(ImmutableValueReplacement::class)]
#[UsesClass(Replacements::class)]
#[UsesClass(ImmutableTemplateReplacer::class)]
class ImmutableFloatFormatterTest extends TestCase
{
    /**
     * @return \Generator<non-empty-array<mixed>>
     */
    public static function provideTestData(): \Generator
    {
        yield ['input' => -1.2, 'expectedString' => '-1.2'];
        yield ['input' => -1.0, 'expectedString' => '-1.0'];
        yield ['input' => 0.0, 'expectedString' => '0.0'];
        yield ['input' => 1.0, 'expectedString' => '1.0'];
        yield ['input' => 1.2, 'expectedString' => '1.2'];
    }

    /**
     * @param float $input
     * @param string $expectedString
     * @return void
     * @throws FormatExceptionInterface
     * @dataProvider provideTestData
     */
    public function testToString(float $input, string $expectedString): void
    {
        $part = new ImmutableFloatFormatter();
        self::assertSame($expectedString, $part->toString($input));

        $part = new ImmutableFloatFormatter(new ImmutableTemplateReplacer('{value}'));
        self::assertSame($expectedString, $part->toString($input));
    }
}
