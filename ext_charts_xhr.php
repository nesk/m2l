<?php

// To display french dates
setlocale (LC_TIME, 'fr_FR.utf8', 'fra');

require_once "defaultincludes.inc";
require_once "ext_autoloader.php";

/*
 * Preprocessing and HTTP headers
 */

$currentUser = getUserName();
$userLvl = authGetUserLevel($currentUser);
$selectedUser = $_GET['user'];

// Checks if the user can display those stats
if($userLvl <= 0 || !empty($selectedUser) && $userLvl < 2 && $selectedUser != $currentUser) {
    exit(); // He can't
}

// Connecting to the database
$db = new Database();
$retriever = new StatRetriever($db, empty($selectedUser) ? $currentUser : $selectedUser);

// Declares the content as JSON
header('Content-type: application/json');

/*
 * Data processing
 */

$chartType = $_GET['chart-type'];
$period = $_GET['chart-period'];

$start = DateTime::createFromFormat('d/m/Y', $_GET['chart-start']);
$end = DateTime::createFromFormat('d/m/Y', $_GET['chart-end']);

if(!empty($start) && !empty($end)) {
    $start = $start->getTimestamp();
    $end = $end->getTimestamp();
} else {
    exit(); // We can't finish the execution with wrong dates
}

/*
 * Content
 */

$dataResponse = array();

// Defines the titles of the chart
switch($chartType) {
    case 'roomUsage':
        $dataResponse[] = array('Salle', 'Réservations');
        break;
    case 'entriesNb':
        $dataResponse[] = array('Date', 'Réservations');
        break;
}

// Retrieves the data
$retriever->getStats(
    $chartType,
    array(
        'start' => $start,
        'end' => $end,
        'period' => $period
    ),
    function($data) use ($chartType, $period, &$dataResponse) {

        switch($chartType) {
            case 'roomUsage':
                $dataResponse[] = array($data['name'], intval($data['nb']));
                break;
            case 'entriesNb':
                $formats = array(
                    'day' => '%d %b',
                    'week' => 'Semaine %V',
                    'month' => '%B'
                );

                $dataResponse[] = array(strftime($formats[$period], $data['date']), intval($data['nb']));
                break;
        }

    }
);

// Returns the data in a JSON object
echo json_encode($dataResponse);