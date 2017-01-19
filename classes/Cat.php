<?php

class Cat extends Animal
{
    protected $sign = "C";
    protected $altSign = "@";   //alternative sign
    protected $los = INF;
    protected $isAsleep = false;
    protected $tireLevel = 0;
    protected $daysSlept = 0;
    protected $killed = 0;

    public function getAltSign(): string
    {
        return $this->altSign;
    }

    public function __toString()
    {
        return parent::__toString()  . "Has eaten " . $this->killed . " mice.";
    }

    //main movement function
    public function move(): void
    {
        //waking up
        if($this->daysSlept == 1){
            $this->isAsleep = false;
            $this->tireLevel = 0;
            $this->daysSlept = 0;
            $this->map->arrayField[$this->y][$this->x] = $this->sign;
        }
        //the actual move. if the cat sleeps it counts days
        if($this->isAsleep == true){
            $this->tireLevel = 0;
            $this->daysSlept++;
            $this->map->arrayField[$this->y][$this->x] = $this->altSign;
        } else {
            $this->getBestMove($this->getMoves());
            $this->tireLevel++;
        }
        //checks tiredness, if 8 then sleeps
        if($this->tireLevel == 8){
            $this->isAsleep = true;
            $this->tireLevel = 0;
            $this->map->arrayField[$this->y][$this->x] = $this->altSign;
        }
    }

    protected function getMoves(): array
    {
//        $move1 = new Movement($this->y, $this->x);
        $move2 = new Movement($this->y + 1, $this->x);
        $move3 = new Movement($this->y - 1, $this->x);
        $move4 = new Movement($this->y, $this->x + 1);
        $move5 = new Movement($this->y, $this->x - 1);
//        $move6 = new Movement($this->y + 1, $this->x + 1);
//        $move7 = new Movement($this->y - 1, $this->x - 1);
        $move8 = new Movement($this->y + 1, $this->x - 1);
//        $move9 = new Movement($this->y - 1, $this->x + 1);
        $arrayMove = array( $move1, $move2, $move3, $move4, $move5, $move6, $move7, $move8, $move9 );

        for ($i = -1, $j = -1; $i < 1; $i++, $j++ ) {
            $arrayMove[] = new Movement($this->y + $i, $this->x + $j);
        }
        for ($i = -1, $j = +1; $i < 1; $i++, $j-- ) {
            $arrayMove[] = new Movement($this->y + $i, $this->x + $j);
        }

        return $arrayMove;
    }

    /*
     * picking the best move for a cat. as it sees all, it is much easier.
     * checks if the cell is free, looks for the nearest mouse and runs to it
     * if the distance between them is one, then eats it
     */
    protected function getBestMove(array $arrayMove)
    {
        $arrayMove = $this->map->getPossibilityOfMovement($arrayMove);

        $nearestMouse = $this->map->findNearestAnimal($this, 1);
        if($nearestMouse == NULL){
            $finalMove = $arrayMove[array_rand($arrayMove)];
        } else {
            $maxPoints = -INF;
            foreach ($arrayMove as $move) {
                $points = $this->map->huntDown($this, $nearestMouse, $move);
                if ($points == -1) {                                       //активируем код ДЗЕРО
                    $this->map->eating($this, $nearestMouse);
                    return;
                } elseif ($points > $maxPoints) {
                    $maxPoints = $points;
                    $finalMove = $move;
                }
            }

        }
        $this->makeMove($finalMove);
    }
}