<?php

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Examples;

use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;
use Iomywiab\Library\Formatting\Formatters\ImmutableDebugValueFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Formatting\Message\Message;
use Iomywiab\Library\Formatting\Replacers\ImmutableTemplateReplacer;
use Iomywiab\Library\Testing\DataTypes\Enum4Testing;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * @return void
     * @throws FormatExceptionInterface
     */
    public function testFormatters(): void
    {
        $formatter = new ImmutableValueFormatter();
        $debugFormatter = new ImmutableDebugValueFormatter();

        self::assertSame('"abc"', $formatter->toString('abc'));
        self::assertSame('non-empty-string(3):"abc"', $debugFormatter->toString('abc'));
        self::assertSame('["one"=>true, 2=>3.4]', $formatter->toString(['one' => true, 2 => 3.4]));
        self::assertSame('non-empty-array(2)<non-empty-string|positive-int,bool|positive-float>:["one"=>true, 2=>3.4]', $debugFormatter->toString(['one' => true, 2 => 3.4]));
    }

    public function testMessages(): void
    {
        $message = Message::make('msg');
        self::assertSame('msg.', $message->toString());

        $message = Message::make('msg', ['one'=>1, 'two'=>2]);
        self::assertSame('msg. one=1 two=2', $message->toString());

        $message = Message::error('int >= 7', 'int < 7', 3, 'age');
        self::assertSame('Found error. error="int < 7" expected="int >= 7" got=positive-int:3 name="age"', $message->toString());

        $message = Message::error('int => 7', ['int < 7', 'not of type int'], 3.4, 'age', ['add1' => 3, 'add2' => 'abc']);
        self::assertSame(
            'Found errors. errorCount=2 error-1="int < 7" error-2="not of type int" expected="int => 7" got=positive-float:3.4 name="age" add1=3 add2="abc"',
            $message->toString()
        );
        $message = (new Message('Hello'))
            ->addString('World')
            ->addValue('One', 1)
            ->addManyValues(['Two'=> 2, 'Three'=> 3]);
        self::assertSame('Hello. World. one=1 two=2 three=3', $message->toString());
    }

    public function testReplacers(): void
    {
        $replacer = new ImmutableTemplateReplacer('{type}, {type:extended}, {string:length}, {value}');
        self::assertSame('string, non-empty-string, 3, "abc"', $replacer->toString('abc'));

        $replacer = new ImmutableTemplateReplacer('{type}, {class:name}, {namespace}');
        self::assertSame('object, Enum4Testing, Iomywiab\Library\Testing\DataTypes', $replacer->toString(Enum4Testing::ONE));

        $replacer = new ImmutableTemplateReplacer('{type}, {array:size}, {array:key:type}, {array:value:type:extended}');
        self::assertSame('array, 2, int|string, bool|positive-float', $replacer->toString(['one'=>1.0, 2=>true]));
    }
}
