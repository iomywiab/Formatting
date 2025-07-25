<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: SimpleDiContainer.php
 * Project: Formatting
 * Modified at: 25/07/2025, 13:59
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Helpers;

use Iomywiab\Library\Formatting\Helpers\Exceptions\DependencyNotFoundException;
use Psr\Container\ContainerInterface;

class SimpleDiContainer implements ContainerInterface
{
    /** @var array<non-empty-string,non-empty-string> $aliases */
    private array $aliases = [];
    /** @var array<non-empty-string,object> $container */
    private array $container = [];

    /**
     * @param class-string $id
     * @return object
     */
    public function get(string $id): object
    {
        if (isset($this->container[$id])) {

            $object = $this->container[$id];
            if (\is_string($object)) {
                $object = new $object();
                $this->container[$id] = $object;
            }

            return $object;
        }

        if (isset($this->aliases[$id])) {
            return $this->container[$this->aliases[$id]];
        }

        throw new DependencyNotFoundException($id);
    }

    /**
     * @param class-string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->container[$id]) || isset($this->aliases[$id]);
    }

    /**
     * @param class-string $id
     * @param callable|object|string $concrete
     * @return void
     */
    public function set(string $id, callable|object|string $concrete): void
    {
        assert('' !== $id);
        $this->container[$id] = $concrete;
    }

    /**
     * @param class-string $abstract
     * @param class-string $concrete
     * @return void
     */
    public function setAlias(string $abstract, string $concrete): void
    {
        $this->aliases[$abstract] = $concrete;
    }
}
