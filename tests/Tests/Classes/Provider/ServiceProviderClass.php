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

namespace Valkyrja\PhpUnit\Tests\Classes\Provider;

use Override;
use Valkyrja\Container\Provider\Contract\ServiceProviderContract;

/**
 * Class ServiceProviderClass.
 */
final class ServiceProviderClass implements ServiceProviderContract
{
    public static bool $publishCalled = false;

    #[Override]
    public static function publishers(): array
    {
        return [
            ServiceProvidedClass::class => [self::class, 'publish'],
        ];
    }

    public static function publish(object $providerAware): void
    {
        self::$publishCalled = true;
    }
}
