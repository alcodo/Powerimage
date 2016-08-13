<?php

Route::group(['namespace' => 'Alcodo\PowerImage\Controllers'], function () {
    Route::get('/powerimage/{path}', [
        'as' => 'powerimage.show',
        'uses' => 'PowerImage@show',
    ])->where('path', '.+');
});
