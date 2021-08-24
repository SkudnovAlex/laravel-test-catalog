<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clearCache();
    }

    protected function clearCache(): void
    {
        $commands = ['cache:clear', 'view:clear', 'config:clear', 'route:clear'];

        foreach ($commands as $command) {
            Artisan::call($command);
        }
    }
}
