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
use App\Repositories\Message\MessageRepository;
use App\Repositories\Message\MessageRepositoryInterface;
use App\Repositories\Export\ExportRepository;
use App\Repositories\Export\ExportRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\AdminMessage\AdminMessageRepository;
use App\Repositories\AdminMessage\AdminMessageRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(LeagueRepositoryInterface $leagueRepository)
    {
        view()->share('layout', 'admin.layout.layout');
        view()->share('clientLayout', 'layout.layout');
        view()->share('placeHolders', config('common.place_holders'));
        $leagues = $leagueRepository->all();
        view()->share('leagues', $leagues);
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
        App::bind(MessageRepositoryInterface::class, MessageRepository::class);
        App::bind(ExportRepositoryInterface::class, ExportRepository::class);
        App::bind(CommentRepositoryInterface::class, CommentRepository::class);
        App::bind(AdminMessageRepositoryInterface::class, AdminMessageRepository::class);
    }

    public function provides()
    {
        return [UserRepositoryInterface::class];
    }
}
