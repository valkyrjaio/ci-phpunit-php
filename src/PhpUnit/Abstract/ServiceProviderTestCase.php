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

namespace Valkyrja\PhpUnit\Abstract;

use Override;
use PHPUnit\Framework\Attributes\DataProvider;
use Valkyrja\Application\Data\Config;
use Valkyrja\Application\Data\Contract\ConfigContract;
use Valkyrja\Application\Env\Env;
use Valkyrja\Application\Kernel\Contract\ApplicationContract;
use Valkyrja\Container\Manager\Container;
use Valkyrja\Container\Manager\Contract\ContainerContract;
use Valkyrja\Container\Provider\Contract\ServiceProviderContract;

use function array_map;
use function class_exists;

/**
 * Test a ServiceProvider.
 */
abstract class ServiceProviderTestCase extends ValkyrjaTestCase
{
    /** @var class-string<ServiceProviderContract> */
    protected static string $provider;

    protected Container $container;

    /**
     * @return array<array<callable(ContainerContract):void>>
     */
    public static function publishersDataProvider(): array
    {
        return array_map(static fn ($item) => [$item], static::getPublishers());
    }

    /**
     * @return array<array<class-string>>
     */
    public static function providesDataProvider(): array
    {
        return array_map(static fn ($item) => [$item], array_keys(static::getPublishers()));
    }

    /**
     * @return array<class-string, callable(ContainerContract):void>
     */
    protected static function getPublishers(): array
    {
        return static::$provider::publishers();
    }

    protected static function assertValidProvided(string $provided): void
    {
        if (class_exists($provided)) {
            self::assertClassExists($provided);

            return;
        }

        self::assertInterfaceExists($provided);
    }

    #[Override]
    protected function setUp(): void
    {
        $this->container = new Container();

        $this->container->setSingleton(Env::class, new Env());
        $this->container->setSingleton(ApplicationContract::class, self::createStub(ApplicationContract::class));
        $this->container->setSingleton(ConfigContract::class, new Config());
    }

    /**
     * @param class-string $provided
     */
    #[DataProvider('providesDataProvider')]
    public function testProvides(string $provided): void
    {
        self::assertValidProvided($provided);
    }

    /**
     * @param array<array-key, mixed> $callable
     */
    #[DataProvider('publishersDataProvider')]
    public function testPublishers(array $callable): void
    {
        self::assertIsCallable($callable);
    }
}
