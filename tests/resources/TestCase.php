<?php declare(strict_types = 1);

/**
 * This file is part of ScaleUpStack/Reflection.
 *
 * For the full copyright and license information, please view the README.md and LICENSE.md files that were distributed
 * with this source code.
 *
 * @copyright 2019 - present ScaleUpVentures GmbH, https://www.scaleupventures.com
 * @link      https://github.com/scaleupstack/reflection
 */

namespace ScaleUpStack\Reflection\Tests;

use ScaleUpStack\Reflection\Reflection;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        $reflectionClass = new \ReflectionClass(Reflection::class);

        $reflectionProperty = $reflectionClass->getProperty('reflectionClasses');
        $reflectionProperty->setAccessible(true);

        $reflectionProperty->setValue([]);
    }
}
