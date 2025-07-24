<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Exceptions;

class FormatException extends \Exception implements FormatExceptionInterface
{
    /**
     * @param non-empty-string $message
     * @param \Throwable|null $previous
     */
    public function __construct(string $message, null|\Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
