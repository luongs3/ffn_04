<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use App\Repositories\Player\PlayerRepositoryInterface;
use App\Repositories\Player\PlayerRepository;
use App\Repositories\Team\TeamRepositoryInterface;
use App\Repositories\Team\TeamRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('layout', 'layout.layout');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(PlayerRepositoryInterface::class, PlayerRepository::class);
        App::bind(TeamRepositoryInterface::class, TeamRepository::class);
    }
}
