<?php

namespace Hhxsv5\LaravelS\Swoole\Proxy;

/**
 * DynamicPropertiesTrait solves the issue that PHP 8.2+ does not allow dynamic property creation.
 * Provides functionality for storing and accessing dynamic properties.
 */
trait DynamicPropertiesTrait
{
    /** @var array Stores dynamically created properties (e.g., tables) */
    protected array $dynamicProperties = [];

    /**
     * Dynamic property access
     */
    public function __get($name)
    {
        // First check dynamic properties
        return $this->dynamicProperties[$name] ?? null;
    }

    /**
     * Dynamic property setter
     */
    public function __set($name, $value)
    {
        // If property name ends with 'Table', store it in dynamic properties
        if (str_ends_with($name, 'Table')) {
            $this->dynamicProperties[$name] = $value;
            return;
        }

        // For other properties, try to set directly on parent class
        // (Swoole's C extension classes don't have __set, so it won't recurse)
        try {
            $this->{$name} = $value;
        } catch (\Error $e) {
            // When PHP 8.2+ doesn't allow dynamic property creation, store in dynamic properties
            $this->dynamicProperties[$name] = $value;
        }
    }

    /**
     * Check if property exists
     */
    public function __isset($name)
    {
        if (array_key_exists($name, $this->dynamicProperties)) {
            return true;
        }

        // Check parent class properties (Swoole's C extension class properties)
        return property_exists($this, $name);
    }

    /**
     * Unset property
     */
    public function __unset($name)
    {
        unset($this->dynamicProperties[$name]);

        if (property_exists($this, $name)) {
            unset($this->{$name});
        }
    }
}

