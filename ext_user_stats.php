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

$currentUser = getUserName();
$userLvl = authGetUserLevel($currentUser);
$selectedUser = empty($_GET['user']) ? '' : $_GET['user'];

// Checks if the user is authorised for this page
checkAuthorised();

// Checks if the user can display an another dashboard than its own
if(!empty($selectedUser) && $userLvl < 2 && $selectedUser != $currentUser) {
    header('Location: /ext_user_stats.php');
    exit();
}

// Connecting to the database with a username
$db = new Database(empty($selectedUser) ? $currentUser : $selectedUser);

// Prints the page header
print_header($day, $month, $year, $area, isset($room) ? $room : "");

/*
 * Content
 */

?>

<h1>
    Tableau de bord
    <?php if($userLvl >= 2) { ?>
    <select id="dashboard-user">
        <option value="<?=$currentUser?>">Moi-même</option>
        <option value="%" <?php if($selectedUser == '%') echo 'selected="selected"'; ?> >Tous les utilisateurs</option>
        <optgroup label="Autres utilisateurs">
            <?php $db->getUsers(function($data) use ($selectedUser) { ?>
            <option value="<?=$data['name']?>" <?php if($selectedUser == $data['name']) echo 'selected="selected"'; ?> >
                <?=$data['name']?>
            </option>
            <?php }); ?>
        </optgroup>
    </select>
    <?php } ?>
</h1>

<?php

require_once 'ext_entries.php';

?>

<script type="text/javascript" src="ext_dashboard.js"></script>

<?php

/*
 * Footer
 */

require_once "trailer.inc";