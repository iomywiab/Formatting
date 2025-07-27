<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: AllExceptionsTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Exceptions;

use Iomywiab\Library\Formatting\Exceptions\FormatException;
use Iomywiab\Library\Formatting\Exceptions\MessageFormatException;
use Iomywiab\Library\Formatting\Exceptions\UnknownSerializeMarkerFormatException;
use Iomywiab\Library\Formatting\Exceptions\UnsupportedCaseFormatException;
use Iomywiab\Library\Testing\DataTypes\Stringable4Testing;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FormatException::class)]
#[CoversClass(MessageFormatException::class)]
#[CoversClass(UnknownSerializeMarkerFormatException::class)]
#[CoversClass(UnsupportedCaseFormatException::class)]
class AllExceptionsTest extends TestCase
{
    /**
     * Please note: Data providers do not work for objects in phpunit process isolation
     */
    public function testExceptions(): void
    {
        $testData = self::provideTestData();
        foreach ($testData as $testRecord) {
            $exception = $testRecord[0];
            $expectedText = $testRecord[1];
            self::assertSame($expectedText, \is_string($exception) ? $exception : $exception->getMessage());
        }
    }

    /**
     * @return non-empty-list<non-empty-list<non-empty-string|\Throwable>>
     */
    public static function provideTestData(): array
    {
        return [
            [new FormatException('message', new \Exception('test')), 'message'],
            [new MessageFormatException('message', new \Exception('test')), 'message'],
            [new UnknownSerializeMarkerFormatException('message', new \Exception('test')), 'Unknown serialize marker. value="message"'],
            [new UnsupportedCaseFormatException('case', new \Exception('test')), 'Unsupported case in match or switch statement. case="case"'],
            [new UnsupportedCaseFormatException([], new \Exception('test')), 'Unsupported case in match or switch statement. case="Array"'],
            [new UnsupportedCaseFormatException(new Stringable4Testing(), new \Exception('test')), 'Unsupported case in match or switch statement. case="Iomywiab\Library\Testing\DataTypes\Stringable4Testing"'],
            [new UnsupportedCaseFormatException(STDOUT, new \Exception('test')), 'Unsupported case in match or switch statement. case="n/a"'],
        ];
    }
}
