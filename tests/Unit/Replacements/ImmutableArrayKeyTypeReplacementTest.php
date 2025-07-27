<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableArrayKeyTypeReplacementTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Replacements;

use Iomywiab\Library\Formatting\Replacements\AbstractImmutableReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableArrayKeyTypeReplacement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableArrayKeyTypeReplacement::class)]
#[UsesClass(AbstractImmutableReplacement::class)]
class ImmutableArrayKeyTypeReplacementTest extends TestCase
{
    public function testToString(): void
    {
        self::assertSame('int|string', (new ImmutableArrayKeyTypeReplacement())->toString([1 => 2, 'one' => 'tow']));
        self::assertSame('', (new ImmutableArrayKeyTypeReplacement())->toString(null));
    }
}
