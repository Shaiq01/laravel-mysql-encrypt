<?php

namespace DanielPardamean\MysqlEncrypt\Providers;

use DanielPardamean\MysqlEncrypt\Traits\ValidatesEncrypted;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    use ValidatesEncrypted;

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('mysql-encrypt.php'),
        ], 'config');

        $this->addValidators();
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'mysql-encrypt');
    }
}
