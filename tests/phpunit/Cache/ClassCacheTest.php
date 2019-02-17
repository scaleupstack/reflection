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
     * @var ClassCache
     */
    private $classCache;

    public function setUp()
    {
        $this->classCache = new ClassCache(ReflectionTestObject::class);
    }

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

    /**
     * @test
     * @covers ::reflectionProperty()
     */
    public function it_retrieves_a_reflection_property()
    {
        // given a ClassCache as provided in setUp()
        // and a property name
        $propertyName = 'myPrivateProperty';

        // when retrieving a ReflectionProperty twice
        $reflectionProperty1 = $this->classCache->reflectionProperty($propertyName);
        $reflectionProperty2 = $this->classCache->reflectionProperty($propertyName);

        // then an instance of ReflectionProperty is returned
        $this->assertInstanceOf(\ReflectionProperty::class, $reflectionProperty1);
        // and both instances are the same
        $this->assertSame($reflectionProperty1, $reflectionProperty2);
    }
}
