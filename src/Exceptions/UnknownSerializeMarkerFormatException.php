<?php

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
