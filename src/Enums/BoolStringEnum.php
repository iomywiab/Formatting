<?php

/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: BoolStringEnum.php
 * Project: Formatting
 * Modified at: 25/07/2025, 14:03
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Enums;

/**
 * BoolStringEnum
 * Attention! case values must be LOWERCASE (for performance reasons)
 */
enum BoolStringEnum: string
{
    case ACTIVATED = 'activated';
    case ACTIVE = 'active';
    case DEACTIVATED = 'deactivated';
    case DISABLED = 'disabled';
    case ENABLED = 'enabled';
    case FALSE = 'false';
    case INACTIVE = 'inactive';
    case N = 'n';
    case NO = 'no';
    case OFF = 'off';
    case ON = 'on';
    case ONE = '1';
    case TRUE = 'true';
    case Y = 'y';
    case YES = 'yes';
    case ZERO = '0';

    /**
     * @param mixed $bool
     * @return self
     */
    public static function fromBool(mixed $bool): self
    {
        return (true === $bool)
            ? self::TRUE
            : self::FALSE;
    }

    /**
     * @return non-empty-array<non-empty-string,bool>
     */
    public static function toArray(): array
    {
        $array = [];

        foreach (self::cases() as $case) {
            $array[$case->value] = $case->toBool();
        }

        return $array;
    }

    /**
     * @return bool
     */
    public function toBool(): bool
    {
        return match ($this) {
            self::ACTIVATED,
            self::ACTIVE,
            self::ENABLED,
            self::ON,
            self::ONE,
            self::TRUE,
            self::Y,
            self::YES => true,

            self::DEACTIVATED,
            self::DISABLED,
            self::FALSE,
            self::INACTIVE,
            self::N,
            self::NO,
            self::OFF,
            self::ZERO => false,
        };
    }
}
