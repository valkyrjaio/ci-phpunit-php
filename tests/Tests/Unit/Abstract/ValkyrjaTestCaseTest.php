<?php

declare(strict_types=1);

/*
 * This file is part of the Valkyrja PHPUnit package.
 *
 * Copyright (c) 2016-present Melech Mizrachi
 *
 * Released under the MIT License. See LICENSE.md for details.
 */

namespace Valkyrja\PhpUnit\Tests\Unit\Abstract;

use Countable;
use PHPUnit\Framework\AssertionFailedError;
use Valkyrja\PhpUnit\Tests\Abstract\PhpUnitTestCase;
use Valkyrja\PhpUnit\Tests\Fixtures\Contract\FixtureContract;
use Valkyrja\PhpUnit\Tests\Fixtures\FixtureChildFixture;
use Valkyrja\PhpUnit\Tests\Fixtures\FixtureCountableFixture;
use Valkyrja\PhpUnit\Tests\Fixtures\FixtureParentFixture;
use Valkyrja\PhpUnit\Tests\Fixtures\Trait\FixtureTrait;

/**
 * Tests for ValkyrjaTestCase.
 */
final class ValkyrjaTestCaseTest extends PhpUnitTestCase
{
    // region assertIsA

    public function testAssertIsAWithSameClass(): void
    {
        self::assertIsA(FixtureParentFixture::class, FixtureParentFixture::class);
    }

    public function testAssertIsAWithSubclass(): void
    {
        self::assertIsA(FixtureParentFixture::class, FixtureChildFixture::class);
    }

    public function testAssertIsAWithInterfaceImplementation(): void
    {
        self::assertIsA(FixtureContract::class, FixtureParentFixture::class);
    }

    public function testAssertIsAFailsWhenNotRelated(): void
    {
        $this->expectException(AssertionFailedError::class);
        self::assertIsA(FixtureChildFixture::class, FixtureParentFixture::class);
    }

    // endregion

    // region assertMethodExists

    public function testAssertMethodExistsWithClassName(): void
    {
        self::assertMethodExists(FixtureParentFixture::class, 'fixtureMethod');
    }

    public function testAssertMethodExistsWithObject(): void
    {
        self::assertMethodExists(new FixtureParentFixture(), 'fixtureMethod');
    }

    public function testAssertMethodExistsFailsWhenMissing(): void
    {
        $this->expectException(AssertionFailedError::class);
        self::assertMethodExists(FixtureParentFixture::class, 'nonExistentMethod');
    }

    // endregion

    // region assertClassExists

    public function testAssertClassExists(): void
    {
        self::assertClassExists(FixtureParentFixture::class);
    }

    public function testAssertClassExistsFails(): void
    {
        $this->expectException(AssertionFailedError::class);
        /** @var class-string $nonExistentClass */
        $nonExistentClass = 'Valkyrja\PhpUnit\Tests\Fixtures\NonExistentClass';
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
        self::assertInterfaceExists('Valkyrja\PhpUnit\Tests\Fixtures\NonExistentInterface');
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
        self::assertTraitExists('Valkyrja\PhpUnit\Tests\Fixtures\NonExistentTrait');
    }

    // endregion

    // region isA

    public function testIsAWithSameClass(): void
    {
        self::isA(FixtureParentFixture::class, FixtureParentFixture::class);
    }

    public function testIsAWithSubclass(): void
    {
        self::isA(FixtureParentFixture::class, FixtureChildFixture::class);
    }

    public function testIsAWithInterfaceImplementation(): void
    {
        self::isA(FixtureContract::class, FixtureParentFixture::class);
    }

    public function testIsAFailsWhenNotRelated(): void
    {
        $this->expectException(AssertionFailedError::class);
        self::isA(FixtureChildFixture::class, FixtureParentFixture::class);
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
        $expected = new FixtureCountableFixture(3);
        $actual   = new FixtureCountableFixture(3);
        self::assertSameCount($expected, $actual);
    }

    public function testAssertSameCountWithMixedArrayAndCountable(): void
    {
        self::assertSameCount([1, 2], new FixtureCountableFixture(2));
    }

    public function testAssertSameCountFailsWithDifferentCounts(): void
    {
        $this->expectException(AssertionFailedError::class);
        self::assertSameCount([1, 2], [1, 2, 3]);
    }

    // endregion
}
