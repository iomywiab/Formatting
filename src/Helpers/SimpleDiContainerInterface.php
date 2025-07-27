<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: SimpleDiContainerInterface.php
 * Project: Formatting
 * Modified at: 28/07/2025, 00:39
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Helpers;

use Psr\Container\ContainerInterface;

interface SimpleDiContainerInterface extends ContainerInterface
{
    /**
     * @param string $id
     * @return object
     */
    public function get(string $id): object;

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool;

    /**
     * @param class-string $id
     * @param callable|object|string $concrete
     * @return void
     */
    public function set(string $id, callable|object|string $concrete): void;

    /**
     * @param class-string $abstract
     * @param class-string $concrete
     * @return void
     */
    public function setAlias(string $abstract, string $concrete): void;
}
