<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Exceptions;

class UnsupportedCaseFormatException extends \Exception implements FormatExceptionInterface
{
    /**
     * @param mixed $case
     * @param \Throwable|null $previous
     */
    public function __construct(mixed $case, null|\Throwable $previous = null)
    {
        $case = match (true) {
            \is_scalar($case) => (string)$case,
            \is_array($case) => 'Array',
            \is_object($case) => \get_class($case),
            default => 'n/a',
        };
        parent::__construct('Unsupported case in match or switch statement. case="'.$case.'"', 0, $previous);
    }
}
