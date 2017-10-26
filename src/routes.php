<?php
/**
 * Created by PhpStorm.
 * User: darkwindcc
 * Date: 17-10-23
 * Time: 上午9:12
 */

//Route::group(['namespace' => 'Darkwind\Contract\Controllers'], function () {
//    Route::get('contracts/list', 'ContractController@list');
//    Route::delete('contracts/deletes', 'ContractController@deletes');
//    Route::get('contracts/view/{id}', 'ContractController@view');
//    Route::post('contracts/save/{id?}', 'ContractController@owner');
//});
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [], function ($api) {

    $api->group(['middleware' => ['api.auth', 'jwt.refresh']], function ($api) {
        //合同管理
        $api->group(['middleware' => ['can.path:/contracts/*']], function ($api) {
            Route::post('api/contracts/import', 'Darkwind\Contract\Controllers\ContractController@import');
            Route::get('api/contracts/list', 'Darkwind\Contract\Controllers\ContractController@list');
            Route::get('api/contracts/ownerlist', 'Darkwind\Contract\Controllers\ContractController@ownerList');
            Route::get('api/contracts/placelist', 'Darkwind\Contract\Controllers\ContractController@placeList');
            Route::get('api/contracts/electriclist', 'Darkwind\Contract\Controllers\ContractController@electricList');
            Route::delete('api/contracts/deletes', 'Darkwind\Contract\Controllers\ContractController@deletes');
            Route::get('api/contracts/view/{id}', 'Darkwind\Contract\Controllers\ContractController@view');
            Route::post('api/contracts/save/{id?}', 'Darkwind\Contract\Controllers\ContractController@owner');

        });
    });
});
