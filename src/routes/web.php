<?php

use Illuminate\Http\Request;

Route::group(['namespace' => 'NimDevelopment\DBase\Controllers' ], function(){
    Route::get('/DBase', function(){ return view('DBase::app'); });
    Route::post('/MiMo/{name}/{mdl?}','DBaseController@make_migration');
    Route::get('/migrate', 'DBaseController@migrate');
});