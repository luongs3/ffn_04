<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use App\Repositories\Player\PlayerRepositoryInterface;
use App\Repositories\Player\PlayerRepository;
use App\Repositories\Team\TeamRepositoryInterface;
use App\Repositories\Team\TeamRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\League\LeagueRepositoryInterface;
use App\Repositories\League\LeagueRepository;
use App\Repositories\Season\SeasonRepositoryInterface;
use App\Repositories\Season\SeasonRepository;
use App\Repositories\Rank\RankRepositoryInterface;
use App\Repositories\Rank\RankRepository;
use App\Repositories\Match\MatchRepositoryInterface;
use App\Repositories\Match\MatchRepository;
use App\Repositories\MatchEvent\MatchEventRepositoryInterface;
use App\Repositories\MatchEvent\MatchEventRepository;
use App\Repositories\UserBet\UserBetRepositoryInterface;
use App\Repositories\UserBet\UserBetRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('layout', 'admin.layout.layout');
        view()->share('clientLayout', 'layout.layout');
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
        App::bind(UserRepositoryInterface::class, UserRepository::class);
        App::bind(LeagueRepositoryInterface::class, LeagueRepository::class);
        App::bind(SeasonRepositoryInterface::class, SeasonRepository::class);
        App::bind(RankRepositoryInterface::class, RankRepository::class);
        App::bind(MatchRepositoryInterface::class, MatchRepository::class);
        App::bind(MatchEventRepositoryInterface::class, MatchEventRepository::class);
        App::bind(UserBetRepositoryInterface::class, UserBetRepository::class);
    }
}
