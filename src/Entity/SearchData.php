<?php

namespace App\Entity;


use App\Entity\Vol;
use DateTime;

class SearchData
{
    private $id;

     /**
     * @var int
     */
    public $page = 1;

     /**
     * @var null|Datetime
     */
    public $depart = null;

    /**
     * @var null|Datetime
     */
    public $retour =null ;

    /**
     * @var string
     */
    public $q = '';

    /**
     * @var string
     */
    public $lieuDepart = '';

    /**
     * @var Vol[]
     */
    public $vols = [];

    /**
     * @var null|integer
     */
    public $max;

    /**
     * @var null|integer
     */
    public $min;

    /**
     * @var boolean
     */
    public $affaire = false;
    
    /**
     * @var boolean
     */
    public $economie = false;

    /**
     * @var boolean
     */
    public $promotion = false;

     /**
     * @var boolean
     */
    public $pays ;
     /**
     * @var string
     */
    public $maurice ;
     /**
     * @var string
     */
    public $egypte ;
     /**
     * @var string
     */
    public $croatie ;
    /**
     * @var string
     */
    public $espagne ;
    /**
     * @var string
     */
    public $france ;

    public function getId(): ?int
    {
        return $this->id;
    }
}
