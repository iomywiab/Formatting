<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Formatting\Replacers\ImmutableReplacerInterface;

class ImmutableArrayFormatter extends AbstractImmutableFormatter implements ImmutableArrayFormatterInterface
{
    private readonly ImmutableValueFormatterInterface $keyFormatter;
    private readonly ImmutableValueFormatterInterface $valueFormatter;

    /**
     * @param ImmutableReplacerInterface|null $replacer
     * @param ImmutableValueFormatterInterface|null $keyFormatter
     * @param ImmutableValueFormatterInterface|null $valueFormatter
     */
    public function __construct(?ImmutableValueFormatterInterface $keyFormatter = null, ?ImmutableValueFormatterInterface $valueFormatter = null, ?ImmutableReplacerInterface $replacer = null)
    {
        parent::__construct($replacer);

        $this->keyFormatter = $keyFormatter ?? new ImmutableValueFormatter();
        $this->valueFormatter = $valueFormatter ?? new ImmutableValueFormatter();
    }

    /**
     * @inheritDoc
     */
    public function toString(array $array): string
    {
        if (null === $this->replacer) {
            $string = '[';
            $separator = '';
            foreach ($array as $key => $value) {
                $string .= $separator.$this->keyFormatter->toString($key).'=>'.$this->valueFormatter->toString($value);
                $separator = ', ';
            }
            return $string . ']';
        }

        return $this->replacer->toString($array);
    }
}
