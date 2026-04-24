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
    }
}
