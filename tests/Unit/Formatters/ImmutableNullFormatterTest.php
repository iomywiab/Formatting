<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableNullFormatterTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 14:51
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Formatters;

use Iomywiab\Library\Converting\Convert;
use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;
use Iomywiab\Library\Formatting\Formatters\ImmutableNullFormatter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableNullFormatter::class)]
class ImmutableNullFormatterTest extends TestCase
{
    /**
     * @return void
     * @throws FormatExceptionInterface
     */
    public function testToString(): void
    {
        $part = new ImmutableNullFormatter();
        self::assertSame(Convert::NULL_STRING, $part->toString(null));
    }
}
