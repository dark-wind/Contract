<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContractAuth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Artisan::call('rbac:addperm', ['name' => '/contracts/*']);

        Artisan::call('rbac:attachperm', ['rolename' => 'suadmin', 'permname' => '/contracts/*']);
        Artisan::call('rbac:attachperm', ['rolename' => 'admin', 'permname' => '/contracts/*']);
        Artisan::call('rbac:attachperm', ['rolename' => '铁塔用户', 'permname' => '/contracts/*']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Artisan::call('rbac:detachperm', ['rolename' => '铁塔用户', 'permname' => '/contracts/*']);
        Artisan::call('rbac:detachperm', ['rolename' => 'admin', 'permname' => '/contracts/*']);
        Artisan::call('rbac:detachperm', ['rolename' => 'suadmin', 'permname' => '/contracts/*']);

        Artisan::call('rbac:removeperm', ['name' => '/contracts/*']);
    }
}
