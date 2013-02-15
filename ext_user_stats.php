<?php

/*
 * Includes
 */

require_once "defaultincludes.inc";
require_once "theme.inc";

require_once "ext_autoloader.php";

/*
 * Preprocessing and header
 */

// Checks if the user is authorised for this page
checkAuthorised();

// Connecting to the database
$db = new Database();

// Prints the page header
print_header($day, $month, $year, $area, isset($room) ? $room : "");

/*
 * Content
 */

echo '<h1>Tableau de bord</h1>';

require_once 'ext_entries.php';

/*
 * Footer
 */

require_once "trailer.inc";