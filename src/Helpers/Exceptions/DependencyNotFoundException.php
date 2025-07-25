<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Helpers\Exceptions;

use Iomywiab\Library\Formatting\Message\Message;
use Psr\Container\NotFoundExceptionInterface;

class DependencyNotFoundException extends \RuntimeException implements NotFoundExceptionInterface
{
    /**
     * @param class-string $className
     * @param \Throwable|null $previous
     */
    public function __construct(string $className, ?\Throwable $previous = null)
    {
        $message = Message::error('Dependency exists', 'Not found/registered', $className, 'className');
        parent::__construct($message->toString(), 0, $previous);
    }
}
