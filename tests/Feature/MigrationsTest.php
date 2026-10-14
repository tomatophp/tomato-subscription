<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase;

class MigrationsTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    public function test_migrations_run_on_the_current_laravel_version(): void
    {
        $this->assertTrue(Schema::hasTable('plans'));
        $this->assertTrue(Schema::hasColumn('plans', 'price'));
    }
}
