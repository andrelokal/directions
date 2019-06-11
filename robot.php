<?php

//position X
$x = 0;

//position Y
$y = 0;

//direction for the robot
$direction = "N";

//new direction for the robot
$new_direction = $direction;

// robot movements
$movements = array();

//obstacles on the way
$obstacles = array();

/*
 * reading the file directions
 */
$rows = file('directions.txt');
foreach ($rows as $row) {
    $arr = explode(' ', $row);
    $k = trim($arr[0]);
    $v = trim($arr[1]);
    if (!preg_match('/^[0-9]*$/', $k) && count($movements) <= 10000) {
        $movements[][$k] = $v;
    } else {
        if (count($obstacles) <= 10) {
            $obstacles[$k] = $v;
        }
    }

}

/**
 * @param $x
 * @param $y
 * @param $arrayObs
 * @return bool
 */
function searchObstacle($x, $y, $arrayObs)
{
    foreach ($arrayObs as $key => $value) {
        if ($x == $key && $y == $value) {
            return true;
        }
    }
    return false;
}

/*
 * processing the rows
 */
foreach ($movements as $kr => $vr) {
    foreach ($vr as $k => $v) {
        if ($k == 'M' && $v <= 10) { //movement
            switch ($direction) {
                case 'N':
                    $new_value = $y + $v;
                    for ($y; $y <= $new_value; $y++) {
                        if (searchObstacle($x, $y, $obstacles)) {
                            break;
                        }
                    }
                    $y = $y - 1;
                    break;
                case 'E':
                    $new_value = $x + $v;
                    for ($x; $x <= $new_value; $x++) {
                        if (searchObstacle($x, $y, $obstacles)) {
                            break;
                        }
                    }
                    $x = $x - 1;
                    break;
                case 'S':
                    $new_value = $y - $v;
                    for ($y; $y >= $new_value; $y--) {
                        if (searchObstacle($x, $y, $obstacles)) {
                            break;
                        }
                    }
                    $y = $y + 1;
                    break;
                case 'W':
                    $new_value = $x - $v;
                    for ($x; $x >= $new_value; $x--) {
                        if (searchObstacle($x, $y, $obstacles)) {
                            break;
                        }
                    }
                    $x = $x + 1;
                    break;
            }
            $array_result[] = sqrt((($x - 0) * ($x - 0)) + (($y - 0) * ($y - 0)));
            $array_position[] = "($x,$y)";
        } else { //rotation
            if ($k == 'R') { //right
                switch ($direction) {
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
            }
            if ($k == 'L') { //left
                switch ($direction) {
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
            $direction = $new_direction;
        }
    }
}
$unitDistance = max($array_result);
$key = array_search($unitDistance, $array_result);
echo "<br> maximum distance it ever got from (0, 0) is " . $array_position[$key];
echo "<br> ending at: ($x,$y)";
echo "<br>  roughly " . round($unitDistance, 2) . " units away ";
