<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: SimpleDiContainer.php
 * Project: Formatting
 * Modified at: 28/07/2025, 15:45
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Formatting\Helpers;

use Iomywiab\Library\Formatting\Helpers\Exceptions\DependencyNotFoundException;

class SimpleDiContainer implements SimpleDiContainerInterface
{
    /** @var array<non-empty-string,non-empty-string> $aliases */
    private array $aliases = [];
    /** @var array<non-empty-string,callable|object|string> $container */
    private array $container = [];

    /**
     * @inheritDoc
     */
    public function get(string $id): object
    {
        $object = $this->container[$id] ?? $this->container[$this->aliases[$id] ?? ''] ?? null;

        if (\is_string($object) || \is_callable($object)) {
            $object = \is_string($object) ? new $object() : $object();
            \assert('' !== $id);
            \assert(\is_object($object));
            $this->container[$id] = $object;
        }

        if (null === $object) {
            throw new DependencyNotFoundException($id);
        }

        return $object;
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        return isset($this->container[$id]) || isset($this->aliases[$id]);
    }

    /**
     * @inheritDoc
     */
    public function set(string $id, callable|object|string $concrete): void
    {
        // @phpstan-ignore voku.NotIdentical
        assert('' !== $id);
        $this->container[$id] = $concrete;
    }

    /**
     * @inheritDoc
     */
    public function setAlias(string $abstract, string $concrete): void
    {
        $this->aliases[$abstract] = $concrete;
    }
}
