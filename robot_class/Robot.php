<?php

class Robot
{
    private $direction;

    private $path_memory_y = array(0);

    private $path_memory_x = array(0);

    private $obstacle_memory = array(0);

    /**
     * Robot constructor.
     * @param $direction
     */
    function __construct($direction = 'N', $array_obstacle = array())
    {
        $this->setDirection($direction);
        $this->setObstacleMemory($array_obstacle);
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;
    }

    /**
     * @param array $obstacle_memory
     */
    public function setObstacleMemory($obstacle_memory)
    {
        $this->obstacle_memory = $obstacle_memory;
    }

    /**
     * @return array
     */
    public function getObstacleMemory()
    {
        return $this->obstacle_memory;
    }

    /**
     * @param array $path_memory_x
     */
    public function setPathMemoryX($path_memory_x)
    {
        array_push($this->path_memory_x, $path_memory_x);
    }

    /**
     * @param array $path_memory_y
     */
    public function setPathMemoryY($path_memory_y)
    {
        array_push($this->path_memory_y, $path_memory_y);
    }

    /**
     * @return array
     */
    public function getPathMemoryX()
    {
        return $this->path_memory_x;
    }

    /**
     * @return array
     */
    public function getPathMemoryY()
    {
        return $this->path_memory_y;
    }

    /**
     * @param $unit
     */
    public function walkTo($unit)
    {
        $x = end($this->getPathMemoryX());
        $y = end($this->getPathMemoryY());

        switch ($this->getDirection()) {
            case 'N':
                $new_value = $y + $unit;
                for ($y; $y <= $new_value; $y++) {
                    if ($this->searchObstacle($x, $y)) {
                        break;
                    }
                }
                $y = $y - 1;
                break;
            case 'E':
                $new_value = $x + $unit;
                for ($x; $x <= $new_value; $x++) {
                    if ($this->searchObstacle($x, $y)) {
                        break;
                    }
                }
                $x = $x - 1;
                break;
            case 'S':
                $new_value = $y - $unit;
                for ($y; $y >= $new_value; $y--) {
                    if ($this->searchObstacle($x, $y)) {
                        break;
                    }
                }
                $y = $y + 1;
                break;
            case 'W':
                $new_value = $x - $unit;
                for ($x; $x >= $new_value; $x--) {
                    if ($this->searchObstacle($x, $y)) {
                        break;
                    }
                }
                $x = $x + 1;
                break;
        }
        $this->setPathMemoryX($x);
        $this->setPathMemoryY($y);
    }

    /**
     * @param $x
     * @param $y
     * @param $array_obstacles
     * @return bool
     */
    public function searchObstacle($x, $y)
    {
        foreach ($this->getObstacleMemory() as $key => $value) {
            if ($x == $key && $y == $value) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $command
     */
    public function swapTo($command)
    {
        if ($command == 'R') { //right
            switch ($this->getDirection()) {
                case 'N':
                    $new_direction = 'E';
                    break;
                case 'E':
                    $new_direction = 'S';
                    break;
                case 'S':
                    $new_direction = 'W';
                    break;
                case 'W':
                    $new_direction = 'N';
                    break;
            }
        } elseif ($command == 'L') { //left
            switch ($this->getDirection()) {
                case 'N':
                    $new_direction = 'W';
                    break;
                case 'W':
                    $new_direction = 'S';
                    break;
                case 'S':
                    $new_direction = 'E';
                    break;
                case 'E':
                    $new_direction = 'N';
                    break;
            }
        }
        $this->setDirection($new_direction);

    }

    /**
     * print the statistics on the robot path
     */
    public function processResults()
    {

        $x = $this->getPathMemoryX();
        $y = $this->getPathMemoryY();

        for ($i = 0; $i <= count($x); $i++) {
            $array_result[] = sqrt((($x[$i] - 0) * ($x[$i] - 0)) + (($y[$i] - 0) * ($y[$i] - 0)));
            $array_position[] = "($x[$i],$y[$i])";
        }

        $final_x = end($x);
        $final_y = end($y);

        $unit_distance = max($array_result);
        $key = array_search($unit_distance, $array_result);

        
        echo "maximum distance it ever got from (0, 0) is " . $array_position[$key];
        echo "<br>";
        echo "ending at: ($final_x,$final_y)";
        echo "<br>";
        echo "roughly " . round($unit_distance, 2) . " units away ";

    }


}
