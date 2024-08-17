<?php

// tests/TestCase.php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // Run migrations before each test
        Artisan::call('migrate');
    }

    protected function tearDown(): void
    {
        // Rollback migrations after each test
        Artisan::call('migrate:rollback --seed');

        parent::tearDown();
    }
}

