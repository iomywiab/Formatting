<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: MessageValueFormatEnum.php
 * Project: Formatting
 * Modified at: 28/07/2025, 17:15
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Enums;

use Iomywiab\Library\Enums\Traits\ExtendedEnumInterface;
use Iomywiab\Library\Enums\Traits\ExtendedEnumTrait;

enum MessageValueFormatEnum implements ExtendedEnumInterface
{
    use ExtendedEnumTrait;

    case PLAIN;
    case DEBUG;
    case LIST;
}
