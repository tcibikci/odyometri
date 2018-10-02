<?php

Route::get("/", "OdyometriController@index")->name('index');
Route::post("/create", "OdyometriController@create")->name("create");
Route::post("/getOdyometri", "OdyometriController@getOdyometri")->name("show");
Route::post("/update", "OdyometriController@update")->name("update");
Route::post("/getOdyometris", "OdyometriController@getOdyometris")->name("getOdyometris");
Route::post("/delete", "OdyometriController@delete")->name("delete");

