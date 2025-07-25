<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Message;

use Iomywiab\Library\Formatting\Enums\MessageValueFormatEnum;
use Iomywiab\Library\Formatting\Formatters\ImmutableDebugValueFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableListFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatter;
use Iomywiab\Library\Formatting\Formatters\ImmutableValueFormatterInterface;

/**
 * Class to format a message
 */
class Message implements MessageInterface
{
    /** @var list<ImmutableMessagePartInterface> */
    private array $parts = [];

    /**
     * @param string|null $message
     */
    public function __construct(null|string $message = null)
    {
        if (null === $message) {
            return;
        }

        $this->addString($message);
    }

    /**
     * @inheritDoc
     */
    public static function make(string $message, ?array $values = null): self
    {
        return (new self($message))->addManyValues($values);
    }

    /**
     * @inheritDoc
     */
    public static function error(array|string $expectation, array|string $errors, mixed $value, ?string $valueName, null|array $keyValues = null): self
    {
        if (\is_array($errors)) {
            $errorCount = \count($errors);
            if (1 === $errorCount) {
                $errors = $errors[\array_key_first($errors)];
            }
        }

        $title = \is_string($errors) ? 'Found error' : 'Found errors';
        $message = new self($title);

        if (\is_string($errors)) {
            $message->addValue('Error', $errors);
        } else {
            \assert(isset($errorCount) && (1 < $errorCount));
            $message->addValue('ErrorCount', $errorCount);
            $index = 0;
            foreach ($errors as $err) {
                $index++;
                $message->addValue('Error-'.$index, $err);
            }
        }

        if (\is_string($expectation)) {
            $expectation = [$expectation];
        }

        $message->addValue('Expected', $expectation, MessageValueFormatEnum::LIST);
        $message->addValue('Got', $value, MessageValueFormatEnum::DEBUG);

        if (null !== $valueName) {
            $message->addValue('Name', $valueName);
        }

        $message->addManyValues($keyValues);

        return $message;
    }

    /**
     * @inheritDoc
     */
    public static function invalidValue(
        array|string $expectation,
        mixed $value,
        ?string $valueName = null,
        ?array $keyValues = null
    ): static {
        return self::error($expectation, 'Invalid '.($valueName ?? 'value'), $value, $valueName, $keyValues);
    }

    /**
     * @inheritDoc
     */
    public static function unsupportedValue(
        array|string $expectation,
        mixed $value,
        ?string $valueName = null,
        ?array $keyValues = null
    ): static {
        return self::error($expectation, 'Unsupported '.($valueName ?? 'value'), $value, $valueName, $keyValues);
    }

    /**
     * @inheritDoc
     */
    public function addPart(?ImmutableMessagePartInterface $part): self
    {
        if (null === $part) {
            return $this;
        }

        $this->parts[] = $part;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addString(null|string $string): self
    {
        if (null === $string || '' === $string) {
            return $this;
        }

        return $this->addPart(new ImmutableMessagePartString($string));
    }

    /**
     * @param MessageValueFormatEnum|ImmutableValueFormatterInterface|null $format
     * @return ImmutableValueFormatterInterface
     */
    private function getFormatter(MessageValueFormatEnum|ImmutableValueFormatterInterface|null $format): ImmutableValueFormatterInterface
    {
        if (null === $format) {
            return new ImmutableValueFormatter();
        }

        if ($format instanceof ImmutableValueFormatterInterface) {
            return $format;
        }

        \assert($format instanceof MessageValueFormatEnum);

        return match ($format) {
            MessageValueFormatEnum::PLAIN => new ImmutableValueFormatter(),
            MessageValueFormatEnum::DEBUG => new ImmutableDebugValueFormatter(),
            MessageValueFormatEnum::LIST => new ImmutableValueFormatter(arrayFormatter: new ImmutableListFormatter()),
        };
    }

    /**
     * @inheritDoc
     */
    public function addValue(string $name, mixed $value, MessageValueFormatEnum|ImmutableValueFormatterInterface|null $format = null): self
    {
        $formatter = $this->getFormatter($format);

        return $this->addPart(new ImmutableMessagePartValue($name, $value, $formatter));
    }

    /**
     * @inheritDoc
     */
    public function addManyValues(?array $values, MessageValueFormatEnum|ImmutableValueFormatterInterface|null $format = null): self
    {
        if (null === $values || [] === $values) {
            return $this;
        }

        $formatter = $this->getFormatter($format);

        foreach ($values as $name => $value) {
            $this->addValue($name, $value, $formatter);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        if ([] === $this->parts) {
            return '';
        }

        $string = '';
        $spacer = '';
        foreach ($this->parts as $part) {
            $string .= $spacer.$part->toString();
            $spacer = ' ';
        }

        return $string;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
