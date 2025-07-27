<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableNamespaceReplacementTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Replacements;

use Iomywiab\Library\Formatting\Replacements\AbstractImmutableReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableNamespaceReplacement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableNamespaceReplacement::class)]
#[UsesClass(AbstractImmutableReplacement::class)]
class ImmutableNamespaceReplacementTest extends TestCase
{
    public function testToString(): void
    {
        self::assertSame('', (new ImmutableNamespaceReplacement())->toString(new \stdClass()));
        self::assertSame('', (new ImmutableNamespaceReplacement())->toString(null));
    }

}
