<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableTemplateReplacerTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 09:16
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
     * @return non-empty-list<non-empty-list<mixed>>
     */
    public static function provideTestData(): array
    {
        $replacements = Replacements::get();

        /** @noinspection SpellCheckingInspection */
        return [
            ['', $replacements, new Stringable4Testing(), ''],
            ['{type}', $replacements, new Stringable4Testing(), 'object'],
            ['a{type}', $replacements, new Stringable4Testing(), 'aobject'],
            ['{type}b', $replacements, new Stringable4Testing(), 'objectb'],
            ['a{type}b', $replacements, new Stringable4Testing(), 'aobjectb'],
            ['{type}{type}', $replacements, new Stringable4Testing(), 'objectobject'],
            ['{type}a{type}', $replacements, new Stringable4Testing(), 'objectaobject'],
            ['{class:name}', $replacements, new Stringable4Testing(), 'Stringable4Testing'],
            ['{namespace}', $replacements, new Stringable4Testing(), 'Iomywiab\Library\Testing\DataTypes'],
            ['{type:extended}', $replacements, 'abc', 'non-empty-string'],
            ['{array:size}', $replacements, [1, 2, 3], '3'],
            ['{string:length}', $replacements, 'abc', '3'],
            ['{value}', $replacements, 'abc', '"abc"'],
            ['{array:key:type}', $replacements, [1, 'a', true], 'int'],
            ['{array:key:type:extended}', $replacements, [1, 'a', true], 'non-negative-int|positive-int'],
            ['{array:value:type}', $replacements, [1, 'a', true], 'bool|int|string'],
            ['{array:value:type:extended}', $replacements, [1, 'a', true], 'bool|non-empty-string|positive-int'],
        ];
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
