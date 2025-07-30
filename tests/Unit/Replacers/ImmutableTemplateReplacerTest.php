<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableTemplateReplacerTest.php
 * Project: Formatting
 * Modified at: 30/07/2025, 13:40
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Replacers;

use Iomywiab\Library\Formatting\Enums\ExtendedDataTypeEnum;
use Iomywiab\Library\Formatting\Exceptions\FormatException;
use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;
use Iomywiab\Library\Formatting\Formatters\AbstractImmutableFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableArrayFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableObjectFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableStringFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Formatting\Replacements\AbstractImmutableReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableArrayKeyExtendedTypesReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableArrayKeyTypeReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableArraySizeReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableArrayValueExtendedTypesReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableArrayValueTypeReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableClassnameReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableExtendedTypeReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableNamespaceReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableReplacementInterface;
use Iomywiab\Library\Formatting\Replacements\ImmutableStringLengthReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableTypeReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableValueReplacement;
use Iomywiab\Library\Formatting\Replacements\Replacements;
use Iomywiab\Library\Formatting\Replacers\ImmutableTemplateReplacer;
use Iomywiab\Library\Testing\DataTypes\Stringable4Testing;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableTemplateReplacer::class)]
#[UsesClass(FormatException::class)]
#[UsesClass(AbstractImmutableFormatter::class)]
#[UsesClass(ImmutableArrayFormatter::class)]
#[UsesClass(ImmutableObjectFormatter::class)]
#[UsesClass(ImmutableValueFormatter::class)]
#[UsesClass(AbstractImmutableReplacement::class)]
#[UsesClass(ImmutableValueReplacement::class)]
#[UsesClass(Replacements::class)]
#[UsesClass(ImmutableTypeReplacement::class)]
#[UsesClass(ImmutableClassnameReplacement::class)]
#[UsesClass(ExtendedDataTypeEnum::class)]
#[UsesClass(ImmutableExtendedTypeReplacement::class)]
#[UsesClass(ImmutableStringLengthReplacement::class)]
#[UsesClass(ImmutableArrayKeyTypeReplacement::class)]
#[UsesClass(ImmutableArrayValueTypeReplacement::class)]
#[UsesClass(ImmutableNamespaceReplacement::class)]
#[UsesClass(ImmutableArraySizeReplacement::class)]
#[UsesClass(ImmutableStringFormatter::class)]
#[UsesClass(ImmutableArrayKeyExtendedTypesReplacement::class)]
#[UsesClass(ImmutableArrayValueExtendedTypesReplacement::class)]
class ImmutableTemplateReplacerTest extends TestCase
{
    /**
     * @return \Generator<array{template: string, replacements: non-empty-array<non-empty-string, ImmutableReplacementInterface>, value: mixed, expectedString: string}>
     * @noinspection SpellCheckingInspection
     */
    public static function provideTestData(): \Generator
    {
        $replacements = Replacements::get();

        yield ['template' => '', 'replacements' => $replacements, 'value' => new Stringable4Testing(), 'expectedString' => ''];
        yield ['template' => '{type}', 'replacements' => $replacements, 'value' => new Stringable4Testing(), 'expectedString' => 'object'];
        yield ['template' => 'a{type}', 'replacements' => $replacements, 'value' => new Stringable4Testing(), 'expectedString' => 'aobject'];
        yield ['template' => '{type}b', 'replacements' => $replacements, 'value' => new Stringable4Testing(), 'expectedString' => 'objectb'];
        yield ['template' => 'a{type}b', 'replacements' => $replacements, 'value' => new Stringable4Testing(), 'expectedString' => 'aobjectb'];
        yield ['template' => '{type}{type}', 'replacements' => $replacements, 'value' => new Stringable4Testing(), 'expectedString' => 'objectobject'];
        yield ['template' => '{type}a{type}', 'replacements' => $replacements, 'value' => new Stringable4Testing(), 'expectedString' => 'objectaobject'];
        yield ['template' => '{class:name}', 'replacements' => $replacements, 'value' => new Stringable4Testing(), 'expectedString' => 'Stringable4Testing'];
        yield ['template' => '{namespace}', 'replacements' => $replacements, 'value' => new Stringable4Testing(), 'expectedString' => 'Iomywiab\Library\Testing\DataTypes'];
        yield ['template' => '{type:extended}', 'replacements' => $replacements, 'value' => 'abc', 'expectedString' => 'non-empty-string'];
        yield ['template' => '{array:size}', 'replacements' => $replacements, 'value' => [1, 2, 3], 'expectedString' => '3'];
        yield ['template' => '{string:length}', 'replacements' => $replacements, 'value' => 'abc', 'expectedString' => '3'];
        yield ['template' => '{value}', 'replacements' => $replacements, 'value' => 'abc', 'expectedString' => '"abc"'];
        yield ['template' => '{array:key:type}', 'replacements' => $replacements, 'value' => [1, 'a', true], 'expectedString' => 'int'];
        yield ['template' => '{array:key:type:extended}', 'replacements' => $replacements, 'value' => [1, 'a', true], 'expectedString' => 'non-negative-int|positive-int'];
        yield ['template' => '{array:value:type}', 'replacements' => $replacements, 'value' => [1, 'a', true], 'expectedString' => 'bool|int|string'];
        yield ['template' => '{array:value:type:extended}', 'replacements' => $replacements, 'value' => [1, 'a', true], 'expectedString' => 'bool|non-empty-string|positive-int'];
    }

    /**
     * @param non-empty-string $template
     * @param array<array-key,ImmutableReplacementInterface> $replacements
     * @param mixed $value
     * @param string $expectedString
     * @return void
     * @throws FormatExceptionInterface
     * @dataProvider provideTestData
     */
    public function testToString(string $template, array $replacements, mixed $value, string $expectedString): void
    {
        $formatter = new ImmutableTemplateReplacer($template, $replacements);
        self::assertSame($expectedString, $formatter->toString($value));
    }

    public function testUnknownTag(): void
    {
        $this->expectException(FormatExceptionInterface::class);
        new ImmutableTemplateReplacer('{tag:unknown}');
    }
}
