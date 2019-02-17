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

class Reflection
{
    private static $reflectionClasses = [];

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    public static function classByName(string $className) : \ReflectionClass
    {
        if (! array_key_exists($className, self::$reflectionClasses)) {
            self::$reflectionClasses[$className] = new \ReflectionClass($className);
        }

        return self::$reflectionClasses[$className];
    }
}
