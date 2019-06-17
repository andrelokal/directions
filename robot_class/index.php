<?php

require_once("Robot.php");

$movements = array();
$obstacles = array();

/*
 * reading the file directions
 */
$rows = file('directions.txt');

foreach ($rows as $row) {
    $array = explode(' ', $row);
    $key = trim($array[0]);
    $value = trim($array[1]);
    if (!preg_match('/^[0-9]*$/', $key) && count($movements) <= 10000) {
        $movements[][$key] = $value;
    } elseif (count($obstacles) <= 10) {
        $obstacles[$key] = $value;
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
