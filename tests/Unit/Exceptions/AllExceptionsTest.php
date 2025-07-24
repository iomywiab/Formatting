<?php

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Exceptions;

use Iomywiab\Library\Formatting\Exceptions\FormatException;
use Iomywiab\Library\Formatting\Exceptions\MessageFormatException;
use Iomywiab\Library\Formatting\Exceptions\UnknownSerializeMarkerFormatException;
use Iomywiab\Library\Formatting\Exceptions\UnsupportedCaseFormatException;
use Iomywiab\Library\Testing\DataTypes\Stringable4Testing;
use PHPUnit\Framework\TestCase;

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
            self::assertSame($expectedText, $exception->getMessage());
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
        ];
    }
}
