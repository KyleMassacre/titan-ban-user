<?php
Route::group([
    'middleware' => ['auth', 'update_last_move'],
    'prefix' => 'admin'
], function (\Illuminate\Routing\Router $route) {
    $route->get('banuser', 'AdminController@index')->name('admin.banuser.index');
    $route->get('unban/{playable}', 'AdminController@destroy')->name('admin.banuser.unban');
    $route->match(['GET', 'POST'], 'ban/datatables', 'AdminController@dataTable')->name('admin.banuser.datatable');
    $route->group([
        'middleware' => ['permission:ban-user'],
    ], function() use ($route) {
        $route->resource('banuser', 'AdminBanUserController')->names([
            'create' => 'admin.banuser.create',
            'store' => 'admin.banuser.store',
            'update' => 'admin.banuser.update',
            'edit' => 'admin.banuser.edit',
        ])->except(['index', 'destroy']);
        $route->resource('banchar', 'AdminBanCharController')->names([
            'create' => 'admin.banchar.create',
            'store' => 'admin.banchar.store',
            'update' => 'admin.banchar.update',
            'edit' => 'admin.banchar.edit',
        ])->except(['index', 'destroy']);
    });



//    $route->resource('admin.banuser', 'AdminController')
//    ->only(['index', 'edit']);
//    $route->get('/', 'AdminController@index')->name('banuser.index');
//    $route->get('ban/{type}/{playable}', 'AdminController@banPlayable')->name('admin.banuser.ban');
//    $route->post('ban/user/{playable}/place', 'AdminController@placeBanUser')->name('admin.banuser.place-ban');
//    $route->post('ban/char/{playable}/place', 'AdminController@placeBanChar')->name('admin.banchar.place-ban');
//    $route->get('unban/{playable}', 'AdminController@unbanPlayable')->name('admin.banuser.unban');
//    $route->match(['GET', 'POST'], 'datatables', 'AdminController@dataTable')->name('admin.banuser.datatable');
});
