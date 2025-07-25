<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: UnknownSerializeMarkerFormatException.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Exceptions;

class UnknownSerializeMarkerFormatException extends \Exception implements FormatExceptionInterface
{
    /**
     * @param non-empty-string $serializeMarker
     * @param \Throwable|null $previous
     */
    public function __construct(string $serializeMarker, null|\Throwable $previous = null)
    {
        parent::__construct('Unknown serialize marker. value="'.$serializeMarker.'"', 0, $previous);
    }
}
