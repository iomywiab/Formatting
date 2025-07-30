<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: MessageTest.php
 * Project: Formatting
 * Modified at: 30/07/2025, 13:43
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Message;

use Iomywiab\Library\Formatting\Enums\ExtendedDataTypeEnum;
use Iomywiab\Library\Formatting\Formatters\AbstractImmutableFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableArrayFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableDebugValueFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableFloatFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableIntegerFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableListFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableObjectFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableStringFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
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

#[CoversClass(Message::class)]
#[UsesClass(AbstractImmutableFormatter::class)]
#[UsesClass(ImmutableArrayFormatter::class)]
#[UsesClass(ImmutableIntegerFormatter::class)]
#[UsesClass(ImmutableObjectFormatter::class)]
#[UsesClass(ImmutableStringFormatter::class)]
#[UsesClass(ImmutableValueFormatter::class)]
#[UsesClass(ImmutableMessagePartString::class)]
#[UsesClass(ImmutableMessagePartValue::class)]
#[UsesClass(ExtendedDataTypeEnum::class)]
#[UsesClass(ImmutableDebugValueFormatter::class)]
#[UsesClass(ImmutableListFormatter::class)]
#[UsesClass(AbstractImmutableReplacement::class)]
#[UsesClass(ImmutableExtendedTypeReplacement::class)]
#[UsesClass(ImmutableStringLengthReplacement::class)]
#[UsesClass(ImmutableValueReplacement::class)]
#[UsesClass(Replacements::class)]
#[UsesClass(ImmutableTemplateReplacer::class)]
#[UsesClass(ImmutableFloatFormatter::class)]
class MessageTest extends TestCase
{
    /**
     * @return \Generator<array{message: null|string, addStrings: null|non-empty-list<null|string>, addValues: null|non-empty-array<non-empty-string,mixed>, expectedString: string}>
     */
    public static function provideTestData(): \Generator
    {
        yield ['message' => null, 'addStrings' => null, 'addValues' => null, 'expectedString' => ''];
        yield ['message' => '', 'addStrings' => null, 'addValues' => null, 'expectedString' => ''];
        yield ['message' => 'message', 'addStrings' => null, 'addValues' => null, 'expectedString' => 'message.'];
        yield ['message' => 'message', 'addStrings' => ['msg'], 'addValues' => null, 'expectedString' => 'message. msg.'];
        yield ['message' => 'message', 'addStrings' => [''], 'addValues' => null, 'expectedString' => 'message.'];
        yield ['message' => 'message', 'addStrings' => [null], 'addValues' => null, 'expectedString' => 'message.'];
        yield ['message' => 'message', 'addStrings' => null, 'addValues' => ['name' => 1], 'expectedString' => 'message. name=1'];
        yield ['message' => 'message', 'addStrings' => null, 'addValues' => ['name1' => 1, 'name2' => 2], 'expectedString' => 'message. name1=1 name2=2'];
    }

    public static function testInvalidValue(): void
    {
        $message = Message::invalidValue('int>9', 'abc', 'title', ['add' => 'red']);
        self::assertSame('Found error. error="Invalid title" expected="int>9" got=non-empty-string(3):"abc" name="title" add="red"', $message->toString());
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

    /**
     * @param string|null $message
     * @param array<array-key,string>|null $addStrings
     * @param array<non-empty-string,mixed>|null $addValues
     * @param string $expectedString
     * @return void
     * @dataProvider provideTestData
     */
    public function testMessage(?string $message, ?array $addStrings, ?array $addValues, string $expectedString): void
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

    public function testMessageStringable(): void
    {
        $message = Message::make('my message', []);
        self::assertSame('my message.', (string)$message);

    }

    public function testUnsupportedValue(): void
    {
        $message = Message::unsupportedValue(['a', 'b'], 'c', 'title', ['add' => 'red']);
        self::assertSame('Found error. error="Unsupported title" expected="a"|"b" got=non-empty-string(1):"c" name="title" add="red"', $message->toString());
    }
}
