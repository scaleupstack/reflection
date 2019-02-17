# ScaleUpStack/Reflection


This library provides a performance-improved, and convenient way to deal with PHP Reflection classes.

* **Performance:** Reflection is slow if you instantiate it continuously. If you rely on reflection heavily to inspect the same type of classes in one request over and over again (e.g. in an ORM scenario), then caching of the created Reflection classes helps a lot.

* **Convenience:** Instead of dealing with the object graph of Reflection classes, a facade offers convenient methods to retrieve PHP Reflection classes, and getting/setting (non-public) properties of an object.

**Note:** Please, do not abuse this library to bypass your object design, or to validate the state of your System Under Test (SUT) in unit tests.

## Installation

Use [Composer] to install this library:

```
$ composer require scaleupventures/reflection
```


## Usage

The public API of this package is presented via the `Reflection` class. All methods of the `Reflection` class are static. (In fact, it is not possible to instantiate it.)

* Namespace

  ```php
  use ScaleUpVentures\Reflection\Reflection;
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

* Methods to acces the values of object properties:

  ```php
  Reflection::getPropertyValue(object $object, string $propertyName)
  Reflection::setPropertyValue(object $object, string $propertyName, $value)
  ```


## Current State

This library is work-in-progress, but the public API should be very stable. Before releasing a 1.0 version, I'd like to add some features that I need in another library.

Handling of some Reflection features that could benefit from caching (e.g. getting the parent class) are not implemented yet. Some of those features will probably follow soon as needed when developing my other library. But I do not strive for completeness. If you are missing some features, just create a pull request or ask for it, explaining your context/needs.


## Contribute

Thanks that you want to contribute to ScaleUpVentures/Reflection.

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
