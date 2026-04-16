<p align="center"><a href="https://valkyrja.io" target="_blank">
    <img src="https://raw.githubusercontent.com/valkyrjaio/art/refs/heads/master/full-logo/orange/php.png" width="400">
</a></p>

# Valkyrja PHPUnit

PHPUnit custom assertions and test cases for the Valkyrja project.

<p>
    <a href="https://packagist.org/packages/valkyrja/phpunit"><img src="https://poser.pugx.org/valkyrja/phpunit/require/php" alt="PHP Version Require"></a>
    <a href="https://packagist.org/packages/valkyrja/phpunit"><img src="https://poser.pugx.org/valkyrja/phpunit/v" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/valkyrja/phpunit"><img src="https://poser.pugx.org/valkyrja/phpunit/license" alt="License"></a>
    <!-- <a href="https://packagist.org/packages/valkyrja/phpunit"><img src="https://poser.pugx.org/valkyrja/phpunit/downloads" alt="Total Downloads"></a>-->
    <a href="https://scrutinizer-ci.com/g/valkyrjaio/phpunit/?branch=master"><img src="https://scrutinizer-ci.com/g/valkyrjaio/phpunit/badges/quality-score.png?b=master" alt="Scrutinizer"></a>
    <a href="https://coveralls.io/github/valkyrjaio/phpunit?branch=master"><img src="https://coveralls.io/repos/github/valkyrjaio/phpunit/badge.svg?branch=master" alt="Coverage Status" /></a>
    <a href="https://shepherd.dev/github/valkyrjaio/phpunit"><img src="https://shepherd.dev/github/valkyrjaio/phpunit/coverage.svg" alt="Psalm Shepherd" /></a>
    <a href="https://sonarcloud.io/summary/new_code?id=valkyrjaio_phpunit"><img src="https://sonarcloud.io/api/project_badges/measure?project=valkyrjaio_phpunit&metric=sqale_rating" alt="Maintainability Rating" /></a>
</p>

Build Status
------------

<table>
    <tbody>
        <tr>
            <td>Linting</td>
            <td>
                <a href="https://github.com/valkyrjaio/phpunit/actions/workflows/phpcodesniffer.yml?query=branch%3Amaster"><img src="https://github.com/valkyrjaio/phpunit/actions/workflows/phpcodesniffer.yml/badge.svg?branch=master" alt="PHP Code Sniffer Build Status"></a>
            </td>
            <td>
                <a href="https://github.com/valkyrjaio/phpunit/actions/workflows/phpcsfixer.yml?query=branch%3Amaster"><img src="https://github.com/valkyrjaio/phpunit/actions/workflows/phpcsfixer.yml/badge.svg?branch=master" alt="PHP CS Fixer Build Status"></a>
            </td>
        </tr>
        <tr>
            <td>Coding Rules</td>
            <td>
                <a href="https://github.com/valkyrjaio/phpunit/actions/workflows/phparkitect.yml?query=branch%3Amaster"><img src="https://github.com/valkyrjaio/phpunit/actions/workflows/phparkitect.yml/badge.svg?branch=master" alt="PHPArkitect Build Status"></a>
            </td>
            <td>
                <a href="https://github.com/valkyrjaio/phpunit/actions/workflows/rector.yml?query=branch%3Amaster"><img src="https://github.com/valkyrjaio/phpunit/actions/workflows/rector.yml/badge.svg?branch=master" alt="Rector Build Status"></a>
            </td>
        </tr>
        <tr>
            <td>Static Analysis</td>
            <td>
                <a href="https://github.com/valkyrjaio/phpunit/actions/workflows/phpstan.yml?query=branch%3Amaster"><img src="https://github.com/valkyrjaio/phpunit/actions/workflows/phpstan.yml/badge.svg?branch=master" alt="PHPStan Build Status"></a>
            </td>
            <td>
                <a href="https://github.com/valkyrjaio/phpunit/actions/workflows/psalm.yml?query=branch%3Amaster"><img src="https://github.com/valkyrjaio/phpunit/actions/workflows/psalm.yml/badge.svg?branch=master" alt="Psalm Build Status"></a>
            </td>
        </tr>
        <tr>
            <td>Testing</td>
            <td>
                <a href="https://github.com/valkyrjaio/phpunit/actions/workflows/phpunit.yml?query=branch%3Amaster"><img src="https://github.com/valkyrjaio/phpunit/actions/workflows/phpunit.yml/badge.svg?branch=master" alt="PHPUnit Build Status"></a>
            </td>
            <td>
                <a href="https://github.com/valkyrjaio/phpunit/actions/workflows/validate-composer.yml?query=branch%3Amaster"><img src="https://github.com/valkyrjaio/phpunit/actions/workflows/validate-composer.yml/badge.svg?branch=master" alt="Validate Composer Build Status"></a>
            </td>
        </tr>
    </tbody>
</table>

## Overview

This repository provides `ValkyrjaTestCase`, an abstract base class that extends
PHPUnit's `TestCase` with additional assertion helpers used across the Valkyrja
monorepo.

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
