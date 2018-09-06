<?php
namespace Swiped\HandbalWebservice;

class Ranking extends AbstractItem
{
    public $position;
    public $team_id;
    public $team_name;
    public $played;
    public $points;
    public $won;
    public $lost;
    public $draw;
    public $sport;
    public $serie;
    public $goals_for;
    public $goals_against;
    public $difference;
    public $penalties;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->team_id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->team_name;
    }
}
