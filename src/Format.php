<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: Format.php
 * Project: Formatting
 * Modified at: 28/07/2025, 17:22
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting;

use Iomywiab\Library\Formatting\Enums\SizeUnitEnum;
use Iomywiab\Library\Formatting\Exceptions\FormatException;
use Iomywiab\Library\Formatting\Formatters\ImmutableDebugValueFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableListFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableListFormatterInterface;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatterInterface;
use Iomywiab\Library\Formatting\Helpers\SimpleDiContainer;
use Psr\Container\ContainerInterface;

/**
 * Class to format different types (mostly scalars) to pretty strings.
 * * Please note: This is not for conversion
 * * @see Convert
 */
class Format
{
    private static ?ContainerInterface $container = null;

    /**
     * @param ContainerInterface|null $container
     * @return void
     */
    public static function setDiContainer(?ContainerInterface $container): void
    {
        self::$container = $container;
    }

    /**
     * @param non-negative-int $bytes
     * @param SizeUnitEnum|null $unit
     * @return non-empty-string
     * @throws FormatException
     */
    public static function toHumanSize(int $bytes, null|SizeUnitEnum $unit = null): string
    {
        try {
            /** @var ImmutableValueFormatterInterface $formatter */
            $formatter = self::getDiContainer()->get(ImmutableValueFormatter::class);

            return $formatter->toHumanSize($bytes, $unit);
        } catch (\Throwable $cause) {
            throw new FormatException('Unable to format string', $cause);
        }
    }

    /**
     * @return ContainerInterface
     */
    public static function getDiContainer(): ContainerInterface
    {
        if (null === self::$container) {
            self::$container = new SimpleDiContainer();
            self::$container->set(ImmutableValueFormatter::class, new ImmutableValueFormatter());
            self::$container->set(ImmutableDebugValueFormatter::class, new ImmutableDebugValueFormatter());
            self::$container->set(ImmutableListFormatter::class, new ImmutableListFormatter());
            self::$container->setAlias(ImmutableValueFormatterInterface::class, ImmutableValueFormatter::class);
            self::$container->setAlias(ImmutableListFormatterInterface::class, ImmutableListFormatter::class);
        }

        return self::$container;
    }

    /**
     * @param class-string $className
     * @return string
     */
    public static function toShortClassName(string $className): string
    {
        try {
            return (new \ReflectionClass($className))->getShortName();
        } catch (\Throwable $cause) {
            return $cause->getMessage();
        }
    }

    /**
     * @param mixed $value
     * @return string
     */
    public static function tryToDebugString(mixed $value): string
    {
        try {
            return self::toDebugString($value);
        } catch (\Throwable) {
            return 'n/a';
        }
    }

    /**
     * @param mixed $value
     * @return string
     * @throws FormatException
     */
    public static function toDebugString(mixed $value): string
    {
        try {
            /** @var ImmutableValueFormatterInterface $formatter */
            $formatter = self::getDiContainer()->get(ImmutableDebugValueFormatter::class);

            return $formatter->toString($value);
        } catch (\Throwable $cause) {
            throw new FormatException('Unable to format string', $cause);
        }
    }

    /**
     * @param mixed $value
     * @return string
     * @throws FormatException
     */
    public static function toString(mixed $value): string
    {
        try {
            /** @var ImmutableValueFormatterInterface $formatter */
            $formatter = self::getDiContainer()->get(ImmutableValueFormatter::class);

            return $formatter->toString($value);
        } catch (\Throwable $cause) {
            throw new FormatException('Unable to format string', $cause);
        }
    }

    /**
     * @param mixed $value
     * @return string
     */
    public static function tryToString(mixed $value): string
    {
        try {
            return self::toString($value);
        } catch (\Throwable) {
            return 'n/a';
        }
    }

    /**
     * @param list<mixed> $list
     * @return string
     */
    public static function tryToValueList(array $list): string
    {
        try {
            return self::toValueList($list);
        } catch (\Throwable) {
            return 'n/a';
        }
    }

    /**
     * @param list<mixed> $list
     * @return string
     * @throws FormatException
     */
    public static function toValueList(array $list): string
    {
        try {
            /** @var ImmutableValueFormatterInterface $formatter */
            $formatter = self::getDiContainer()->get(ImmutableListFormatter::class);

            return $formatter->toString($list);
        } catch (\Throwable $cause) {
            throw new FormatException('Unable to format string', $cause);
        }
    }
}
