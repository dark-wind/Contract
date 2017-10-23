<?php

namespace Darkwind\Contract;

use Illuminate\Support\ServiceProvider;

class ContractServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //配置文件 todo
        $this->publishes([__DIR__ . '/src/config/xxx.php' => config_path('xxx.php')]);

        //迁移
        if (!class_exists('CreateContractOriginsTable')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__ . '/../database/migrations/0000_00_00_000000_create_contract_origins_table.php' => database_path('migrations/' . $timestamp . '_create_contract_origins_table.php'),
            ], 'migrations');
        }
        if (!class_exists('AddContractAuth')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__ . '/../database/migrations/0000_00_00_000000_add_contract_auth.php' => database_path('migrations/' . $timestamp . '_add_contract_auth.php'),
            ], 'migrations');
        }

        //加载路由
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
