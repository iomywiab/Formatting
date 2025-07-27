<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: DependencyNotFoundExceptionTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Helpers\Exceptions;

use Iomywiab\Library\Formatting\Enums\ExtendedDataTypeEnum;
use Iomywiab\Library\Formatting\Formatters\AbstractImmutableFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableArrayFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableDebugValueFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableListFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableObjectFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableStringFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Formatting\Helpers\Exceptions\DependencyNotFoundException;
use Iomywiab\Library\Formatting\Message\ImmutableMessagePartString;
use Iomywiab\Library\Formatting\Message\ImmutableMessagePartValue;
use Iomywiab\Library\Formatting\Message\Message;
use Iomywiab\Library\Formatting\Replacements\AbstractImmutableReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableExtendedTypeReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableStringLengthReplacement;
use Iomywiab\Library\Formatting\Replacements\ImmutableValueReplacement;
use Iomywiab\Library\Formatting\Replacements\Replacements;
use Iomywiab\Library\Formatting\Replacers\ImmutableTemplateReplacer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DependencyNotFoundException::class)]
#[UsesClass(ExtendedDataTypeEnum::class)]
#[UsesClass(AbstractImmutableFormatter::class)]
#[UsesClass(ImmutableArrayFormatter::class)]
#[UsesClass(ImmutableDebugValueFormatter::class)]
#[UsesClass(ImmutableListFormatter::class)]
#[UsesClass(ImmutableObjectFormatter::class)]
#[UsesClass(ImmutableStringFormatter::class)]
#[UsesClass(ImmutableValueFormatter::class)]
#[UsesClass(ImmutableMessagePartString::class)]
#[UsesClass(ImmutableMessagePartValue::class)]
#[UsesClass(Message::class)]
#[UsesClass(AbstractImmutableReplacement::class)]
#[UsesClass(ImmutableExtendedTypeReplacement::class)]
#[UsesClass(ImmutableStringLengthReplacement::class)]
#[UsesClass(ImmutableValueReplacement::class)]
#[UsesClass(Replacements::class)]
#[UsesClass(ImmutableTemplateReplacer::class)]
class DependencyNotFoundExceptionTest extends TestCase
{
    /**
     */
    public function testException(): void
    {
        $exception = new DependencyNotFoundException(__CLASS__, new \Exception('test'));
        self::assertSame(
            'Found error. error="Dependency not found/registered" expected="Dependency exists" got=non-empty-string(81):"Iomywiab\Tests\Formatting\Unit\Helpers\Exceptions\DependencyNotFoundExceptionTest" name="className"',
            $exception->getMessage());
    }
}
