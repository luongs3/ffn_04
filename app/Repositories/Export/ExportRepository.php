<?php
namespace App\Repositories\Export;

use Excel;
use App\Repositories\BaseRepository;

class ExportRepository extends BaseRepository implements ExportRepositoryInterface
{
    public function export($subject)
    {
        $model = $this->getModel($subject);
        $data = $model::all();
        Excel::create($subject, function ($excel) use ($data) {
            $excel->sheet('sheet_name', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->export('csv');
    }

    public function getModel($subject)
    {
        switch ($subject) {
            case 'leagues':
                return 'App\Models\League';
            case 'categories':
                return 'App\Models\Category';
            case 'league-matches':
                return 'App\Models\LeagueMatch';
            case 'matches':
                return 'App\Models\Match';
            case 'match-events':
                return 'App\Models\MatchEvent';
            case 'messages':
                return 'App\Models\Message';
            case 'players':
                return 'App\Models\Player';
            case 'posts':
                return 'App\Models\Post';
            case 'ranks':
                return 'App\Models\Rank';
            case 'seasons':
                return 'App\Models\Season';
            case 'teams':
                return 'App\Models\Team';
            case 'users':
                return 'App\Models\User';
            case 'user-bets':
                return 'App\Models\UserBet';
            default:
                return null;
        }
    }
}
