<?php

class Mouse extends Animal {
    /*
     * mice don't get preset lines of sight
     * so it is possible for them to have their individual traits
     * making some of them more 'blind'
     * same thing with signs
     */
    protected $turnsAlive = 0;

    // ????????? do i need it
    public function getTurnsAlive(): int
    {
        return $this->turnsAlive;
    }

    public function __toString()
    {
        return parent::__toString() . " Alive for " . $this->turnsAlive . " turns.";
    }

    public function __construct($name, $los, $sign = 'm')
    {
        parent::__construct($name);
        $this->los = $los;
        $this->sign = $sign;
    }


    //the main function of making turns
    public function move(): void
    {
        $this->getBestMove($this->getMoves());
    }

    /*
     * possible basic moves
     * returns an array with all moves inside the field
     */
    protected function getMoves(): array
    {
        $move1 = new Movement($this->y, $this->x);
        $move2 = new Movement($this->y + 1, $this->x);
        $move3 = new Movement($this->y - 1, $this->x);
        $move4 = new Movement($this->y, $this->x + 1);
        $move5 = new Movement($this->y, $this->x - 1);
        $arrayMove = array( $move1, $move2, $move3, $move4, $move5 );

        return $arrayMove;
    }

    //this function decides which move out of all to make
    protected function getBestMove(array $arrayMove): void
    {
        //check if it is possible to perform a movement to this place
        $arrayMove = $this->map->getPossibilityOfMovement($arrayMove);

        /*
         * look for the nearest cat in los, if there is none, the mouse makes its move.
         * otherwise the function of the estimation of next move is launched
         */
        $nearestCat = $this->map->findNearestAnimal($this, 2);
        switch($nearestCat) {
            case null:
                $finalMove = $arrayMove[array_rand($arrayMove)];    //random movement
                break;
            case true:
                $maxPoints = -INF;
                foreach ($arrayMove as $move) {
                    $points = $this->map->pickTheBestChoice($this, $nearestCat, $move);
                    if ($points > $maxPoints) {
                        $maxPoints = $points;
                        $finalMove = $move;
                    }
                }
                break;
        }

        $this->makeMove($finalMove);
    }


}