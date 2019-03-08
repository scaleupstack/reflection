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

namespace ScaleUpStack\Reflection\Tests\PhpUnit;

use ScaleUpStack\Reflection\ClassCache;
use ScaleUpStack\Reflection\Tests\Resources\ReflectionTestObject;
use ScaleUpStack\Reflection\Tests\Resources\TestCase;

/**
 * @coversDefaultClass \ScaleUpStack\Reflection\ClassCache
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
    public function it_retrieves_the_reflection_class_of_a_class()
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

    /**
     * @test
     * @covers ::allReflectionProperties()
     */
    public function it_retrieves_all_reflection_properties_and_cares_about_previously_loaded_properties()
    {
        // given a ClassCache as provided in setUp()
        // and having loaded a ReflectionProperty previously
        $previouslyLoadedReflectionProperty = $this->classCache->reflectionProperty('myPrivateProperty');

        // when retrieving all ReflectionProperties
        $allReflectionProperties = $this->classCache->allReflectionProperties();

        // then all ReflectionProperties are in the correct ordering
        $this->assertSame(
            [
                'firstProperty',
                'myPrivateProperty',
                'myProtectedProperty',
                'myLastAndPublicProperty',
                'someStaticProperty',
            ],
            array_keys($allReflectionProperties)
        );
        // and the previously loaded ReflectionProperty is the same as in the complete list
        $this->assertSame(
            $previouslyLoadedReflectionProperty,
            $allReflectionProperties['myPrivateProperty']
        );
    }

    /**
     * @test
     * @covers ::reflectionMethod()
     */
    public function it_retrieves_a_reflection_method()
    {
        // given a ClassCache as provided in setUp()
        // and a method name
        $methodName = 'getMyPrivateProperty';

        // when retrieving a ReflectionMethod twice
        $reflectionMethod1 = $this->classCache->reflectionMethod($methodName);
        $reflectionMethod2 = $this->classCache->reflectionMethod($methodName);

        // then an instance of RefelectionMethod is returned
        $this->assertInstanceOf(\ReflectionMethod::class, $reflectionMethod1);
        // and both instances are the same
        $this->assertSame($reflectionMethod1, $reflectionMethod2);
    }

    /**
     * @test
     * @covers ::allReflectionMethods()
     */
    public function it_retrieves_all_reflection_methods_and_cares_about_previously_loaded_methods()
    {
        // given a ClassCache as provided in setUp()
        // and having loaded a ReflectionMethod previously
        $previouslyLoadedReflectionMethod = $this->classCache->reflectionMethod('getMyPrivateProperty');

        // when retrieving all ReflectionMethods
        $allReflectionMethods = $this->classCache->allReflectionMethods();

        // then all ReflectionMethods are in the correct ordering
        $this->assertSame(
            [
                'setFirstProperty',
                'getMyPrivateProperty',
            ],
            array_keys($allReflectionMethods)
        );
        // and the previously loaded ReflectionMethod is the same as in the complete list
        $this->assertSame(
            $previouslyLoadedReflectionMethod,
            $allReflectionMethods['getMyPrivateProperty']
        );
    }
}
