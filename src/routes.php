<?php
/**
 * Created by PhpStorm.
 * User: darkwindcc
 * Date: 17-10-23
 * Time: 上午9:12
 */


Route::get('test', 'Darkwind\Certification\Controllers\ContractController@index');
Route::delete('deletes', 'Darkwind\Certification\Controllers\ContractController@deletes');
Route::get('view/{id}', 'Darkwind\Certification\Controllers\ContractController@view');
Route::post('owner/save/{id?}', 'Darkwind\Certification\Controllers\ContractController@owner');
