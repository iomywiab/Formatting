<?php

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit;

use Iomywiab\Library\Formatting\Message\Message;
use PHPUnit\Framework\TestCase;

/**
 * Class to format a message
 */
class MessageTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testMessage(mixed $message, ?array $addStrings, ?array $addValues, string $expectedString): void
    {
        $msg = new Message($message);

        if (null !== $addStrings) {
            foreach ($addStrings as $string) {
                $msg->addString($string);
            }
        }

        if (null !== $addValues) {
            foreach ($addValues as $key => $value) {
                $msg->addValue($key, $value);
            }
        }

        self::assertSame($expectedString, $msg->toString());

        $msg = new Message($message);

        if (null !== $addStrings) {
            foreach ($addStrings as $string) {
                $msg->addString($string);
            }
        }

        if (null !== $addValues) {
            $msg->addManyValues($addValues);
        }

        self::assertSame($expectedString, $msg->toString());
    }

    /**
     * @return non-empty-list<non-empty-list<mixed>>
     */
    public static function provideTestData(): array
    {
        return [
            [null, null, null, ''],
            ['', null, null, ''],
            ['message', null, null, 'message.'],
            ['message', ['msg'], null, 'message. msg.'],
            ['message', [''], null, 'message.'],
            ['message', [null], null, 'message.'],
            ['message', null, ['name' => 1], 'message. name=1'],
            ['message', null, ['name1' => 1, 'name2' => 2], 'message. name1=1 name2=2'],
        ];
    }

    public function testError(): void
    {
        $message = Message::error('int >= 7', 'int < 7', 3, 'age');
        self::assertSame('Found error. error="int < 7" expected="int >= 7" got=positive-int:3 name="age"', $message->toString());

        $message = Message::error('int => 7', ['int < 7', 'not of type int'], 3.4, 'age', ['add1' => 3, 'add2' => 'abc']);
        self::assertSame(
            'Found errors. errorCount=2 error-1="int < 7" error-2="not of type int" expected="int => 7" got=positive-float:3.4 name="age" add1=3 add2="abc"',
            $message->toString()
        );

        $message = Message::error('expectation', 'error', 'value', 'valueName');
        self::assertSame('Found error. error="error" expected="expectation" got=non-empty-string(5):"value" name="valueName"', $message->toString());

        $message = Message::error(['a', 'b'], ['green'], 1, 'valueName', ['additionalValue' => 'blue']);
        self::assertSame('Found error. error="green" expected="a"|"b" got=positive-int:1 name="valueName" additionalValue="blue"', $message->toString());

        $message = Message::error(['a', 'b'], ['green', 'red'], 1, 'valueName', ['additionalValue1' => 'blue', 'additionalValue2' => 'yellow']);
        self::assertSame('Found errors. errorCount=2 error-1="green" error-2="red" expected="a"|"b" got=positive-int:1 name="valueName" additionalValue1="blue" additionalValue2="yellow"', $message->toString());

    }

    public function testMake(): void
    {
        $message = Message::make('my message', []);
        self::assertSame('my message.', $message->toString());

        $message = Message::make('my message', ['a' => 1]);
        self::assertSame('my message. a=1', $message->toString());

        $message = Message::make('my message', ['a' => 1, 'b' => 'abc']);
        self::assertSame('my message. a=1 b="abc"', $message->toString());
    }

    public function testMessageStringable(): void
    {
        $message = Message::make('my message', []);
        self::assertSame('my message.', (string)$message);

    }

    public static function testInvalidValue(): void
    {
        $message = Message::invalidValue('int>9', 'abc', 'title', ['add' => 'red']);
        self::assertSame('Found error. error="Invalid title" expected="int>9" got=non-empty-string(3):"abc" name="title" add="red"', $message->toString());
    }

    public function testUnsupportedValue(): void
    {
        $message = Message::unsupportedValue(['a', 'b'], 'c', 'title', ['add' => 'red']);
        self::assertSame('Found error. error="Unsupported title" expected="a"|"b" got=non-empty-string(1):"c" name="title" add="red"', $message->toString());
    }

}
