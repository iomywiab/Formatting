<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: SizeUnitEnum.php
 * Project: Formatting
 * Modified at: 28/07/2025, 17:15
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Enums;

use Iomywiab\Library\Enums\Traits\ExtendedBackedEnumInterface;
use Iomywiab\Library\Enums\Traits\ExtendedBackedEnumTrait;

enum SizeUnitEnum: string implements ExtendedBackedEnumInterface
{
    use ExtendedBackedEnumTrait;

    case QB = 'QB';
    case RB = 'RB';
    case YB = 'YB';
    case ZB = 'ZB';
    case EB = 'EB';
    case PB = 'PB';
    case TB = 'TB';
    case GB = 'GB';
    case MB = 'MB';
    case KB = 'KB';
    case B = 'bytes';
}
