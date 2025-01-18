<?php

namespace Inovector\MixpostAuth\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Contracts\Console\Kernel;
use Inovector\MixpostAuth\MixpostAuthServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn(string $modelName) => 'Inovector\\MixpostAuth\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            MixpostAuthServiceProvider::class
        ];
    }

    protected function refreshTestDatabase()
    {
        if (!RefreshDatabaseState::$migrated) {
            $this->artisan('migrate:fresh', $this->migrateFreshUsing());

            if ($this->app->version() > 10) {
                $migration = include __DIR__ . '/../vendor/orchestra/testbench-core/laravel/migrations/0001_01_01_000000_testbench_create_users_table.php';
                $migration->up();
            } else {
                $migration = include __DIR__ . '/../vendor/orchestra/testbench-core/laravel/migrations/2014_10_12_000000_testbench_create_users_table.php';
                $migration->up();
            }

            $this->app[Kernel::class]->setArtisan(null);

            RefreshDatabaseState::$migrated = true;
        }

        $this->beginDatabaseTransaction();
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'mysql');

        config()->set('database.connections.mysql', [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3305'),
            'database' => env('DB_DATABASE', 'mixpost_auth_test'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'prefix' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]);
    }

    public function publishAssets(): void
    {
        $this->artisan('vendor:publish', ['--tag' => 'mixpost-auth-assets'])->run();
    }
}
