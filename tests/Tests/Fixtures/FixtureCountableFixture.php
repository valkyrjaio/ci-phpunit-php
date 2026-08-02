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

use Countable;

final class FixtureCountableFixture implements Countable
{
    public function __construct(private readonly int $count)
    {
    }

    public function count(): int
    {
        return $this->count;
    }
}
