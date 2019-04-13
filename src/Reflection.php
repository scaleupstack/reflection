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
 * @method static \ReflectionClass classByObject(object $object)
 * @method static \ReflectionProperty propertyOfObject(object $object, string $propertyName)
 * @method static \ReflectionProperty[] allPropertiesOfObject(object $object)
 * @method static \ReflectionMethod methodOfObject(object $object, string $methodName)
 * @method static \ReflectionMethod[] allMethodsOfObject(object $object)
 */
class Reflection
{
    /**
     * @var ClassCache[]
     */
    private static $classCaches = [];

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    public static function classByName(string $className) : \ReflectionClass
    {
        return self::classCache($className)->reflectionClass();
    }

    public static function propertyOfClass(string $className, string $propertyName) : \ReflectionProperty
    {
        return self::classCache($className)->reflectionProperty($propertyName);
    }

    /**
     * @return \ReflectionProperty[]
     *         Contrary to `\ReflectionClass->getProperties()` the keys of the returned array are the property names
     *         instead of integers.
     */
    public static function allPropertiesOfClass(string $className) : array
    {
        return self::classCache($className)->allReflectionProperties();
    }

    public static function methodOfClass(string $className, string $methodName) : \ReflectionMethod
    {
        return self::classCache($className)->reflectionMethod($methodName);
    }

    /**
     * @return \ReflectionMethod[]
     *         Contrary to `\ReflectionClass->getMethods()` the keys of the returned array are the method names
     *         instead of integers.
     */
    public static function allMethodsOfClass(string $className) : array
    {
        return self::classCache($className)->allReflectionMethods();
    }

    /**
     * @return mixed
     */
    public static function getPropertyValue(object $object, string $propertyName)
    {
        return self::classCache(get_class($object))
            ->reflectionProperty($propertyName)
            ->getValue($object);
    }

    /**
     * @param mixed $value
     * @return void
     */
    public static function setPropertyValue(object $object, string $propertyName, $value)
    {
        self::classCache(get_class($object))
            ->reflectionProperty($propertyName)
            ->setValue($object, $value);
    }

    /**
     * @return mixed
     */
    public static function getStaticPropertyValue(string $className, string $propertyName)
    {
        return self::classCache($className)
            ->reflectionProperty($propertyName)
            ->getValue();
    }

    /**
     * @param mixed $value
     * @return void
     */
    public static function setStaticPropertyValue(string $className, string $propertyName, $value)
    {
        self::classCache($className)
            ->reflectionProperty($propertyName)
            ->setValue($value);
    }

    /**
     * @return mixed
     */
    public static function invokeMethod(object $object, string $methodName, array $arguments)
    {
        return self::classCache(get_class($object))
            ->reflectionMethod($methodName)
            ->invoke($object, ... $arguments);
    }

    /**
     * @return mixed
     */
    public static function invokeStaticMethod(string $className, string $methodName, array $arguments)
    {
        return self::classCache($className)
            ->reflectionMethod($methodName)
            ->invoke(null, ... $arguments);
    }

    /**
     * Offers methods that are based on objects instead of class names.
     *
     * For IDE support, the methods are defined in this class' DocBlock.
     *
     * @param string $methodName
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic(string $methodName, array $arguments)
    {
        $mappedMethods = [
            'classByObject' => 'classByName',
            'propertyOfObject' => 'propertyOfClass',
            'allPropertiesOfObject' => 'allPropertiesOfClass',
            'methodOfObject' => 'methodOfClass',
            'allMethodsOfObject' => 'allMethodsOfClass',
        ];
        if (! array_key_exists($methodName, $mappedMethods)) {
            throw new \Error(
                sprintf(
                    'Call to undefined method %s::%s()',
                    static::class,
                    $methodName
                )
            );
        }

        $methodName = $mappedMethods[$methodName];
        $className = get_class(
            array_shift($arguments)
        );

        return self::$methodName($className, ...$arguments);
    }

    private static function classCache(string $className) : ClassCache
    {
        if (! array_key_exists($className, self::$classCaches)) {
            self::$classCaches[$className] = new ClassCache($className);
        }

        return self::$classCaches[$className];
    }
}
