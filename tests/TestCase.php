<?php

namespace Tests;

use Closure;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use PHPUnit\Framework\Constraint\StringContains;
use Tighten\Ziggy\Ziggy;
use Tighten\Ziggy\ZiggyServiceProvider;

class TestCase extends OrchestraTestCase
{
    public static function assertStringContainsString(string $needle, string $haystack, string $message = ''): void
    {
        $constraint = new StringContains($needle, false);

        static::assertThat($haystack, $constraint, $message);
    }

    protected function tearDown(): void
    {
        Ziggy::clearRoutes();

        parent::tearDown();
    }

    protected function getPackageProviders($app)
    {
        return [ZiggyServiceProvider::class];
    }

    protected function laravelVersion(int $v = null)
    {
        $version = (int) head(explode('.', app()->version()));

        return isset($v) ? $version >= $v : $version;
    }

    protected function noop(): Closure
    {
        return function () {
            return '';
        };
    }
}
