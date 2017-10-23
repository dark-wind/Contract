<?php
/**
 * Created by PhpStorm.
 * User: darkwindcc
 * Date: 17-10-23
 * Time: 上午9:12
 */

Route::group(['namespace' => 'Darkwind\Contract\Controllers'], function () {
    Route::group(['middleware' => ['can.path:/contracts/*']], function () {
        Route::get('contracts/list', 'ContractController@index');
        Route::delete('contracts/deletes', 'ContractController@deletes');
        Route::get('contracts/view/{id}', 'ContractController@view');
        Route::post('contracts/save/{id?}', 'ContractController@owner');
    });
});
