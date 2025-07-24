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
    public function testMessage(mixed $message, ?array $addStrings, ?array $addValues,  string $expectedString): void
    {
        $msg = new Message($message);

        if (null !== $addStrings) {
            foreach ($addStrings as $string) {
                $msg->addString($string);
            }
        }

        if (null !== $addValues) {
            foreach ($addValues as $key=>$value) {
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
            ['message',['msg'], null, 'message. msg.'],
            ['message',[''], null, 'message.'],
            ['message',[null], null, 'message.'],
            ['message',null, ['name'=> 1], 'message. name=1'],
            ['message',null, ['name1'=> 1,'name2'=> 2], 'message. name1=1 name2=2'],
        ];
    }

    public function testError(): void
    {
        $message = Message::error('my message', 'int => 7', 3, 'int < 7');
        self::assertSame('my message. expected="int => 7" value=positive-int:3 errorCount=1 error="int < 7"', $message->toString());

        $message = Message::error('my message', 'int => 7', 3.1, ['int < 7', 'not of type int'], ['add1' => 3, 'add2' => 'abc']);
        self::assertSame(
            'my message. expected="int => 7" value=positive-float:3.1 errorCount=2 errors=[0=>"int < 7", 1=>"not of type int"] add1=3 add2="abc"',
            $message->toString()
        );
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
}
