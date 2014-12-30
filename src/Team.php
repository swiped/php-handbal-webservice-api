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
        return $this->api->getProgram($full, $this->getId());
    }

    /**
     * @param  int  Page
     * @param  boolean Full response
     * @return Match[]
     * @throws InvalidResponseException
     */
    public function getResults($page = 0, $full = false)
    {
        return $this->api->getResults($page, $full, $this->getId());
    }

    /**
     * @return Standing[]
     * @throws InvalidResponseException
     */
    public function getStandings()
    {
        return $this->api->getStandings($this->getId());
    }
}
