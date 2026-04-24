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

use Valkyrja\PhpUnit\Abstract\ServiceProviderTestCase;
use Valkyrja\PhpUnit\Tests\Classes\Provider\ServiceProvidedClass;
use Valkyrja\PhpUnit\Tests\Classes\Provider\ServiceProvidedInterface;
use Valkyrja\PhpUnit\Tests\Classes\Provider\ServiceProviderClass;

/**
 * Tests for ServiceProviderTestCase.
 */
final class ServiceProviderTestCaseTest extends ServiceProviderTestCase
{
    protected static string $provider = ServiceProviderClass::class;

    public function testExpectedPublishers(): void
    {
        self::assertArrayHasKey(ServiceProvidedClass::class, ServiceProviderClass::publishers());
        self::assertArrayHasKey(ServiceProvidedInterface::class, ServiceProviderClass::publishers());
    }

    public function testGetPublishers(): void
    {
        self::assertSame(ServiceProviderClass::publishers(), static::getPublishers());
    }

    public function testPublishersDataProvider(): void
    {
        $result = static::publishersDataProvider();

        self::assertCount(2, $result);
        self::assertIsArray($result[0]);
    }

    public function testProvidesDataProvider(): void
    {
        $result = static::providesDataProvider();

        self::assertCount(2, $result);
        self::assertIsArray($result[0]);
    }
}
