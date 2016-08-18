<?php

Route::group(['namespace' => 'Alcodo\PowerImage\Controllers'], function () {
    Route::get('/powerimage/{filepath}', [
        'as' => 'powerimage.show',
        'uses' => 'PowerImageController@show',
    ])->where('filepath', '.+');

//    Route::get('/powerimage/{directory}/{type}/{filename}.{fileextension}', [
//        'as' => 'powerimage.show',
//        'uses' => 'PowerImageController@show',
//    ]);
});
