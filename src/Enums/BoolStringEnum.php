<?php

/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: BoolStringEnum.php
 * Project: Formatting
 * Modified at: 27/07/2025, 20:30
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
     * @return non-empty-array<array-key,bool>
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
            // @phpstan-ignore voku.Match
            self::ACTIVATED,
                // @phpstan-ignore voku.Match
            self::ACTIVE,
                // @phpstan-ignore voku.Match
            self::ENABLED,
                // @phpstan-ignore voku.Match
            self::ON,
                // @phpstan-ignore voku.Match
            self::ONE,
                // @phpstan-ignore voku.Match
            self::TRUE,
                // @phpstan-ignore voku.Match
            self::Y,
                // @phpstan-ignore voku.Match
            self::YES => true,

            // @phpstan-ignore voku.Match
            self::DEACTIVATED,
                // @phpstan-ignore voku.Match
            self::DISABLED,
                // @phpstan-ignore voku.Match
            self::FALSE,
                // @phpstan-ignore voku.Match
            self::INACTIVE,
                // @phpstan-ignore voku.Match
            self::N,
                // @phpstan-ignore voku.Match
            self::NO,
                // @phpstan-ignore voku.Match
            self::OFF,
                // @phpstan-ignore voku.Match
            self::ZERO => false,
        };
    }
}
