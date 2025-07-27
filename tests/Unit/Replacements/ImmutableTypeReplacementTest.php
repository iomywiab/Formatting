<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableTypeReplacementTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Replacements;

use Iomywiab\Library\Formatting\Replacements\AbstractImmutableReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableTypeReplacement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableTypeReplacement::class)]
#[CoversClass(AbstractImmutableReplacement::class)]
class ImmutableTypeReplacementTest extends TestCase
{
    public function testGetKey(): void
    {
        self::assertSame(ImmutableTypeReplacement::KEY, (new ImmutableTypeReplacement())->getKey());

    }

    public function testToString(): void
    {
        self::assertSame('string', (new ImmutableTypeReplacement())->toString('abc'));
    }
}
