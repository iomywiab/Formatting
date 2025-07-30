<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableObjectFormatterTest.php
 * Project: Formatting
 * Modified at: 30/07/2025, 13:16
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Formatters;

use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;
use Iomywiab\Library\Formatting\Formatters\AbstractImmutableFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableArrayFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableObjectFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableStringFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Formatting\Replacements\AbstractImmutableReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableValueReplacement;
use Iomywiab\Library\Formatting\Replacements\Replacements;
use Iomywiab\Library\Formatting\Replacers\ImmutableTemplateReplacer;
use Iomywiab\Library\Testing\DataTypes\Enum4Testing;
use Iomywiab\Library\Testing\DataTypes\Stringable4Testing;
use Iomywiab\Library\Testing\DataTypes\StringEnum4Testing;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableObjectFormatter::class)]
#[UsesClass(AbstractImmutableFormatter::class)]
#[UsesClass(ImmutableStringFormatter::class)]
#[UsesClass(ImmutableArrayFormatter::class)]
#[UsesClass(ImmutableObjectFormatter::class)]
#[UsesClass(ImmutableValueFormatter::class)]
#[UsesClass(AbstractImmutableReplacement::class)]
#[UsesClass(ImmutableValueReplacement::class)]
#[UsesClass(Replacements::class)]
#[UsesClass(ImmutableTemplateReplacer::class)]
class ImmutableObjectFormatterTest extends TestCase
{
    /**
     * @return \Generator<non-empty-array<mixed>>
     * @throws \Exception
     */
    public static function provideTestData(): \Generator
    {
        yield ['input' => new \DateTime('1970-01-01 00:00:00', new \DateTimeZone('UTC')), 'expectedString' => '1970-01-01T00:00:00+00:00'];
        yield ['input' => new \Exception('test'), 'expectedString' => '"test"'];
        yield ['input' => Enum4Testing::ONE, 'expectedString' => 'ONE'];
        yield ['input' => StringEnum4Testing::ONE, 'expectedString' => 'ONE="One"'];
        yield ['input' => new Stringable4Testing(), 'expectedString' => '"stringable"'];
    }

    /**
     * @param object $input
     * @param string $expectedString
     * @return void
     * @throws FormatExceptionInterface
     * @dataProvider provideTestData
     */
    public function testToString(object $input, string $expectedString): void
    {
        $part = new ImmutableObjectFormatter();
        self::assertSame($expectedString, $part->toString($input));

        $part = new ImmutableObjectFormatter(replacer: new ImmutableTemplateReplacer('{value}'));
        self::assertSame($expectedString, $part->toString($input));
    }
}
