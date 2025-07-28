<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableArrayFormatterTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 15:42
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Formatters;

use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;
use Iomywiab\Library\Formatting\Formatters\AbstractImmutableFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableArrayFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableIntegerFormatter;
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

#[CoversClass(ImmutableArrayFormatter::class)]
#[UsesClass(AbstractImmutableFormatter::class)]
#[UsesClass(ImmutableObjectFormatter::class)]
#[UsesClass(ImmutableValueFormatter::class)]
#[UsesClass(ImmutableIntegerFormatter::class)]
#[UsesClass(AbstractImmutableReplacement::class)]
#[UsesClass(ImmutableValueReplacement::class)]
#[UsesClass(Replacements::class)]
#[UsesClass(ImmutableTemplateReplacer::class)]
class ImmutableArrayFormatterTest extends TestCase
{
    /**
     * @return non-empty-array<non-empty-array<mixed>>
     */
    public static function provideTestData(): array
    {
        $validData = [
            [[], '[]'],
            [[1], '[0=>1]'],
            [[1, 2], '[0=>1, 1=>2]'],
        ];

        return DataProvider::injectKeys(['inputArray', 'expectedString'], $validData);
    }

    /**
     * @param array<mixed> $inputArray
     * @param string $expectedString
     * @return void
     * @throws FormatExceptionInterface
     * @dataProvider provideTestData
     */
    public function testToString(array $inputArray, string $expectedString): void
    {
        $part = new ImmutableArrayFormatter();
        self::assertSame($expectedString, $part->toString($inputArray));

        $part = new ImmutableArrayFormatter(replacer: new ImmutableTemplateReplacer('{value}'));
        self::assertSame($expectedString, $part->toString($inputArray));
    }
}
