<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Message;

use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatterInterface;

/**
 * Class to format a message
 */
interface MessageInterface extends \Stringable
{
    /**
     * @param non-empty-string $message
     * @param array<non-empty-string,mixed> $values
     */
    public static function make(string $message, array $values): self;

    /**
     * @param non-empty-string $message
     * @param string $expected
     * @param mixed $value
     * @param array|string $errors
     * @param array|null $additions
     * @return self
     */
    public static function error(string $message, string $expected, mixed $value, array|string $errors, null|array $additions = null): self;

    /**
     * @param ImmutableMessagePartInterface $part
     * @return self
     */
    public function addPart(ImmutableMessagePartInterface $part): self;

    /**
     * @param string|null $string
     * @return self
     */
    public function addString(null|string $string): self;

    /**
     * @param non-empty-string $name
     * @param mixed $value
     * @param bool|ImmutableValueFormatterInterface|null $forDebug
     * @return self
     */
    public function addValue(string $name, mixed $value, bool|null|ImmutableValueFormatterInterface $forDebug = null): self;

    /**
     * @param array<non-empty-string,mixed> $values
     * @return self
     */
    public function addManyValues(array $values): self;

    /**
     * @return string
     */
    public function toString(): string;

    /**
     * @inheritDoc
     */
    public function __toString(): string;
}
