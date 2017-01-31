<?php

class Battlefield
{
    const EMPTYCELL = ".";    //the name says it
    const TAKENCELL = "_";    //prevents animals from spawning in one cell

    protected $height;
    protected $width;
    protected $totalTurns;
    protected $animalList = [];
    public $arrayField = [];


    public function __construct($height, $width, $totalTurns)
    {
        $this->height = $height;
        $this->width = $width;
        $this->totalTurns = $totalTurns;
    }

    //adding new animals to an array and placing them randomly
    public function addAnimal(Animal $animal): void
    {
        $this->animalList[] = $animal;
        $animal->setMap($this);
        for ($i = 0; $i <= 100; $i++) {
            $y = rand(0, $this->height);
            $x = rand(0, $this->width);
            if ($this->arrayField[$y][$x] == Battlefield::EMPTYCELL) {
                $animal->setY($y);
                $animal->setX($x);
                $this->arrayField[$y][$x] = Battlefield::TAKENCELL;
                break;
            }
        }
    }

    // impl array_Search !!!!!!!!!!!!!!! IMP
    protected function removeAnimal(Animal $deadAnimal): void
    {
//        foreach($this->animalList as $key => $animal){
//            if($animal === $deadAnimal) {
//                unset($this->animalList[$key]);
//            }
//        }
        $key = array_Search($deadAnimal, $this->animalList);
        unset($this->animalList[$key]);
    }

    //visual map
    // IMP !!!!!!!!!!!!!! array_fill
    public function setField()
    {
        for ($i = 0; $i <= $this->height; $i++) {
            for ($j = 0; $j <= $this->width; $j++) {
                $this->arrayField[$i][] = Battlefield::EMPTYCELL;
            }
        }
    }

    public function fillWithAnimals(): void
    {
        foreach ($this->animalList as $animal) {
            $this->arrayField[$animal->y][$animal->x] = $animal->sign;
        }
    }
    //prints the current state of field IMP !!!!!!!!!!! implode
    public function printField(): void
    {
        for ($i = 0; $i <= $this->height; $i++) {
            foreach ($this->arrayField[$i] as $place) {
                print $place;
            }
            print PHP_EOL;
        }
    }
    //the first move is to stay still is always possible
    // have to implement the function to check ONE cell
    public function getPossibilityOfMovement(array $arrayMove)
    {
        foreach ($arrayMove as $i => $move) {
            if (isset($this->arrayField[$move->y][$move->x])) {
                if ($this->arrayField[$move->y][$move->x] != Battlefield::EMPTYCELL AND $i != 0) {  //why AND here?
                    unset($arrayMove[$i]);
                }
            } else {
                unset($arrayMove[$i]);
            }
        }
        return $arrayMove;
    }

    //calculate distance between two objects
    // IMP !!!!!!!!! min max
    public static function getDistance($y, $x, $y2, $x2)
    {
        $distanceY = abs($y - $y2);
        $distanceX = abs($x - $x2);
        if($distanceY>=$distanceX){
            return $distanceY;
        } else {
            return $distanceX;
        }
    }
    //change it to remove mouse and mov cat
    public function eating(Cat $cat, Mouse $mouse)
    {
        $mouse->getMap()->arrayField[$mouse->getY()][$mouse->getX()] = $cat->getAltSign();
        $cat->getMap()->arrayField[$cat->getY()][$cat->getX()] = Battlefield::EMPTYCELL;
        $cat->setY($mouse-) = ->y;
        $cat->x = $mouse->x;
        self::removeAnimal($mouse);
        $cat->isAsleep = TRUE;
        $cat->killed++;

    }

    public function findNearestAnimal(Animal $centreAnimal, $id)
    {
        $nearestCat = NULL;
        $nearestMouse = NULL;
        $nearestDog = NULL;
        $minDistance1 = INF;
        $minDistance2 = INF;
        $minDistance3 = INF;
        foreach ($this->animalList as $animal) {
            if ($animal instanceof Cat AND $animal != $centreAnimal) {
                $distance = self::getDistance($animal->y, $animal->x, $centreAnimal->y, $centreAnimal->x);
                if ($distance <= $centreAnimal->los AND $distance < $minDistance1) {
                    $minDistance1 = $distance;
                    $nearestCat = $animal;
                }
            }
            if($animal instanceof Mouse AND $animal != $centreAnimal) {
                $distance = self::getDistance($animal->y, $animal->x, $centreAnimal->y, $centreAnimal->x);
                if ($distance <= $centreAnimal->los AND $distance < $minDistance2) {
                    $minDistance2 = $distance;
                    $nearestMouse = $animal;
                }
            }
            if($animal instanceof Dog AND $animal != $centreAnimal) {
                $distance = self::getDistance($animal->y, $animal->x, $centreAnimal->y, $centreAnimal->x);
                if ($distance <= $centreAnimal->los AND $distance < $minDistance3) {
                    $minDistance3 = $distance;
                    $nearestDog = $animal;
                }
            }
        }

        switch($id):
            case 1:
                return $nearestMouse;
                break;
            case 2:
                return $nearestCat;
                break;
            case 3:
                return $nearestDog;
                break;
            default:
                return NULL;
                break;
        endswitch;
    }


    //calculates the distance to the edges of the map
    public function measureDistanceToEdges($y, $x)
    {
        $distanceY = 0;
        $distanceX = 0;
        if($y >= $this->height/2) {
            $distanceY = $this->height - $y;
        } else {
            $distanceY = $y - 1;
        }

        if($x >= $this->width/2) {
            $distanceX = $this->width - $x;
        } else {
            $distanceX = $x - 1;
        }

        $edgeDisntances = [
            "y" => $distanceY,
            "x" => $distanceX
        ];
        return $edgeDisntances;

    }

    //picking the best move when the mouse has spotted the cat and tries to escape
    public function pickTheBestChoice(Mouse $mouse, Cat $cat, Movement $move)
    {
        $movePoints = 0;
        /*
         * checks if the new position has increased the distance between the mouse and the cat
         * as it is very important, 30 points are awarded
         */
        $currentDistance = self::getDistance($mouse->y, $mouse->x, $cat->y, $cat->x);
        $newDistance = self::getDistance($move->y, $move->x, $cat->y, $cat->x);
        if($newDistance > $currentDistance)  { $movePoints += 50; }
        if($newDistance < $currentDistance)  { $movePoints += 0; }

        /*
         * checks if the new position is farther from the edges
         * if farther, 10 points are awarded
         */
        $currentEdgeDistance = self::measureDistanceToEdges($mouse->y, $mouse->x);
        $newEdgeDistance = self::measureDistanceToEdges($move->y, $move->x);
        if(array_sum($newEdgeDistance) > array_sum($currentEdgeDistance)) { $movePoints += 30; }

        /*
         * points are awarded to the mouse if it moves diagonally
         * (as the distance is the same as in row but it is harder to catch)
         * in other words, the mouse is DODGING
         */
        if($move->y != $cat->y AND $move->x != $cat->x)  { $movePoints += 15; }
        //даю оче много поинтов за то, чтоб прижаться к псу, ЕСЛИ он рядом.
        // НЕ задаю целью мышек бегать за псом.
        /*
         * many points are awarded for getting as close as possible to a dog
         * persuing the dog isn't the mice's goal
         */
        $nearestDog = $mouse->map->findNearestAnimal($mouse, 3);
        if($nearestDog != NULL) {
            $newDistanceToTheDog = self::getDistance($move->y, $move->x, $nearestDog->y, $nearestDog->x);
            if ($newDistanceToTheDog == 1) { $movePoints += 70; }
        }

        return $movePoints;
    }

    /*
     * choosing the best move for a cat.
     * the distance should get shorter
     * if the move puts cat inline with a mouse it is considered to be better
     * the cat is afraid of the dog and does not choose the cells around it
     *
     * if the distance equals to one, it catches and eats the mouse
     */
    public function huntDown(Cat $cat, Mouse $mouse, Movement $move)
    {
        $movePoints = 0;
        $codeZero = -1;
        $nearestDog = $cat->map->findNearestAnimal($cat, 3);
        $distanceBetweenDogAndMouse = self::getDistance($mouse->y, $mouse->x, $nearestDog->y, $nearestDog->x);
        if($nearestDog != NULL){
            $newDistanceToTheDog = self::getDistance($move->y, $move->x, $nearestDog->y, $nearestDog->x);
        } else {
            $newDistanceToTheDog = INF;
        }
        $nearestFriendMouse = $mouse->map->findNearestAnimal($mouse, 1);
        if($nearestFriendMouse != NULL) {
            $distanceToFriendMouse = self::getDistance($nearestFriendMouse->y, $nearestFriendMouse->x, $mouse->y, $mouse->x );
        } else {
            $distanceToFriendMouse = INF;
        }
        $currentDistance = self::getDistance($cat->y, $cat->x, $mouse->y, $mouse->x);
        if($currentDistance == 1 AND $distanceBetweenDogAndMouse > 1 AND $distanceToFriendMouse != 1){
            return $codeZero;
        }
        $newDistance = self::getDistance($move->y, $move->x, $mouse->y, $mouse->x);
        if($newDistance < $currentDistance) { $movePoints += 40; }

        if($move->y == $mouse->y OR $move->x == $mouse->x) { $movePoints += 10; }
        if($newDistanceToTheDog == 1){ $movePoints -= 100; }

        return $movePoints;
    }


    public function letTheGameBegin()
    {
        $this->fillFieldWithAnimals();
        for ($i = 0; $i <= $this->totalTurns; $i++) {
            $this->printField();
            echo PHP_EOL;
            echo "Dogs 'team': " . PHP_EOL;
            foreach ($this->animalList as $animal) {
                if ($animal instanceof Dog) {
                    echo $animal . PHP_EOL .
                        $animal->go();
                }
            }

            echo PHP_EOL;
            echo "Mice team: " . PHP_EOL;
            foreach ($this->animalList as $animal) {
                if($animal instanceof Mouse){
                    echo $animal . PHP_EOL;
                    $animal->go();
                    $animal->turnsAlive++;
                }
            }
            echo PHP_EOL;
            echo "Cats team: " . PHP_EOL;
            foreach ($this->animalList as $animal) {
                if($animal instanceof Cat){
                    echo $animal;
                    if($animal->isAsleep == TRUE){
                        echo " ". $animal->name . " is sleeping at the moment." . PHP_EOL;
                    } else {
                        echo PHP_EOL;
                    }
                    $animal->go();

                }

            }
            echo PHP_EOL;
        }
    }

}