<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableStringFormatterTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 15:38
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Formatters;

use Iomywiab\Library\Formatting\Formatters\AbstractImmutableFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableArrayFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableObjectFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableStringFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Formatting\Replacements\AbstractImmutableReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableValueReplacement;
use Iomywiab\Library\Formatting\Replacements\Replacements;
use Iomywiab\Library\Formatting\Replacers\ImmutableTemplateReplacer;
use Iomywiab\Library\Testing\Values\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableStringFormatter::class)]
#[UsesClass(AbstractImmutableFormatter::class)]
#[UsesClass(ImmutableArrayFormatter::class)]
#[UsesClass(ImmutableObjectFormatter::class)]
#[UsesClass(ImmutableValueFormatter::class)]
#[UsesClass(AbstractImmutableReplacement::class)]
#[UsesClass(ImmutableValueReplacement::class)]
#[UsesClass(Replacements::class)]
#[UsesClass(ImmutableTemplateReplacer::class)]
class ImmutableStringFormatterTest extends TestCase
{
    /**
     * @return non-empty-array<non-empty-array<mixed>>
     */
    public static function provideTestData(): array
    {
        $validData = [
            ['', '""'],
            ['abc', '"abc"'],
        ];

        return DataProvider::injectKeys(['inputString', 'expectedString'], $validData);
    }

    /**
     * @param string $inputString
     * @param string $expectedString
     * @return void
     * @dataProvider provideTestData
     */
    public function testToString(string $inputString, string $expectedString): void
    {
        $part = new ImmutableStringFormatter();
        self::assertSame($expectedString, $part->toString($inputString));

        $part = new ImmutableStringFormatter(new ImmutableTemplateReplacer('{value}'));
        self::assertSame($expectedString, $part->toString($inputString));
    }
}
