<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: SizeUnitEnum.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Enums;

enum SizeUnitEnum: string
{
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
