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
                    break;
            }

            $tr[] = sqrt((($x - 0) * ($x - 0)) + (($y - 0) * ($y - 0)));
            $tm[] = "($x,$y)";


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

$unitDistance = max($tr);
$key = array_search($unitDistance, $tr);

echo "<br> maximum distance it ever got from (0, 0) is ".$tm[$key];
echo "<br> ending at: ($x,$y)";
echo "<br>  roughly ".round($unitDistance,2)." units away ";
