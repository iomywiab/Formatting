<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableArraySizeReplacementTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Replacements;

use Iomywiab\Library\Formatting\Replacements\AbstractImmutableReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableArraySizeReplacement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableArraySizeReplacement::class)]
#[UsesClass(AbstractImmutableReplacement::class)]
class ImmutableArraySizeReplacementTest extends TestCase
{
    public function testToString(): void
    {
        self::assertSame('3', (new ImmutableArraySizeReplacement())->toString([1, 2, 3]));
        self::assertSame('', (new ImmutableArraySizeReplacement())->toString(null));
    }
}
