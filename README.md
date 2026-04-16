<p align="center"><a href="https://valkyrja.io" target="_blank">
    <img src="https://raw.githubusercontent.com/valkyrjaio/art/refs/heads/master/full-logo/orange/php.png" width="400">
</a></p>

# Valkyrja PHPUnit

PHPUnit custom assertions and test cases for the Valkyrja project.

## Overview

This repository provides `ValkyrjaTestCase`, an abstract base class that extends
PHPUnit's `TestCase` with additional assertion helpers used across the Valkyrja
monorepo.

## Requirements

- PHP >= 8.4
- [`phpunit/phpunit`](https://github.com/sebastianbergmann/phpunit) ^13.0

## Installation

```bash
composer require valkyrja/phpunit
```

## Usage

Extend `ValkyrjaTestCase` (or the provided `PhpUnitTestCase` subclass) in your
test classes to gain access to the additional assertions:

```php
use Valkyrja\PhpUnit\Abstract\ValkyrjaTestCase;

final class MyTest extends ValkyrjaTestCase
{
    public function testSomething(): void
    {
        self::assertIsA(MyInterface::class, MyClass::class);
    }
}
```

## Additional Assertions

### `assertIsA(string $expected, string $actual)`

Asserts that `$actual` is `$expected` or one of its descendants/implementations,
using `is_a()` with `$allow_string = true`.

```php
self::assertIsA(ParentClass::class, ChildClass::class);
self::assertIsA(MyInterface::class, MyClass::class);
```

### `assertMethodExists(object|string $class, string $method)`

Asserts that `$method` exists on the given class name or object instance.

```php
self::assertMethodExists(MyClass::class, 'myMethod');
self::assertMethodExists(new MyClass(), 'myMethod');
```

### `assertClassExists(string $class)`

Asserts that the given class name resolves to a loadable class.

```php
self::assertClassExists(MyClass::class);
```

### `assertInterfaceExists(string $interface)`

Asserts that the given name resolves to a loadable interface.

```php
self::assertInterfaceExists(MyInterface::class);
```

### `assertTraitExists(string $trait)`

Asserts that the given name resolves to a loadable trait.

```php
self::assertTraitExists(MyTrait::class);
```

### `assertSameCount(array|Countable $expected, array|Countable $actual)`

Asserts that `$actual` has the same number of elements as `$expected`.

```php
self::assertSameCount($expectedCollection, $actualCollection);
```

### `isA(string $expected, string $actual)`

Alias for `assertIsA`.

```php
self::isA(ParentClass::class, ChildClass::class);
```
