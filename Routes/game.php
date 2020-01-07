<?php
Route::group([
    'middleware' => ['auth', 'web']
], function (\Illuminate\Routing\Router $route) {
    $route->get('banned', 'BanUserController@index')->name('userban.userbanned');
});
