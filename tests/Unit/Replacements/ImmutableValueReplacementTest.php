<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableValueReplacementTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 15:30
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Replacements;

use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;
use Iomywiab\Library\Formatting\Formatters\AbstractImmutableFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableArrayFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableObjectFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableStringFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Formatting\Replacements\AbstractImmutableReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableValueReplacement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableValueReplacement::class)]
#[UsesClass(AbstractImmutableReplacement::class)]
#[UsesClass(AbstractImmutableFormatter::class)]
#[UsesClass(ImmutableArrayFormatter::class)]
#[UsesClass(ImmutableObjectFormatter::class)]
#[UsesClass(ImmutableStringFormatter::class)]
#[UsesClass(ImmutableValueFormatter::class)]
#[UsesClass(AbstractImmutableReplacement::class)]
class ImmutableValueReplacementTest extends TestCase
{
    /**
     * @return void
     * @throws FormatExceptionInterface
     */
    public function testToString(): void
    {
        self::assertSame('"abc"', (new ImmutableValueReplacement())->toString('abc'));
    }
}
