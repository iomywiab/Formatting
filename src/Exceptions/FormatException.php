<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: FormatException.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

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
