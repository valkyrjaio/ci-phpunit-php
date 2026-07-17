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
