<?php
Route::group([
    'namespace' => 'DamianLewis\Portfolio\Http\Controllers',
    'prefix' => 'api/v1'
], function () {
    Route::resource('projects', 'ProjectsController', ['only' => ['index', 'show']]);
    Route::resource('categories', 'CategoriesController', ['only' => ['index', 'show']]);
    Route::resource('skills', 'SkillsController', ['only' => ['index', 'show']]);
    Route::resource('services', 'ServicesController', ['only' => ['index', 'show']]);
});
