<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: AllExceptionsTest.php
 * Project: Formatting
 * Modified at: 30/07/2025, 13:56
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
     * @return void
     */
    public function testExceptionConstruction(): void
    {
        $data = self::provideTestData();
        foreach ($data as $item) {
            self::assertSame($item['expectedMessage'], $item['exception']->getMessage());
        }
    }

    /**
     * @return \Generator<array{exception: \Throwable, expectedMessage: non-empty-string} >
     */
    public static function provideTestData(): \Generator
    {
        yield ['exception' => new FormatException('message', new \Exception('test')), 'expectedMessage' => 'message'];
        yield ['exception' => new MessageFormatException('message', new \Exception('test')), 'expectedMessage' => 'message'];
        yield ['exception' => new UnknownSerializeMarkerFormatException('message', new \Exception('test')), 'expectedMessage' => 'Unknown serialize marker. value="message"'];
        yield ['exception' => new UnsupportedCaseFormatException('case', new \Exception('test')), 'expectedMessage' => 'Unsupported case in match or switch statement. case="case"'];
        yield ['exception' => new UnsupportedCaseFormatException([], new \Exception('test')), 'expectedMessage' => 'Unsupported case in match or switch statement. case="Array"'];
        yield ['exception' => new UnsupportedCaseFormatException(new Stringable4Testing(), new \Exception('test')), 'expectedMessage' => 'Unsupported case in match or switch statement. case="Iomywiab\Library\Testing\DataTypes\Stringable4Testing"'];
        yield ['exception' => new UnsupportedCaseFormatException(STDOUT, new \Exception('test')), 'expectedMessage' => 'Unsupported case in match or switch statement. case="n/a"'];
    }

    /**
     * @param \Throwable $exception
     * @param non-empty-string $expectedMessage
     * @return void
     * @dataProvider provideTestData
     */
    public function testExceptions(\Throwable $exception, string $expectedMessage): void
    {
        self::assertSame($expectedMessage, $exception->getMessage());
    }
}
