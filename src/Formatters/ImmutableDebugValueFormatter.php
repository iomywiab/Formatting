<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableDebugValueFormatter.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Formatters;

use Iomywiab\Library\Converting\Convert;
use Iomywiab\Library\Formatting\Replacers\ImmutableTemplateReplacer;

/**
 * Class to format different types (mostly scalars) to pretty strings.
 * * Please note: This is not for conversion
 * * @see Convert
 */
class ImmutableDebugValueFormatter extends ImmutableValueFormatter
{
    private const ARRAY_TEMPLATE = '{type:extended}({array:size})<{array:key:type:extended},{array:value:type:extended}>:{value}';
    private const BOOLEAN_TEMPLATE = '{type}:{value}';
    private const FLOAT_TEMPLATE = '{type:extended}:{value}';
    private const INT_TEMPLATE = '{type:extended}:{value}';
    private const OBJECT_TEMPLATE = '{type:extended}<{class:name}>:{value}';
    private const STRING_TEMPLATE = '{type:extended}({string:length}):{value}';

    /**
     * @param ImmutableArrayFormatterInterface|null $arrayFormatter
     * @param ImmutableObjectFormatterInterface|null $objectFormatter
     * @param ImmutableResourceFormatterInterface|null $resourceFormatter
     * @param ImmutableNullFormatterInterface|null $nullFormatter
     * @param ImmutableStringFormatterInterface|null $stringFormatter
     * @param ImmutableBooleanFormatterInterface|null $booleanFormatter
     * @param ImmutableFloatFormatterInterface|null $floatFormatter
     * @param ImmutableIntegerFormatterInterface|null $integerFormatter
     */
    public function __construct(
        ?ImmutableArrayFormatterInterface $arrayFormatter = null,
        ?ImmutableObjectFormatterInterface $objectFormatter = null,
        ?ImmutableResourceFormatterInterface $resourceFormatter = null,
        ?ImmutableNullFormatterInterface $nullFormatter = null,
        ?ImmutableStringFormatterInterface $stringFormatter = null,
        ?ImmutableBooleanFormatterInterface $booleanFormatter = null,
        ?ImmutableFloatFormatterInterface $floatFormatter = null,
        ?ImmutableIntegerFormatterInterface $integerFormatter = null,
    ) {
        // @phpstan-ignore voku.Coalesce
        $stringFormatter ??= new ImmutableStringFormatter(new ImmutableTemplateReplacer(self::STRING_TEMPLATE));
        // @phpstan-ignore voku.Coalesce
        $integerFormatter ??= new ImmutableIntegerFormatter(new ImmutableTemplateReplacer(self::INT_TEMPLATE));
        parent::__construct(
            $arrayFormatter ?? new ImmutableArrayFormatter($this, $this, new ImmutableTemplateReplacer(self::ARRAY_TEMPLATE)),
            $objectFormatter ?? new ImmutableObjectFormatter($stringFormatter, $integerFormatter, new ImmutableTemplateReplacer(self::OBJECT_TEMPLATE)),
            $resourceFormatter ?? new ImmutableResourceFormatter(),
            $nullFormatter ?? new ImmutableNullFormatter(),
            $stringFormatter,
            $booleanFormatter ?? new ImmutableBooleanFormatter(new ImmutableTemplateReplacer(self::BOOLEAN_TEMPLATE)),
            $floatFormatter ?? new ImmutableFloatFormatter(new ImmutableTemplateReplacer(self::FLOAT_TEMPLATE)),
            $integerFormatter
        );
    }
}
