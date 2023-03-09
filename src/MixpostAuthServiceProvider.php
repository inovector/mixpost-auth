<?php

namespace Inovector\MixpostAuth;

use Illuminate\Support\Facades\Blade;
use Inovector\MixpostAuth\Commands\CreateUser;
use Inovector\MixpostAuth\Commands\ChangeUserPassword;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MixpostAuthServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('mixpost-auth')
            ->hasConfigFile()
            ->hasViews()
            ->hasRoute('web')
            ->hasCommands([
                CreateUser::class,
                ChangeUserPassword::class
            ]);
    }

    public function packageBooted(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->package->basePath("/../resources/dist/vendor/{$this->package->shortName()}") => public_path("vendor/{$this->package->shortName()}"),
                $this->package->basePath('/../resources/img') => public_path("vendor/{$this->package->shortName()}/img"),
            ], "{$this->package->shortName()}-assets");
        }

        $this->bootBladeComponents();
    }

    protected function bootBladeComponents(): static
    {
        Blade::component('mixpost-auth::components.panel', 'mixpost-auth::panel');
        Blade::component('mixpost-auth::components.input', 'mixpost-auth::input');
        Blade::component('mixpost-auth::components.input-error', 'mixpost-auth::input-error');
        Blade::component('mixpost-auth::components.checkbox', 'mixpost-auth::checkbox');
        Blade::component('mixpost-auth::components.primary-button', 'mixpost-auth::primary-button');

        return $this;
    }
}
