<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableArrayValueExtendedTypesReplacementTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Replacements;

use Iomywiab\Library\Formatting\Enums\ExtendedDataTypeEnum;
use Iomywiab\Library\Formatting\Replacements\AbstractImmutableReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableArrayValueExtendedTypesReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableArrayValueTypeReplacement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableArrayValueExtendedTypesReplacement::class)]
#[UsesClass(AbstractImmutableReplacement::class)]
#[UsesClass(ExtendedDataTypeEnum::class)]
#[UsesClass(ImmutableArrayValueTypeReplacement::class)]
class ImmutableArrayValueExtendedTypesReplacementTest extends TestCase
{
    public function testToString(): void
    {
        self::assertSame('non-empty-string|positive-int', (new ImmutableArrayValueExtendedTypesReplacement())->toString([1 => 2, 'one' => 'tow']));
    }
}
