<?php

Route::group([
    'middleware' => []
], function () {

    include __DIR__ . '/game.php';

    include __DIR__ . '/admin.php';

});
