<?php
namespace KNKV\Webservice;

class Poule extends AbstractItem
{
    public $poule_id;
	public $poule_name;
	public $sport;

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->poule_id;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->poule_name;
	}
}
