<?php

require_once "defaultincludes.inc";
require_once "theme.inc";

require_once "ext_autoloader.php";

// Checks if the user is authorised for this page
checkAuthorised();

// Prints the page header
print_header($day, $month, $year, $area, isset($room) ? $room : "");

?>

<?php

require_once "trailer.inc";

?>