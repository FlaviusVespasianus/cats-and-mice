<?php

abstract class Animal {
    protected $name;
    protected $x;      //x coordinate
    protected $y;      //y coordinate
    protected $map;    //animals analog of $field
    protected $sign;   //sign on map
    protected $los;    //line of sight

    public function getName()
    {
        return $this->name;
    }
    public function getX()
    {
        return $this->x;
    }
    public function getY()
    {
        return $this->y;
    }
    public function getMap()
    {
        return $this->map;
    }
    public function getSign()
    {
        return $this->sign;
    }
    public function getLos()
    {
        return $this->los;
    }

    public function setX($x)
    {
        $this->x = $x;
    }
    public function setY($y)
    {
        $this->y = $y;
    }

    abstract protected function getMoves();
    abstract protected function getBestMove(array $arrayMove);
    abstract public function move();



    public static function create() {

    }

    //for the statistics output
    public function __toString()
    {
        return $this->sign . ". " . $this->name
        . "'s position: " . "X: ". $this->x . " Y: ". $this->y . ".";
    }

    public function __construct($name, Battlefield $field)
    {
        $this->name = $name;
        $this->map = $field;
    }

    /*
     * has to be REDONE
     *
     *
     *
     */
    //every animal has got its own copy of the map so it is possible to address $fields values
    /*
    public function setMap(Battlefield $field)
    {
        $this->map = $field;
    }
    */
    
    //make turn (visual work)
    public function makeMove(Movement $move): void
    {
        $this->map->arrayField[$this->y][$this->x] = Battlefield::EMPTYCELL;
        $this->map->arrayField[$move->getY()][$move->getX()] = $this->sign;
        $this->y = $move->getY();
        $this->x = $move->getX();

    }
}
