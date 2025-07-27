<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: SimpleDiContainerTest.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Formatting\Unit\Helpers;

use Iomywiab\Library\Formatting\Enums\ExtendedDataTypeEnum;
use Iomywiab\Library\Formatting\Formatters\AbstractImmutableFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableArrayFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableDebugValueFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableListFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableObjectFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableStringFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Formatting\Helpers\Exceptions\DependencyNotFoundException;
use Iomywiab\Library\Formatting\Helpers\SimpleDiContainer;
use Iomywiab\Library\Formatting\Helpers\SimpleDiContainerInterface;
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

#[CoversClass(SimpleDiContainer::class)]
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
#[UsesClass(DependencyNotFoundException::class)]
class SimpleDiContainerTest extends TestCase
{
    public static function getTestObject(): object
    {
        return new \stdClass();
    }

    public static function provideTestData(): array
    {
        return [
            ['abc', null, new \stdClass()],
            ['abc', 'xyz', new \stdClass()],
            ['abc', null, \stdClass::class],
            ['abc', 'xyz', \stdClass::class],
            ['abc', null, [self::class, 'getTestObject']],
            ['abc', 'xyz', [self::class, 'getTestObject']],
        ];
    }

    /**
     * @param string $id
     * @param string|null $alias
     * @param callable|object|string $concrete
     * @return void
     * @dataProvider provideTestData
     */
    public function testContainer(string $id, ?string $alias, callable|object|string $concrete): void
    {
        $container = new SimpleDiContainer();
        $container->set($id, $concrete);
        if (null !== $alias) {
            $container->setAlias($alias, $id);
        }
        $className = match (true) {
            \is_string($concrete) => $concrete,
            \is_object($concrete) => \get_class($concrete),
            \is_callable($concrete) => \get_class($concrete()),
        };
        $this->checkContainer($container, $id, $alias, $className);
    }

    /**
     * @param SimpleDiContainerInterface $container
     * @param string $id
     * @param string|null $alias
     * @param class-string|null $className
     * @return void
     */
    private function checkContainer(SimpleDiContainerInterface $container, string $id, ?string $alias, ?string $className)
    {
        if (null === $className) {
            self::assertFalse($container->has($id));
            self::assertFalse($container->has($alias ?? 'invalidKey'));
            $this->expectException(DependencyNotFoundException::class);
            $container->get($id);

            return;
        }

        self::assertTrue($container->has($id));
        self::assertTrue(null === $alias || $container->has($alias ?? 'invalidKey'));

        $object = $container->get($id);
        self::assertSame($className, \get_class($object));

        if (null !== $alias) {
            $object = $container->get($alias);
            self::assertSame($className, \get_class($object));
        }

    }

    public function testNotFound(): void
    {
        $container = new SimpleDiContainer();
        $this->expectException(DependencyNotFoundException::class);
        $container->get('abc');
    }
}
