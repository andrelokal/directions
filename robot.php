<?php

//position X
$x = 0;

//position Y
$y = 0;

//direction
$d = "N";

//new direction
$nd = $d;

/*
 * reading the file
 */
$lines = file('directions.txt');

foreach ($lines as $array) {
    $arr = explode(' ', $array);
    $k = trim($arr[0]);
    $v = trim($arr[1]);
    $cmdline[][$k] = $v;

}

foreach ($cmdline as $key => $value) {
    foreach ($value as $cmd => $pos) {
        if (is_string($cmd)) {
            $MV[][$cmd] = $pos; //movement
        } else {
            $obs[$cmd] = $pos; //obstacle
        }
    }
}

/*
 * processing the rows
 */
foreach ($MV as $kr => $vr) {
    foreach ($vr as $k => $v) {

        if ($k == 'M') { //movement
            switch ($d) {
                case 'N':
                    $nv = $y + $v;
                    for ($y; $y <= $nv; $y++) {
                        foreach ($obs as $key => $value) {
                            if ($x == $key && $y == $value) {
                                break 2;
                            }
                        }
                    }
                    $y = $y - 1;
                    $rx[] = $x;
                    $ry[] = $y;
                    break;
                case 'E':
                    $nv = $x + $v;
                    for ($x; $x <= $nv; $x++) {
                        foreach ($obs as $key => $value) {
                            if ($x == $key && $y == $value) {
                                break 2;
                            }
                        }
                    }
                    $x = $x - 1;
                    $rx[] = $x;
                    $ry[] = $y;
                    break;
                case 'S':
                    $nv = $y - $v;
                    for ($y; $y >= $nv; $y--) {
                        foreach ($obs as $key => $value) {
                            if ($x == $key && $y == $value) {
                                break 2;
                            }
                        }
                    }
                    $y = $y + 1;
                    $rx[] = $x;
                    $ry[] = $y;
                    break;
                case 'W':
                    $nv = $x - $v;
                    for ($x; $x >= $nv; $x--) {
                        foreach ($obs as $key => $value) {
                            if ($x == $key && $y == $value) {
                                break 2;
                            }
                        }
                    }
                    $x = $x + 1;
                    $rx[] = $x;
                    $ry[] = $y;
                    break;
            }

        } else { //rotation
            if ($k == 'R') { //right
                switch ($d) {
                    case 'N':
                        $nd = 'E';
                        break;
                    case 'E':
                        $nd = 'S';
                        break;
                    case 'S':
                        $nd = 'W';
                        break;
                    case 'W':
                        $nd = 'N';
                        break;
                }
            }

            if ($k == 'L') { //left
                switch ($d) {
                    case 'N':
                        $nd = 'W';
                        break;
                    case 'W':
                        $nd = 'S';
                        break;
                    case 'S':
                        $nd = 'E';
                        break;
                    case 'E':
                        $nd = 'N';
                        break;
                }
            }

            $d = $nd;

        }
    }
}
array_multisort($rx, $ry);
$rx = end($rx);
$ry = end($ry);
$unitDistance = sqrt((($rx - 0) * ($rx - 0)) + (($ry - 0) * ($ry - 0)));

echo "<br> maximum distance it ever got from (0, 0) is (" . $rx . "," . $ry . ")";
echo "<br> ending at: ($x,$y)";
echo "<br>  roughly ".round($unitDistance,2)." units away ";
