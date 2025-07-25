<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableTemplateReplacerTest.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Replacers;

use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;
use Iomywiab\Library\Formatting\Replacements\Replacements;
use Iomywiab\Library\Formatting\Replacers\ImmutableTemplateReplacer;
use Iomywiab\Library\Testing\DataTypes\Stringable4Testing;
use PHPUnit\Framework\TestCase;

class ImmutableTemplateReplacerTest extends TestCase
{
    /**
     * @param string $template
     * @param array $replacements
     * @param mixed $value
     * @param string $expectedString
     * @return void
     * @throws FormatExceptionInterface
     * @dataProvider provideTestData
     */
    public function testToString(string $template, array $replacements, mixed $value, string $expectedString): void
    {
        if (12 === $this->dataName()) {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $breakpoint = true;
        }
        $formatter = new ImmutableTemplateReplacer($template, $replacements);
        self::assertSame($expectedString, $formatter->toString($value));
    }

    public static function provideTestData(): array
    {
        $replacements = Replacements::get();

        /** @noinspection SpellCheckingInspection */
        return [
            ['{type}', $replacements, new Stringable4Testing(), 'object'],
            ['a{type}', $replacements, new Stringable4Testing(), 'aobject'],
            ['{type}b', $replacements, new Stringable4Testing(), 'objectb'],
            ['a{type}b', $replacements, new Stringable4Testing(), 'aobjectb'],
            ['{type}{type}', $replacements, new Stringable4Testing(), 'objectobject'],
            ['{type}a{type}', $replacements, new Stringable4Testing(), 'objectaobject'],
            ['{class:name}', $replacements, new Stringable4Testing(), 'Stringable4Testing'],
            ['{namespace}', $replacements, new Stringable4Testing(), 'Iomywiab\Library\Testing\DataTypes'],
            ['{type:extended}', $replacements, 'abc', 'non-empty-string'],
            ['{array:size}', $replacements, [1,2,3], '3'],
            ['{string:length}', $replacements, 'abc', '3'],
            ['{value}', $replacements, 'abc', '"abc"'],
            ['{array:key:type}', $replacements, [1,'a',true], 'int'],
            ['{array:key:type:extended}', $replacements, [1,'a',true], 'non-negative-int|positive-int'],
            ['{array:value:type}', $replacements, [1,'a',true], 'bool|int|string'],
            ['{array:value:type:extended}', $replacements, [1,'a',true], 'bool|non-empty-string|positive-int'],
        ];
    }

    public function testUnknownTag():void
    {
        $this->expectException(FormatExceptionInterface::class);
        new ImmutableTemplateReplacer('{tag:unknown}');
    }
}
