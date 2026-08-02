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

use Valkyrja\PhpUnit\Abstract\ServiceProviderTestCase;
use Valkyrja\PhpUnit\Tests\Fixtures\Provider\ServiceProvidedFixture;
use Valkyrja\PhpUnit\Tests\Fixtures\Provider\ServiceProvidedInterface;
use Valkyrja\PhpUnit\Tests\Fixtures\Provider\ServiceProviderFixture;

use function array_values;

/**
 * Tests for ServiceProviderTestCase.
 */
final class ServiceProviderTestCaseTest extends ServiceProviderTestCase
{
    protected static string $provider = ServiceProviderFixture::class;

    public function testExpectedPublishers(): void
    {
        self::assertArrayHasKey(ServiceProvidedFixture::class, new ServiceProviderFixture()->publishers());
        self::assertArrayHasKey(ServiceProvidedInterface::class, new ServiceProviderFixture()->publishers());
    }

    public function testGetPublishers(): void
    {
        self::assertSame(new ServiceProviderFixture()->publishers(), self::getPublishers());
    }

    public function testPublishersDataProvider(): void
    {
        $result = self::publishersDataProvider();

        self::assertCount(2, $result);
        self::assertIsArray(array_values($result)[0]);
    }

    public function testProvidesDataProvider(): void
    {
        $result = self::providesDataProvider();

        self::assertCount(2, $result);
        self::assertIsArray(array_values($result)[0]);
    }
}
