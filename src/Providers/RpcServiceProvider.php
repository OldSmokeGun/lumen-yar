<?php

namespace oldSmokeGun\Rpc\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RpcServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Route::addRoute(['GET', 'POST'], '/rpc/{service}', 'oldSmokeGun\Rpc\Server\Server@handle');
    }
}