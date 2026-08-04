<p align="center"><a href="https://valkyrja.io" target="_blank">
    <img src="https://raw.githubusercontent.com/valkyrjaio/art/refs/heads/26.x/long-banner/orange/php.png" width="100%">
</a></p>

# Valkyrja PHPUnit

Shared PHPUnit configuration for Valkyrja PHP projects — custom assertions,
a reusable test case base class, and a workflow that runs PHPUnit across
consuming repositories.

<p>
    <a href="https://packagist.org/packages/valkyrja/ci-phpunit"><img src="https://poser.pugx.org/valkyrja/ci-phpunit/require/php" alt="PHP Version Require"></a>
    <a href="https://packagist.org/packages/valkyrja/ci-phpunit"><img src="https://poser.pugx.org/valkyrja/ci-phpunit/v" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/valkyrja/ci-phpunit"><img src="https://poser.pugx.org/valkyrja/ci-phpunit/license" alt="License"></a>
    <a href="https://github.com/valkyrjaio/ci-phpunit-php/actions/workflows/ci.yml?query=branch%3A26.x"><img src="https://github.com/valkyrjaio/ci-phpunit-php/actions/workflows/ci.yml/badge.svg?branch=26.x" alt="CI Status"></a>
    <a href="https://scrutinizer-ci.com/g/valkyrjaio/ci-phpunit-php/?branch=26.x"><img src="https://scrutinizer-ci.com/g/valkyrjaio/ci-phpunit-php/badges/quality-score.png?b=26.x" alt="Scrutinizer"></a>
    <a href="https://coveralls.io/github/valkyrjaio/ci-phpunit-php?branch=26.x"><img src="https://coveralls.io/repos/github/valkyrjaio/ci-phpunit-php/badge.svg?branch=26.x" alt="Coverage Status" /></a>
    <a href="https://shepherd.dev/github/valkyrjaio/ci-phpunit-php"><img src="https://shepherd.dev/github/valkyrjaio/ci-phpunit-php/coverage.svg" alt="Psalm Shepherd" /></a>
    <a href="https://sonarcloud.io/summary/new_code?id=valkyrjaio_phpunit"><img src="https://sonarcloud.io/api/project_badges/measure?project=valkyrjaio_phpunit&metric=sqale_rating" alt="Maintainability Rating" /></a>
</p>

Overview
--------

This repository provides `ValkyrjaTestCase`, an abstract base class that
extends PHPUnit's `TestCase` with additional assertion helpers used across
the Valkyrja monorepo.

Installation
------------

```
composer require valkyrja/ci-phpunit
```

Usage
-----

Extend `ValkyrjaTestCase` (or the provided `PhpUnitTestCase` subclass) in
your test classes to gain access to the additional assertions:

```
use Valkyrja\PhpUnit\Abstract\ValkyrjaTestCase;

final class MyTest extends ValkyrjaTestCase
{
    public function testSomething(): void
    {
        self::assertIsA(MyInterface::class, MyClass::class);
    }
}
```

Additional Assertions
---------------------

### `assertIsA(string $expected, string $actual)`

Asserts that `$actual` is `$expected` or one of its
descendants/implementations, using `is_a()` with `$allow_string = true`.

```
self::assertIsA(ParentClass::class, ChildClass::class);
self::assertIsA(MyInterface::class, MyClass::class);
```

### `assertMethodExists(object|string $class, string $method)`

Asserts that `$method` exists on the given class name or object instance.

```
self::assertMethodExists(MyClass::class, 'myMethod');
self::assertMethodExists(new MyClass(), 'myMethod');
```

### `assertClassExists(string $class)`

Asserts that the given class name resolves to a loadable class.

```
self::assertClassExists(MyClass::class);
```

### `assertInterfaceExists(string $interface)`

Asserts that the given name resolves to a loadable interface.

```
self::assertInterfaceExists(MyInterface::class);
```

### `assertTraitExists(string $trait)`

Asserts that the given name resolves to a loadable trait.

```
self::assertTraitExists(MyTrait::class);
```

### `assertSameCount(array|Countable $expected, array|Countable $actual)`

Asserts that `$actual` has the same number of elements as `$expected`.

```
self::assertSameCount($expectedCollection, $actualCollection);
```

### `isA(string $expected, string $actual)`

Alias for `assertIsA`.

```
self::isA(ParentClass::class, ChildClass::class);
```

Workflows
---------

The [`_workflow-call.yml`](.github/workflows/_workflow-call.yml) reusable
workflow runs PHPUnit against the calling repository's source. It is
designed to be called from other repositories via `workflow_call`.

### Inputs

| Input                       | Type    | Default                | Description                                                                                                                                           |
| --------------------------- | ------- | ---------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------- |
| `paths`                     | string  | —                      | **Required.** YAML filter spec with two keys: `ci` (CI config files that trigger a base-branch fetch) and `files` (all files that trigger the check). |
| `post-pr-comment`           | boolean | `true`                 | Post a PR comment on failure and remove it on success. Disable when the calling workflow handles its own reporting.                                   |
| `composer-options`          | string  | `''`                   | Extra flags passed to every `composer install` step (e.g. `--ignore-platform-req=ext-openswoole`).                                                    |
| `ci-directory`              | string  | `'.github/ci/phpunit'` | Path to the CI directory containing `composer.json` and the tool config.                                                                              |
| `extensions`                | string  | `'mbstring, intl'`     | PHP extensions to install via `shivammathur/setup-php`.                                                                                               |
| `php-versions`              | string  | `'["8.4"]'`            | JSON array of PHP versions to test against. Each version runs as a separate matrix job.                                                               |
| `php-version-bleeding-edge` | string  | `''`                   | PHP version treated as bleeding edge — runs with `continue-on-error` and `--ignore-platform-req=php+`.                                                |
| `coverage-php-version`      | string  | `'8.4'`                | PHP version that collects coverage (all other matrix versions run plain phpunit).                                                                     |

### Usage

```yaml
jobs:
  phpunit:
    uses: valkyrjaio/ci-phpunit-php/.github/workflows/_workflow-call.yml@26.x
    permissions:
      pull-requests: write
      contents: read
    with:
      php-versions: '["8.4", "8.5"]'
      php-version-bleeding-edge: '8.5'
      paths: |
        ci:
          - '.github/ci/phpunit/**'
          - '.github/workflows/phpunit.yml'
        files:
          - '.github/ci/phpunit/**'
          - '.github/workflows/phpunit.yml'
          - 'src/**/*.php'
          - 'tests/**/*.php'
          - 'composer.json'
    secrets: inherit
```

`secrets: inherit` is required to pass the `VALKYRJA_GHA_APP_ID` and
`VALKYRJA_GHA_PRIVATE_KEY` org secrets used for PR comments.

Contributing
------------

See [`CONTRIBUTING.md`][contributing url] for the submission process and
[`VOCABULARY.md`][vocabulary url] for the terminology used across Valkyrja.

Security Issues
---------------

If you discover a security vulnerability, please follow our
[disclosure procedure][security vulnerabilities url].

License
-------

Licensed under the [MIT license][MIT license url]. See
[`LICENSE.md`](./LICENSE.md).

[contributing url]: https://github.com/valkyrjaio/.github/blob/26.x/CONTRIBUTING.md
[vocabulary url]: https://github.com/valkyrjaio/.github/blob/26.x/VOCABULARY.md
[security vulnerabilities url]: https://github.com/valkyrjaio/.github/blob/26.x/SECURITY.md
[MIT license url]: https://opensource.org/licenses/MIT
