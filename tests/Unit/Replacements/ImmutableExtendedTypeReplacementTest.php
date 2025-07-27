<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableExtendedTypeReplacementTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Replacements;

use Iomywiab\Library\Formatting\Enums\ExtendedDataTypeEnum;
use Iomywiab\Library\Formatting\Replacements\AbstractImmutableReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableExtendedTypeReplacement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableExtendedTypeReplacement::class)]
#[CoversClass(AbstractImmutableReplacement::class)]
#[CoversClass(ExtendedDataTypeEnum::class)]
class ImmutableExtendedTypeReplacementTest extends TestCase
{
    public function testToString(): void
    {
        self::assertSame('non-empty-string', (new ImmutableExtendedTypeReplacement())->toString('abc'));
    }
}
