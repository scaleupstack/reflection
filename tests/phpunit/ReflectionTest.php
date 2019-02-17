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
use ScaleUpStack\Reflection\Tests\TestCase;

/**
 * @coversDefaultClass \ScaleUpStack\Reflection\Reflection
 */
final class ReflectionTest extends TestCase
{
    /**
     * @test
     * @covers ::classByName()
     */
    public function it_retrieves_a_reflection_class_by_class_name()
    {
        // given a class name
        $className = ReflectionTestObject::class;

        // when retrieving the reflection class by class name
        $reflectionClass = Reflection::classByName($className);

        // then an instance of ReflectionClass is returned
        $this->assertInstanceOf(\ReflectionClass::class, $reflectionClass);
    }

    /**
     * @test
     */
    public function it_retrieves_a_the_same_instance_of_a_reflection_class_for_one_class()
    {
        // given a class name
        $className = ReflectionTestObject::class;

        // when retrieving the reflection class twice
        $reflectionClass1 = Reflection::classByName($className);
        $reflectionClass2 = Reflection::classByName($className);

        // then the both instances are the same
        $this->assertSame($reflectionClass1, $reflectionClass2);
    }

    /**
     * @test
     * @covers ::classByObject()
     */
    public function it_retrieves_a_reflection_class_by_object()
    {
        // given an object
        $object = new ReflectionTestObject();

        // when retrieving the reflection class by object
        $reflectionClass = Reflection::classByObject($object);

        // then an instance of ReflectionClass is returned
        $this->assertInstanceOf(\ReflectionClass::class, $reflectionClass);
        // and the instance is the same as if retrieved by class name
        $this->assertSame(
            $reflectionClass,
            Reflection::classByName(ReflectionTestObject::class)
        );
    }
}
