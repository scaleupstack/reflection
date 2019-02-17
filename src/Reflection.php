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

use ScaleUpStack\Reflection\Cache\ClassCache;

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

    public static function classByObject(object $object) : \ReflectionClass
    {
        return self::classByName(
            get_class($object)
        );
    }

    public static function propertyOfClass(string $className, string $propertyName) : \ReflectionProperty
    {
        return self::classCache($className)->reflectionProperty($propertyName);
    }

    private static function classCache(string $className) : ClassCache
    {
        if (! array_key_exists($className, self::$classCaches)) {
            self::$classCaches[$className] = new ClassCache($className);
        }

        return self::$classCaches[$className];
    }
}
