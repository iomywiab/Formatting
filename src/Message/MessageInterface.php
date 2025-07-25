<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Message;

use Iomywiab\Library\Formatting\Enums\MessageValueFormatEnum;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatterInterface;

/**
 * Class to format a message
 */
interface MessageInterface extends \Stringable
{
    /**
     * @param non-empty-string $message
     * @param array<non-empty-string,mixed>|null $values
     */
    public static function make(string $message, ?array $values = null): self;

    /**
     * @param non-empty-array<array-key,mixed>|non-empty-string $expectation
     * @param non-empty-array<array-key,non-empty-string>|non-empty-string $errors
     * @param mixed $value
     * @param non-empty-string|null $valueName
     * @param array<array-key,mixed>|null $keyValues
     * @return self
     */
    public static function error(array|string $expectation, array|string $errors, mixed $value, ?string $valueName, null|array $keyValues = null): self;

    /**
     * @param non-empty-array<array-key,mixed>|non-empty-string $expectation
     * @param mixed $value
     * @param non-empty-string|null $valueName
     * @param array<array-key,mixed> $keyValues
     * @return static
     */
    public static function invalidValue(
        array|string $expectation,
        mixed $value,
        ?string $valueName = null,
        ?array $keyValues = null
    ): static;

    /**
     * @param non-empty-array<array-key,mixed>|non-empty-string $expectation
     * @param mixed $value
     * @param non-empty-string|null $valueName
     * @param array<array-key,mixed> $keyValues
     * @return static
     */
    public static function unsupportedValue(
        array|string $expectation,
        mixed $value,
        ?string $valueName = null,
        ?array $keyValues = null
    ): static;

    /**
     * @param ImmutableMessagePartInterface|null $part
     * @return self
     */
    public function addPart(?ImmutableMessagePartInterface $part): self;

    /**
     * @param string|null $string
     * @return self
     */
    public function addString(null|string $string): self;

    /**
     * @param non-empty-string $name
     * @param mixed $value
     * @param MessageValueFormatEnum|ImmutableValueFormatterInterface|null $format
     * @return self
     */
    public function addValue(string $name, mixed $value, MessageValueFormatEnum|ImmutableValueFormatterInterface|null $format = null): self;

    /**
     * @param array<non-empty-string,mixed>|null $values
     * @param MessageValueFormatEnum|ImmutableValueFormatterInterface|null $format
     * @return self
     */
    public function addManyValues(?array $values, MessageValueFormatEnum|ImmutableValueFormatterInterface|null $format = null): self;

    /**
     * @return string
     */
    public function toString(): string;

    /**
     * @inheritDoc
     */
    public function __toString(): string;
}
