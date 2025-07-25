<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableArrayKeyTypeReplacement.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

use Iomywiab\Library\Converting\Enums\DataTypeEnum;

class ImmutableArrayKeyTypeReplacement extends AbstractImmutableReplacement
{
    public const KEY = 'array:key:type';

    /**
     * @param mixed $value
     * @return non-empty-string
     */
    protected function getTypeString(mixed $value): string
    {
        return DataTypeEnum::fromData($value)->toPhpDocName();
    }

    /**
     * @param mixed $value
     * @return non-empty-string
     */
    public function toString(mixed $value): string
    {
        if (!\is_array($value)) {
            return '';
        }

        try {
            $types = [];
            foreach ($value as $key => $ignore) {
                $type = $this->getTypeString($key);
                $types[$type] = true;
            }
            \ksort($types);

            return \implode('|', \array_keys($types));
        } catch (\Throwable $cause) {
            return $cause->getMessage();
        }
    }
}
