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

namespace ScaleUpStack\Reflection\Tests\Cache;

use ScaleUpStack\Reflection\Cache\ClassCache;
use ScaleUpStack\Reflection\Tests\ReflectionTestObject;
use ScaleUpStack\Reflection\Tests\TestCase;

/**
 * @coversDefaultClass \ScaleUpStack\Reflection\Cache\ClassCache
 */
final class ClassCacheTest extends TestCase
{
    /**
     * @test
     * @covers ::__construct()
     * @covers ::reflectionClass()
     */
    public function it_retrieves_the_reflection_class()
    {
        // given a class name
        $className = ReflectionTestObject::class;

        // when constructing the ClassCache
        // and retrieving the ReflectionClass
        $cache = new ClassCache($className);
        $reflectionClass = $cache->reflectionClass();

        // then an instance of ReflectionClass is returned
        $this->assertInstanceOf(\ReflectionClass::class, $reflectionClass);
    }
}
