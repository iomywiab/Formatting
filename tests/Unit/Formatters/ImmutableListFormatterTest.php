<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableListFormatterTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 15:41
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Formatters;

use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;
use Iomywiab\Library\Formatting\Formatters\AbstractImmutableFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableArrayFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableIntegerFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableListFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableObjectFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Testing\Values\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableListFormatter::class)]
#[UsesClass(AbstractImmutableFormatter::class)]
#[UsesClass(ImmutableArrayFormatter::class)]
#[UsesClass(ImmutableIntegerFormatter::class)]
#[UsesClass(ImmutableObjectFormatter::class)]
#[UsesClass(ImmutableValueFormatter::class)]
class ImmutableListFormatterTest extends TestCase
{
    /**
     * @return non-empty-array<non-empty-array<mixed>>
     */
    public static function provideTestData(): array
    {
        $validData = [
            [[], ''],
            [[1], '1'],
            [[1, 2], '1|2'],
        ];

        return DataProvider::injectKeys(['inputList', 'expectedString'], $validData);
    }

    /**
     * @param array<mixed> $inputList
     * @param string $expectedString
     * @return void
     * @throws FormatExceptionInterface
     * @dataProvider provideTestData
     */
    public function testToString(array $inputList, string $expectedString): void
    {
        $part = new ImmutableListFormatter();
        self::assertSame($expectedString, $part->toString($inputList));
    }
}
