<?php

class Dog extends Animal
{
    protected $los = INF; //let it just be
    protected $sign = "D";

    public $saying = [  "Just wandering around.", "Woof-woof.",
                        "Being a dog.", "Has no idea what he's doing.",
                        "Being blind to mice problems.", "Just being a dog.",
                        "Chasing a bird in the sky", " ", " ", " ", " ",
                        "Barking at a tree.", "Has done nothing so far." ];

    public function __toString()
    {
        return parent::__toString() . " ".  $this->saying[array_rand($this->saying)];
    }

    public function move()
    {
        $this->getBestMove($this->getMoves());
    }

    protected function getMoves()
    {
        $move1 = new Movement($this->y, $this->x);
        $move2 = new Movement($this->y + 2, $this->x);
        $move3 = new Movement($this->y - 2, $this->x);
        $move4 = new Movement($this->y, $this->x + 2);
        $move5 = new Movement($this->y, $this->x - 2);
        $move6 = new Movement($this->y + 2, $this->x + 2);
        $move7 = new Movement($this->y - 2, $this->x - 2);
        $move8 = new Movement($this->y + 2, $this->x - 2);
        $move9 = new Movement($this->y - 2, $this->x + 2);
        $arrayMove = array( $move1, $move2, $move3, $move4, $move5, $move6, $move7, $move8, $move9 );

        return $arrayMove;
    }

    /* the best movement for a dog is just go to a random free cell.
     * if there is none around, then staying on the current one is the choice
     */
    protected function getBestMove(array $arrayMove)
    {
        $arrayMove = $this->map->getPossibilityOfMovement($arrayMove);
        if(count($arrayMove) != 1) {
            unset($arrayMove[0]);   //first move is to stand
        }
        $finalMove = $arrayMove[array_rand($arrayMove)];

        $this->makeMove($finalMove);
    }


}