<?php
/*
 * Functions to display some repetitives parts of the HTML code
 */
?>

<?php function tableHeader() { ?>
<tr>
    <th>Nom de la réservation</th>
    <th>Nom de la salle</th>
    <th>Début de la réunion</th>
    <th>Fin de la réunion</th>
</tr>
<?php
}

function tableContent($data) {
    // Displays an icon and an id when the current entry is repeated
    $repeat = $data['repeat_id'] != 0
        ? '['. $data['repeat_id'] . '] <img src="/images/repeat.png" />'
        : '';
?>
<tr>
    <td><a href="/view_entry.php?id=<?=$data['eId']?>"><?=$data['name']?> <span style="float:right;margin-left:15px"><?=$repeat?></span></a></td>
    <td><a href="/edit_area_room.php?change_room=1&phase=1&room=<?=$data['rId']?>"><?=$data['room']?></a></td>
    <td><?=date('d/m/Y H:i', $data['start'])?></td>
    <td><?=date('d/m/Y H:i', $data['end'])?></td>
</tr>
<?php
}

function tableNoContent() {
?>
<tr>
    <td colspan="4" style="text-align:center">Aucune réservation à afficher</td>
</tr>
<?php } ?>


<?php
/*
 * Main HTML code for entries
 */
?>

<div style="width:50%;float:left">
    <h2>Vos réservations actuelles</h2>

    <table class="admin_table">
    <?php
    tableHeader();

    $db->getActualEntries(function($data) {
        tableContent($data);
    }, function() {
        tableNoContent();
    });
    ?>
    </table>

    <h2>Vos réservations terminées</h2>

    <table class="admin_table">
    <?php
    tableHeader();

    $db->getPastEntries(function($data) {
        tableContent($data);
    }, function() {
        tableNoContent();
    });
    ?>
    </table>
</div>