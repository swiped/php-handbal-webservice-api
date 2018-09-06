<?php
namespace Swiped\HandbalWebservice;

class Standing extends AbstractItem
{
    /**
     * @var Poule
     */
    public $poule;

    /**
     * @var Ranking[]
     */
    public $lines;
}
