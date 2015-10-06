<?php
namespace KNKV\Webservice;

class Team extends AbstractItem
{
    /**
     * @var string
     */
    public $team_id;

    /**
     * @var string
     */
    public $team_name;

    /**
     * @var string
     */
    public $category;

    /**
     * @var string
     */
    public $season_year;

    /**
     * @var string
     */
    public $season_serie;

    /**
     * @var string
     */
    public $club_id;

    /**
     * @var string
     */
    public $poule_id;

    /**
     * @var string
     */
    public $sport_id;

    /**
     * @var string
     */
    public $class_id;

    /**
     * @var string
     */
    public $team_id_group;

    /**
     * @var string
     */
    public $url;


    /** @var Api */
    protected $api;

    /**
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

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
    public function getIdGroup()
    {
        return $this->team_id_group;
    }

    /**
     * @return array
     */
    public function getIds()
    {
        return explode(',', $this->getIdGroup());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->team_name;
    }

    /**
     * @param  boolean Full response
     * @return Match[]
     * @throws InvalidResponseException
     */
    public function getProgram($full = false)
    {
        return $this->api->getProgram($full, $this->getIdGroup());
    }

    /**
     * @param  boolean Full response
     * @param  int  Page
     * @return Match[]
     * @throws InvalidResponseException
     */
    public function getResults($full = false, $page = 0)
    {
        return $this->api->getResults($full, $page, $this->getIdGroup());
    }

    /**
     * @return Standing[]
     * @throws InvalidResponseException
     */
    public function getStandings()
    {
        return $this->api->getStandings($this->getIdGroup());
    }
}
