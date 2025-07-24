<?php

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Formatting\Exceptions\FormatException;

class ImmutableResourceFormatter implements ImmutableResourceFormatterInterface
{
    /**
     * @inheritDoc
     */
    public function toString(mixed $value): string
    {
        if (!\is_resource($value)) {
            return '';
        }

        try {
            $id = PHP_VERSION_ID > 80000
                ? '(id:'.\get_resource_id($value).')'
                : '';

            return \get_resource_type($value).$id;
        } catch (\Throwable $cause) {
            throw new FormatException('Error formatting resource to string', $cause);
        }
    }
}
