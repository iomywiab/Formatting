<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableArrayKeyExtendedTypesReplacementTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Replacements;

use Iomywiab\Library\Formatting\Enums\ExtendedDataTypeEnum;
use Iomywiab\Library\Formatting\Replacements\AbstractImmutableReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableArrayKeyExtendedTypesReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableArrayKeyTypeReplacement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableArrayKeyExtendedTypesReplacement::class)]
#[UsesClass(ExtendedDataTypeEnum::class)]
#[UsesClass(AbstractImmutableReplacement::class)]
#[UsesClass(ImmutableArrayKeyTypeReplacement::class)]
class ImmutableArrayKeyExtendedTypesReplacementTest extends TestCase
{
    public function testToString(): void
    {
        self::assertSame('non-empty-string|positive-int', (new ImmutableArrayKeyExtendedTypesReplacement())->toString([1 => 2, 'one' => 'tow']));
    }
}
