<?php

/**
 * This file is part of ScaleUpStack/Reflection.
 *
 * For the full copyright and license information, please view the README.md and LICENSE.md files that were distributed
 * with this source code.
 *
 * @copyright 2019 - present ScaleUpVentures GmbH, https://www.scaleupventures.com
 * @link      https://github.com/scaleupstack/reflection
 */

namespace ScaleUpStack\Reflection\Cache;

/**
 * @internal
 */
class ClassCache
{
    private $className;

    private $reflectionClass;

    /**
     * @var \ReflectionProperty[]
     */
    private $properties = [];

    private $allPropertiesLoaded = false;

    public function __construct(string $className)
    {
        $this->className = $className;
        $this->reflectionClass = new \ReflectionClass($className);
    }

    public function reflectionClass() : \ReflectionClass
    {
        return $this->reflectionClass;
    }

    public function reflectionProperty(string $propertyName) : \ReflectionProperty
    {
        if (! array_key_exists($propertyName, $this->properties)) {
            $this->properties[$propertyName] = $this->reflectionClass->getProperty($propertyName);
        }

        return $this->properties[$propertyName];
    }

    /**
     * @return \ReflectionProperty[]
     */
    public function allReflectionProperties() : array
    {
        if (! $this->allPropertiesLoaded) {
            $allProperties = [];

            foreach ($this->reflectionClass->getProperties() as $reflectionProperty) {
                $propertyName = $reflectionProperty->getName();

                if (array_key_exists($propertyName, $this->properties)) {
                    $reflectionProperty = $this->properties[$propertyName];
                }

                $allProperties[$propertyName] = $reflectionProperty;
            }

            $this->properties = $allProperties;
            $this->allPropertiesLoaded = true;
        }

        return $this->properties;
    }
}
