<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableResourceFormatter.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

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
