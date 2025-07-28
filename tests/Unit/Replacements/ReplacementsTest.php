<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ReplacementsTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 09:15
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Replacements;

use Iomywiab\Library\Formatting\Formatters\AbstractImmutableFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableArrayFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableObjectFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Formatting\Replacements\AbstractImmutableReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableValueReplacement;
use Iomywiab\Library\Formatting\Replacements\Replacements;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Replacements::class)]
#[UsesClass(AbstractImmutableFormatter::class)]
#[UsesClass(ImmutableArrayFormatter::class)]
#[UsesClass(ImmutableObjectFormatter::class)]
#[UsesClass(ImmutableValueFormatter::class)]
#[UsesClass(AbstractImmutableReplacement::class)]
#[UsesClass(ImmutableValueReplacement::class)]
class ReplacementsTest extends TestCase
{
    /**
     * @return void
     */
    public function testGet(): void
    {
        self::assertGreaterThanOrEqual(11, \count(Replacements::get()));
    }
}
