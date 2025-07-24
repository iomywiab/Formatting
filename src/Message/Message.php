<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Message;

use Iomywiab\Library\Formatting\Formatters\ImmutableDebugValueFormatter;
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
    public static function make(string $message, array $values): self
    {
        return (new self($message))->addManyValues($values);
    }

    /**
     * @inheritDoc
     */
    public static function error(string $message, string $expected, mixed $value, array|string $errors, null|array $additions = null): self
    {
        $msg = (new self($message))
            ->addValue('expected', $expected)
            ->addValue('value', $value, true)
            ->addValue('errorCount', \is_string($errors) ? 1 : \count($errors))
            ->addValue(\is_string($errors) ? 'error' : 'errors', $errors);

        if (null !== $additions) {
            $msg->addManyValues($additions);
        }

        return $msg;
    }

    /**
     * @inheritDoc
     */
    public function addPart(ImmutableMessagePartInterface $part): self
    {
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
     * @inheritDoc
     */
    public function addValue(string $name, mixed $value, bool|null|ImmutableValueFormatterInterface $forDebug = null): self
    {
        $formatter = match(true) {
            true === $forDebug => new ImmutableDebugValueFormatter(),
            false === $forDebug => null,
            default => $forDebug,
        };
        return $this->addPart(new ImmutableMessagePartValue($name, $value, $formatter));
    }

    /**
     * @inheritDoc
     */
    public function addManyValues(array $values): self
    {
        if ([] === $values) {
            return $this;
        }

        foreach ($values as $name => $value) {
            $this->addValue($name, $value);
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
