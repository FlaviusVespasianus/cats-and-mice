<?php

class Movement {

    protected $x;
    protected $y;

    public function getX()
    {
        return $this->x;
    }
    public function getY()
    {
        return $this->y;
    }

    public function __construct($y, $x){
        $this->y = $y;
        $this->x = $x;
    }

}