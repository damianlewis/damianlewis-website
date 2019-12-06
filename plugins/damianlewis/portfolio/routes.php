<?php
Route::group([
    'namespace' => 'DamianLewis\Portfolio\Http\Controllers',
    'prefix' => 'api/v1'
], function () {
    Route::resource('projects', 'ProjectsController', ['only' => ['index', 'show']]);
});
