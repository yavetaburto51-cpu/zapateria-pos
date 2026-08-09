<?php

use Illuminate\Support\Facades\URL;

it('forces https for generated URLs', function () {
    config(['app.url' => 'http://localhost']);

    expect(URL::to('/'))->toStartWith('https://');
});
