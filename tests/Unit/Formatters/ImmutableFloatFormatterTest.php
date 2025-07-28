<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableFloatFormatterTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 15:42
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
use Iomywiab\Library\Testing\Values\DataProvider;
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
     * @return non-empty-array<non-empty-array<mixed>>
     */
    public static function provideTestData(): array
    {
        $validData = [
            [-1.2, '-1.2'],
            [-1.0, '-1.0'],
            [0.0, '0.0'],
            [1.0, '1.0'],
            [1.2, '1.2'],
        ];

        return DataProvider::injectKeys(['input', 'expectedString'], $validData);
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
