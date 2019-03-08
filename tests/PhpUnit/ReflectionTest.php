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

use ScaleUpStack\Reflection\Reflection;
use ScaleUpStack\Reflection\Tests\Resources\ReflectionTestObject;
use ScaleUpStack\Reflection\Tests\Resources\TestCase;

/**
 * @coversDefaultClass \ScaleUpStack\Reflection\Reflection
 */
final class ReflectionTest extends TestCase
{
    /**
     * @test
     * @covers ::classByName()
     * @covers ::classCache()
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
     * @covers ::propertyOfClass()
     */
    public function it_retrieves_a_reflection_property_by_class_name()
    {
        // given a class name and a property name
        $className = ReflectionTestObject::class;
        $propertyName = 'myPrivateProperty';

        // when retrieving a ReflectionProperty of a class
        $reflectionProperty = Reflection::propertyOfClass($className, $propertyName);

        // then an instance of ReflectionProperty is returned
        $this->assertInstanceOf(\ReflectionProperty::class, $reflectionProperty);
    }

    /**
     * @test
     * @covers ::allPropertiesOfClass()
     */
    public function it_retrievs_all_reflection_properties_by_class_name()
    {
        // given a class name
        $className = ReflectionTestObject::class;

        // when retrieving all ReflectionProperties
        $allReflectionProperties = Reflection::allPropertiesOfClass($className);

        // then an array of ReflectionProperties is returned
        $this->assertContainsOnlyInstancesOf(\ReflectionProperty::class, $allReflectionProperties);
    }

    /**
     * @test
     * @covers ::methodOfClass()
     */
    public function it_retrieves_a_reflection_method_by_class_name()
    {
        // given a class name, and a method name
        $className = ReflectionTestObject::class;
        $methodName = 'getMyPrivateProperty';

        // when retrieving a ReflectionMethod of a class
        $reflectionMethod = Reflection::methodOfClass($className, $methodName);

        // then an instance of ReflectionMethod is returned
        $this->assertInstanceOf(\ReflectionMethod::class, $reflectionMethod);
    }

    /**
     * @test
     * @covers ::allMethodsOfClass()
     */
    public function it_retrieves_all_reflection_methods_by_class_name()
    {
        // given a class name
        $className = ReflectionTestObject::class;

        // when retrieving all ReflectionMethods
        $allReflectionMethods = Reflection::allMethodsOfClass($className);

        // then an array of ReflectionMethods is returned
        $this->assertContainsOnlyInstancesOf(\ReflectionMethod::class, $allReflectionMethods);
    }

    /**
     * @test
     * @covers ::setPropertyValue()
     * @covers ::getPropertyValue()
     */
    public function it_gets_and_sets_properties_of_an_object_when_property_was_fetched_alone()
    {
        // given an object, a property name, and a new value
        $object = new ReflectionTestObject();
        $propertyName = 'myPrivateProperty';
        $newValue = 'some new value';

        // when setting the value of a property
        Reflection::setPropertyValue($object, $propertyName, $newValue);

        // then the value is changed
        $this->assertSame(
            $newValue,
            Reflection::getPropertyValue($object, $propertyName)
        );
    }

    /**
     * @test
     */
    public function it_gets_and_sets_properties_of_an_object_when_all_properties_were_fetched()
    {
        // given an object, a property name, a new value,
        $object = new ReflectionTestObject();
        $propertyName = 'myPrivateProperty';
        $newValue = 'some new value';
        // and all properties fetched before
        Reflection::allPropertiesOfClass(ReflectionTestObject::class);

        // when setting the value of a property
        Reflection::setPropertyValue($object, $propertyName, $newValue);

        // then the value is changed
        $this->assertSame(
            $newValue,
            Reflection::getPropertyValue($object, $propertyName)
        );
    }

    /**
     * @test
     * @covers ::getStaticPropertyValue()
     * @covers ::setStaticPropertyValue()
     */
    public function it_sets_and_gets_static_properties()
    {
        // given a class name, a property name, and a new value to set
        $className = ReflectionTestObject::class;
        $propertyName = 'someStaticProperty';
        $newValue = 42;

        // when setting the static property
        Reflection::setStaticPropertyValue($className, $propertyName, $newValue);

        // then the property value was set and can be retrieved
        $this->assertSame(
            $newValue,
            Reflection::getStaticPropertyValue($className, $propertyName)
        );
    }

    public function data_provider_with_object_based_method_name_mapping()
    {
        return [
            ['classByObject', 'classByName', []],
            ['propertyOfObject', 'propertyOfClass', ['myPrivateProperty']],
            ['allPropertiesOfObject', 'allPropertiesOfClass', []],
            ['methodOfObject', 'methodOfClass', ['getMyPrivateProperty']],
            ['allMethodsOfObject', 'allMethodsOfClass', []]
        ];
    }

    /**
     * @test
     * @dataProvider data_provider_with_object_based_method_name_mapping
     * @covers ::__callStatic
     */
    public function it_supports_virtual_methods_to_work_with_objects_instead_of_class_names(
        string $objectBasedMethodName,
        string $classBasedMethodName,
        array $parameters
    )
    {
        // given an object based method name, a class based method name,
        // and the required parameters as provided by the parameters

        // when calling the two methods (based on class name, and object)
        $resultByClassName = call_user_func(
            [Reflection::class, $classBasedMethodName],
            ... array_merge(
                    [ReflectionTestObject::class],
                    $parameters
            )
        );
        $resultByObject = call_user_func(
            [Reflection::class, $objectBasedMethodName],
            ... array_merge(
                    [new ReflectionTestObject()],
                    $parameters
            )
        );

        // then the results are the same
        $this->assertSame($resultByClassName, $resultByObject);
    }

    /**
     * @test
     * @covers ::__callStatic
     */
    public function it_throws_an_error_on_unknown_static_methods()
    {
        // given a not supported method name
        $methodName = 'notSupported';

        // when calling the method
        // then an exception is thrown
        $this->expectException(\Error::class);
        $this->expectExceptionMessage('Call to undefined method ScaleUpStack\Reflection\Reflection::notSupported()');

        Reflection::$methodName();
    }
}
