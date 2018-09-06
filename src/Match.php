<?php
namespace Swiped\HandbalWebservice;

class Match extends AbstractItem
{
    /**
     * @var string
     */
    public $program_id;

    /**
     * Uniek ID van de wedstrijd
     * @var string
     */
    public $game_id;

    /**
     * @var int
     */
    public $year;

    /**
     * Datum van wedstrijd in YYYY-MM-DD formaat
     *
     * @var string
     */
    public $date;

    /**
     * Tijd van wedstrijd in HH:MM formaat
     * @var string
     */
    public $time;

    /**
     * @var string
     */
    public $home_team_name;

    /**
     * @var string
     */
    public $away_team_name;

    /**
     * @var string
     */
    public $htc_id;

    /**
     * @var string
     */
    public $atc_id;

    /**
     * @var string
     */
    public $class_name;

    /**
     * @var string
     */
    public $field;

    /**
     * @var string
     */
    public $facility_name;

    /**
     * @var string
     */
    public $facility_id;

    /**
     * @var array
     */
    public $facility;

    /**
     * @var int
     */
    public $match_officials;

    /**
     * @var string
     */
    public $poule_name;

    /**
     * @var string
     */
    public $home_team_id;

    /**
     * @var string
     */
    public $away_team_id;

    /**
     * @var string
     */
    public $date_short;

    public $home_score;

    public $away_score;

    public function getId()
    {
        return $this->game_id;
    }
}
