<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableTemplateReplacer.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacers;

use Iomywiab\Library\Formatting\Exceptions\FormatException;
use Iomywiab\Library\Formatting\Exceptions\FormatExceptionInterface;
use Iomywiab\Library\Formatting\Replacements\ImmutableReplacementInterface;
use Iomywiab\Library\Formatting\Replacements\Replacements;

class ImmutableTemplateReplacer implements ImmutableReplacerInterface
{
    private const END_CHAR = '}';
    private const START_CHAR = '{';

    /** @var list<ImmutableReplacementInterface|string> $parts */
    // @phpstan-ignore property.uninitializedReadonly
    private readonly array $parts;

    /**
     * @param non-empty-string $template
     * @param array<array-key,ImmutableReplacementInterface>|null $replacements
     * @throws FormatExceptionInterface
     */
    public function __construct(private readonly string $template, ?array $replacements = null)
    {
        // @phpstan-ignore voku.Identical
        if ('' === $this->template) {
            // @phpstan-ignore shipmonk.returnInConstructor
            return;
        }

        if (null === $replacements) {
            $replacements = Replacements::get();
        } else {
            $array = [];
            foreach ($replacements as $replacement) {
                \assert($replacement instanceof ImmutableReplacementInterface);
                $array[$replacement->getKey()] = $replacement;
            }
            $replacements = $array;
        }

        $length = \mb_strlen($template);
        $parts = [];
        $start = null;
        $end = -1;
        $next = self::START_CHAR;
        for ($i = 0; $i < $length; $i++) {
            $char = \mb_substr($template, $i, 1);
            if ($next !== $char) {
                continue;
            }
            if (self::START_CHAR === $next) {
                $start = $i;
                $next = self::END_CHAR;
                if (0 === $start) {
                    continue;
                }
                $parts[] = \mb_substr($template, $end + 1, $start - $end - 1);
                continue;
            }
            // @phpstan-ignore function.alreadyNarrowedType, identical.alwaysTrue
            \assert(self::END_CHAR === $next);
            \assert(\is_int($start) && ($start > $end));
            $end = $i;
            $key = \mb_substr($template, $start + 1, $end - $start - 1);
            $repl = $replacements[$key] ?? null;
            if (null === $repl) {
                throw new FormatException('Replacement not found for key='.$key);
            }
            $parts[] = $repl;
            $next = self::START_CHAR;
        }
        if ($end !== $length - 1) {
            $parts[] = \mb_substr($template, $end + 1);
        }
        $this->parts = $parts;
    }

    /**
     * @inheritDoc
     */
    public function toString(mixed $value): string
    {
        $string = '';
        foreach ($this->parts as $part) {
            $string .= \is_string($part) ? $part : $part->toString($value);
        }

        return $string;
    }
}
