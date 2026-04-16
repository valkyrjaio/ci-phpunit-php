<?php

declare(strict_types=1);

/*
 * This file is part of the Valkyrja PHPUnit package.
 *
 * (c) Melech Mizrachi <melechmizrachi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Valkyrja\PhpUnit\Tests\Unit\Abstract;

use Countable;
use PHPUnit\Framework\AssertionFailedError;
use Valkyrja\PhpUnit\Tests\Abstract\PhpUnitTestCase;
use Valkyrja\PhpUnit\Tests\Classes\Contract\FixtureContract;
use Valkyrja\PhpUnit\Tests\Classes\FixtureChildClass;
use Valkyrja\PhpUnit\Tests\Classes\FixtureCountableClass;
use Valkyrja\PhpUnit\Tests\Classes\FixtureParentClass;
use Valkyrja\PhpUnit\Tests\Classes\Trait\FixtureTrait;

/**
 * Tests for ValkyrjaTestCase.
 */
final class ValkyrjaTestCaseTest extends PhpUnitTestCase
{
    // region assertIsA

    public function testAssertIsAWithSameClass(): void
    {
        self::assertIsA(FixtureParentClass::class, FixtureParentClass::class);
    }

    public function testAssertIsAWithSubclass(): void
    {
        self::assertIsA(FixtureParentClass::class, FixtureChildClass::class);
    }

    public function testAssertIsAWithInterfaceImplementation(): void
    {
        self::assertIsA(FixtureContract::class, FixtureParentClass::class);
    }

    public function testAssertIsAFailsWhenNotRelated(): void
    {
        $this->expectException(AssertionFailedError::class);
        self::assertIsA(FixtureChildClass::class, FixtureParentClass::class);
    }

    // endregion

    // region assertMethodExists

    public function testAssertMethodExistsWithClassName(): void
    {
        self::assertMethodExists(FixtureParentClass::class, 'fixtureMethod');
    }

    public function testAssertMethodExistsWithObject(): void
    {
        self::assertMethodExists(new FixtureParentClass(), 'fixtureMethod');
    }

    public function testAssertMethodExistsFailsWhenMissing(): void
    {
        $this->expectException(AssertionFailedError::class);
        self::assertMethodExists(FixtureParentClass::class, 'nonExistentMethod');
    }

    // endregion

    // region assertClassExists

    public function testAssertClassExists(): void
    {
        self::assertClassExists(FixtureParentClass::class);
    }

    public function testAssertClassExistsFails(): void
    {
        $this->expectException(AssertionFailedError::class);
        /** @var class-string $nonExistentClass */
        $nonExistentClass = 'Valkyrja\PhpUnit\Tests\Classes\NonExistentClass';
        self::assertClassExists($nonExistentClass);
    }

    // endregion

    // region assertInterfaceExists

    public function testAssertInterfaceExists(): void
    {
        self::assertInterfaceExists(FixtureContract::class);
    }

    public function testAssertInterfaceExistsWithBuiltIn(): void
    {
        self::assertInterfaceExists(Countable::class);
    }

    public function testAssertInterfaceExistsFails(): void
    {
        $this->expectException(AssertionFailedError::class);
        self::assertInterfaceExists('Valkyrja\PhpUnit\Tests\Classes\NonExistentInterface');
    }

    // endregion

    // region assertTraitExists

    public function testAssertTraitExists(): void
    {
        self::assertTraitExists(FixtureTrait::class);
    }

    public function testAssertTraitExistsFails(): void
    {
        $this->expectException(AssertionFailedError::class);
        self::assertTraitExists('Valkyrja\PhpUnit\Tests\Classes\NonExistentTrait');
    }

    // endregion

    // region isA

    public function testIsAWithSameClass(): void
    {
        self::isA(FixtureParentClass::class, FixtureParentClass::class);
    }

    public function testIsAWithSubclass(): void
    {
        self::isA(FixtureParentClass::class, FixtureChildClass::class);
    }

    public function testIsAWithInterfaceImplementation(): void
    {
        self::isA(FixtureContract::class, FixtureParentClass::class);
    }

    public function testIsAFailsWhenNotRelated(): void
    {
        $this->expectException(AssertionFailedError::class);
        self::isA(FixtureChildClass::class, FixtureParentClass::class);
    }

    // endregion

    // region assertSameCount

    public function testAssertSameCountWithEqualArrays(): void
    {
        self::assertSameCount([1, 2, 3], ['a', 'b', 'c']);
    }

    public function testAssertSameCountWithEmptyArrays(): void
    {
        self::assertSameCount([], []);
    }

    public function testAssertSameCountWithCountables(): void
    {
        $expected = new FixtureCountableClass(3);
        $actual   = new FixtureCountableClass(3);
        self::assertSameCount($expected, $actual);
    }

    public function testAssertSameCountWithMixedArrayAndCountable(): void
    {
        self::assertSameCount([1, 2], new FixtureCountableClass(2));
    }

    public function testAssertSameCountFailsWithDifferentCounts(): void
    {
        $this->expectException(AssertionFailedError::class);
        self::assertSameCount([1, 2], [1, 2, 3]);
    }

    // endregion
}
