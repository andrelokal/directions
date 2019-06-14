<?php

require_once("Robot.php");

$movements = array();
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
    } elseif (count($obstacles) <= 10) {
        $obstacles[$k] = $v;
    }
}

/*
 * processing the rows
 */
$robot = new Robot("N", $obstacles);

foreach ($movements as $kr => $vr) {
    foreach ($vr as $command => $units) {
        if ($command == 'M' && $v <= 10) {
            $robot->walkTo($units);
        } else {
            $robot->swapTo($command);
        }
    }
}

/*
 * Show the results
 */
$robot->processResults();
