<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableArrayValueTypeReplacement.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Replacements;

use Iomywiab\Library\Converting\Enums\DataTypeEnum;

class ImmutableArrayValueTypeReplacement extends AbstractImmutableReplacement
{
    public const KEY = 'array:value:type';

    /**
     * @param mixed $value
     * @return string
     */
    public function toString(mixed $value): string
    {
        if (!\is_array($value)) {
            return '';
        }

        try {
            $types = [];
            foreach ($value as $item) {
                $type = $this->getTypeString($item);
                if (null !== $type) {
                    $types[$type] = true;
                }
            }
            \ksort($types);

            return \implode('|', \array_keys($types));
        } catch (\Throwable $cause) {
            return $cause->getMessage();
        }
    }

    /**
     * @param mixed $value
     * @return non-empty-string|null
     */
    protected function getTypeString(mixed $value): ?string
    {
        return DataTypeEnum::fromData($value)->toPhpDocName();
    }
}
