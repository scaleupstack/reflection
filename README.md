# ScaleUpStack/Reflection


This library provides a performance-improved, and convenient way to deal with PHP Reflection classes.

* **Performance:** Reflection is slow if you instantiate it continuously. If you rely on reflection heavily to inspect the same type of classes in one request over and over again, then caching of the created Reflection classes helps a lot.

* **Convenience:** Instead of dealing with the object graph of Reflection classes, a facade offers convenient methods to retrieve PHP Reflection classes, and getting/setting (non-public) properties of an object.


## Installation

Use [Composer] to install this library:

```
$ composer require scaleupstack/reflection
```


## Usage

The public API of this package is presented via the `Reflection` class. All methods of the `Reflection` class are static. (In fact, it is not possible to instantiate it.)

* Namespace

  ```php
  use ScaleUpStack\Reflection\Reflection;
  ```

* Methods to retrieve PHP Reflection objects via class name or object:

  ```php
  Reflection::classByName(string $className) : \ReflectionClass
  Reflection::classByObject(object $object) : \ReflectionClass

  Reflection::propertyOfClass(string $className, string $propertyName) : \ReflectionProperty
  Reflection::propertyOfObject(object $object, string $propertyName) : \ReflectionProperty

  Reflection::allPropertiesOfClass(string $className) : \ReflectionProperty[]
  Reflection::allPropertiesOfObject(object $object) : \ReflectionProperty[]

  Reflection::methodOfClass(string $className, string $methodName) : \ReflectionMethod
  Reflection::methodOfObject(object $object, string $methodName) : \ReflectionMethod

  Reflection::allMethodsOfClass(string $className) : \ReflectionMethod[]
  Reflection::allMethodsOfObject(object $object) : \ReflectionMethod[]
  ```

  Please note that `classByObject()` returns a `\ReflectionClass` and not a `\ReflectionObject`.

* Methods to access the values of object or static class properties:

  ```php
  Reflection::getPropertyValue(object $object, string $propertyName) : mixed
  Reflection::getStaticPropertyValue(string $className, string $propertyName) : mixed

  Reflection::setPropertyValue(object $object, string $propertyName, $value) : void
  Reflection::setStaticPropertyValue(string $className, string $propertyName, $value) : void
  ```

* Methods to invoke static and non-static methods:

  ```php
  Reflection::invokeMethod(object $object, string $methodName, array $arguments) : mixed
  Reflection::invokeStaticMethod(string $className, string $methodName, array $arguments) : mixed
  ```


## Current State

This library is work-in-progress, but the public API should be very stable.

Handling of some Reflection features that could (perhaps?) benefit from caching (e.g. getting the parent class) are not implemented yet. But I do not strive for completeness. If you are missing some features, just create a pull request or ask for it, explaining your context/needs.


## Contribute

Thanks that you want to contribute to ScaleUpStack/Reflection.

* Report any bugs or issues on the [issue tracker].

* Get the source code from the [Git repository].


## License

Please check [LICENSE.md] in the root dir of this package.


## Copyright

ScaleUpVentures Gmbh, Germany<br>
Thomas Nunninger <thomas.nunninger@scaleupventures.com><br>
[www.scaleupventures.com]



[Composer]: https://getcomposer.org
[issue tracker]: https://github.com/scaleupstack/reflection/issues
[Git repository]: https://github.com/scaleupstack/reflection
[LICENSE.md]: LICENSE.md
[www.scaleupventures.com]: https://www.scaleupventures.com/
