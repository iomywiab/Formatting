<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: DependencyNotFoundException.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Helpers\Exceptions;

use Iomywiab\Library\Formatting\Message\Message;
use Psr\Container\NotFoundExceptionInterface;

class DependencyNotFoundException extends \RuntimeException implements NotFoundExceptionInterface
{
    /**
     * @param string $className
     * @param \Throwable|null $previous
     */
    public function __construct(string $className, ?\Throwable $previous = null)
    {
        $message = Message::error('Dependency exists', 'Dependency not found/registered', $className, 'className');
        parent::__construct($message->toString(), 0, $previous);
    }
}
