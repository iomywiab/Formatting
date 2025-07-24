<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Formatting\Replacers\ImmutableReplacerInterface;

class AbstractImmutableFormatter
{
    /**
     * @param ImmutableReplacerInterface|null $replacer
     */
    public function __construct(protected readonly ?ImmutableReplacerInterface $replacer = null)
    {
        // no code
    }
}
