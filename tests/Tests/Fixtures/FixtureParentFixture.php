<?php

declare(strict_types=1);

/*
 * This file is part of the Valkyrja PHPUnit package.
 *
 * Copyright (c) 2016-present Melech Mizrachi
 *
 * Released under the MIT License. See LICENSE.md for details.
 */

namespace Valkyrja\PhpUnit\Tests\Fixtures;

use Valkyrja\PhpUnit\Tests\Fixtures\Contract\FixtureContract;
use Valkyrja\PhpUnit\Tests\Fixtures\Trait\FixtureTrait;

class FixtureParentFixture implements FixtureContract
{
    use FixtureTrait;

    public function fixtureMethod(): void
    {
    }
}
