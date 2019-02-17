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

namespace ScaleUpStack\Reflection;

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
    private $reflectionProperties = [];

    private $allPropertiesLoaded = false;

    /**
     * @var \ReflectionMethod[]
     */
    private $reflectionMethods = [];

    private $allMethodsLoaded = false;

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
        if (! array_key_exists($propertyName, $this->reflectionProperties)) {
            $this->reflectionProperties[$propertyName] = $this->reflectionClass->getProperty($propertyName);
        }

        return $this->reflectionProperties[$propertyName];
    }

    /**
     * @return \ReflectionProperty[]
     *         Contrary to `\ReflectionClass->getProperties()` the keys of the returned array are the property names
     *         instead of integers.
     */
    public function allReflectionProperties() : array
    {
        if (! $this->allPropertiesLoaded) {
            $allProperties = [];

            foreach ($this->reflectionClass->getProperties() as $reflectionProperty) {
                $propertyName = $reflectionProperty->getName();

                if (array_key_exists($propertyName, $this->reflectionProperties)) {
                    $reflectionProperty = $this->reflectionProperties[$propertyName];
                }

                $allProperties[$propertyName] = $reflectionProperty;
            }

            $this->reflectionProperties = $allProperties;
            $this->allPropertiesLoaded = true;
        }

        return $this->reflectionProperties;
    }

    public function reflectionMethod(string $methodName) : \ReflectionMethod
    {
        if (! array_key_exists($methodName, $this->reflectionMethods)) {
            $this->reflectionMethods[$methodName] = $this->reflectionClass->getMethod($methodName);
        }

        return $this->reflectionMethods[$methodName];
    }


    /**
     * @return \ReflectionMethod[]
     *         Contrary to `\ReflectionClass->getMethods()` the keys of the returned array are the method names
     *         instead of integers.
     */
    public function allReflectionMethods() : array
    {
        if (! $this->allMethodsLoaded) {
            $allMethods = [];

            foreach ($this->reflectionClass->getMethods() as $reflectionMethod) {
                $methodName = $reflectionMethod->getName();

                if (array_key_exists($methodName, $this->reflectionMethods)) {
                    $reflectionMethod = $this->reflectionMethods[$methodName];
                }

                $allMethods[$methodName] = $reflectionMethod;

            }

            $this->reflectionMethods = $allMethods;
            $this->allMethodsLoaded = true;
        }

        return $this->reflectionMethods;
    }
}
