<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableStringLengthReplacementTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Replacements;

use Iomywiab\Library\Formatting\Replacements\AbstractImmutableReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableStringLengthReplacement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableStringLengthReplacement::class)]
#[UsesClass(AbstractImmutableReplacement::class)]
class ImmutableStringLengthReplacementTest extends TestCase
{
    public function testToString(): void
    {
        self::assertSame('3', (new ImmutableStringLengthReplacement())->toString('abc'));
        self::assertSame('', (new ImmutableStringLengthReplacement())->toString(null));
    }
}
