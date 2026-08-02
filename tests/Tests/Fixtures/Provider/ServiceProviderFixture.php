<?php

declare(strict_types=1);

/*
 * This file is part of the Valkyrja PHPUnit package.
 *
 * Copyright (c) 2016-present Melech Mizrachi
 *
 * Released under the MIT License. See LICENSE.md for details.
 */

namespace Valkyrja\PhpUnit\Tests\Fixtures\Provider;

use Override;
use Valkyrja\Container\Provider\Contract\ServiceProviderContract;

/**
 * Class ServiceProviderFixture.
 */
final class ServiceProviderFixture implements ServiceProviderContract
{
    public static bool $publishCalled = false;

    public static bool $publishInterfaceCalled = false;

    public static function publish(object $providerAware): void
    {
        self::$publishCalled = true;
    }

    public static function publishInterface(object $providerAware): void
    {
        self::$publishInterfaceCalled = true;
    }

    #[Override]
    public function publishers(): array
    {
        return [
            ServiceProvidedFixture::class   => [self::class, 'publish'],
            ServiceProvidedInterface::class => [self::class, 'publishInterface'],
        ];
    }
}
