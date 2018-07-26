<?php


Route::group(['prefix' => 'databasewatcher'], function () {

    Route::get("overall","bakraj\DataBaseWatcher\DataBaseWatcher@overall");
    Route::get("analyze/{date}","bakraj\DataBaseWatcher\DataBaseWatcher@analyze");
    Route::get('day/{date}', "bakraj\DataBaseWatcher\DataBaseWatcher@day");
    Route::get('stats/{data?}', "bakraj\DataBaseWatcher\DataBaseWatcher@stats");
    
});
