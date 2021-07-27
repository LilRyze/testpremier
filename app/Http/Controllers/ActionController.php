<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TeamService;
use App\Services\ResultService;

class ActionController extends Controller
{
    public function __construct(
        TeamService $teamService,
        ResultService $resultService
    ) {
        $this->team   = $teamService;
        $this->result = $resultService;
    }

    public function getTeams()
    {
        return($this->team->all());
    }

    public function getResults()
    {
        return($this->result->all());
    }

    public function playOne(Request $request)
    {
        $teams = $this->getTeams();
        $week = $request->get('currentWeek');

        foreach ($teams as $team1) {
            foreach ($teams as $team2) {
                $results = $this->getResults();
                if(empty($results)) {
                    if($team1 !== $team2) {
                        $this->playGame($team1, $team2, $week);
                    }
                }

                if($team1 !== $team2) {
                    $results = $this->getResults();
                    
                    for($week; $week <= 6; $week++) {
                        $collection = collect($results);
                        $collection = $collection->map(function ($item, $key) {
                            return $item->week;
                        });
                    
                        foreach($results as $result) {
                            if($collection->contains($week)) {
                                if(($team1->id !== $result->home_id && $team2->id !== $result->guest_id) && ($team2->id !== $result->home_id && $team1->id !== $result->guest_id)) {
                                    $this->playGame($team1, $team2, $week);
                                    break;
                                }
                            } else {
                                if(($team1->id !== $result->home_id && $team2->id !== $result->guest_id) && ($team2->id !== $result->home_id && $team1->id !== $result->guest_id)) {
                                    $this->playGame($team1, $team2, $week + 1);
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function playGame($team1, $team2, $currentWeek)
    {
        $teamScore1 = rand(0, 10);
        $teamScore2 = rand(0, 10);
        $score = 0;

        $parametersOne = [
            'week' => $currentWeek,
            'guest_id' => $team1->id,
            'home_id' => $team2->id,
            'guest_score' => $teamScore1,
            'home_score' => $teamScore2,
        ];

        $this->result->create($parametersOne);
        $team1 = $this->team->find($team1->id);
        $team2 = $this->team->find($team2->id);
        if ($teamScore1 > $teamScore2) {
            $played1 = $team1->played;
            $wins1 = $team1->wins;
            $score1 = $team1->pts;
            $gd1 = $team1->gd;

            $this->team->update($team1->id, [
                'played' => $played1 + 1,
                'wins' => $wins1 + 1,
                'pts' => $score1 + 3,
                'gd' => $gd1 + $teamScore1 - $teamScore2,
                'winrate' => ($wins1 * 100) / ($played1 + 1)
            ]);

            $played2 = $team2->played;
            $loses2 = $team2->loses;
            $gd2 = $team2->gd;
            $wins2 = $team2->winrate;

            $this->team->update($team2->id, [
                'played' => $played2 + 1,
                'loses' => $loses2 + 1,
                'gd' => $gd2 + $teamScore2 - $teamScore1,
                'winrate' => ($wins2 * 100) / ($played2 + 1)
            ]);
            
        } elseif ($teamScore1 == $teamScore2) {
            $played1 = $team1->played;
            $draws1 = $team1->draws;
            $wins1 = $team1->wins;
            $score1 = $team1->pts;
            $gd1 = $team1->gd;

            $this->team->update($team1->id, [
                'played' => $played1 + 1,
                'draws' => $draws1 + 1,
                'pts' => $score1 + 1,
                'winrate' => ($wins1 * 100) / ($played1 + 1)
            ]);

            $played2 = $team2->played;
            $draws2 = $team2->draws;
            $score2 = $team2->pts;
            $wins2 = $team2->wins;
            $gd2 = $team2->gd;

            $this->team->update($team2->id, [
                'played' => $played2 + 1,
                'draws' => $draws2 + 1,
                'pts' => $score2 + 1,
                'winrate' => ($wins2 * 100) / ($played2 + 1)
            ]);
        } else {
            $played2 = $team2->played;
            $wins2 = $team2->wins;
            $score2 = $team2->pts;
            $gd2 = $team2->gd;

            $this->team->update($team2->id, [
                'played' => $played2 + 1,
                'wins' => $wins2 + 1,
                'pts' => $score2 + 3,
                'gd' => $gd2 + $teamScore2 - $teamScore1,
                'winrate' => ($wins2 * 100) / ($played2 + 1)
            ]);

            $played1 = $team1->played;
            $loses1 = $team1->loses;
            $gd1 = $team1->gd;
            $wins1 = $team1->winrate;

            $this->team->update($team1->id, [
                'played' => $played1 + 1,
                'loses' => $loses1 + 1,
                'gd' => $gd1 + $teamScore1 - $teamScore2,
                'winrate' => ($wins1 * 100) / ($played1 + 1)
            ]);
        }
    }
}
