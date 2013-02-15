<h2>Vos réservations actuelles</h2>

<table class="admin_table">
    <tr>
        <th>Nom de la réservation</th>
        <th>Nom de la salle</th>
        <th>Début de la réunion</th>
        <th>Fin de la réunion</th>
    </tr>

<?php $db->getActualEntries(function($data) { ?>
    <tr>
        <td><a href="/view_entry.php?id=<?=$data['eId']?>"><?=$data['name']?></a></td>
        <td><a href="/edit_area_room.php?change_room=1&phase=1&room=<?=$data['rId']?>"><?=$data['room']?></a></td>
        <td><?=date('d/m/Y H:i', $data['start'])?></td>
        <td><?=date('d/m/Y H:i', $data['end'])?></td>
    </tr>
<?php }, function() { ?>
    <tr>
        <td colspan="4" style="text-align:center">Aucune réservation à afficher</td>
    </tr>
<?php }); ?>

</table>

<h2>Vos réservations terminées</h2>

<table class="admin_table">
    <tr>
        <th>Nom de la réservation</th>
        <th>Nom de la salle</th>
        <th>Début de la réunion</th>
        <th>Fin de la réunion</th>
    </tr>

<?php $db->getPastEntries(function($data) { ?>
    <tr>
        <td><a href="/view_entry.php?id=<?=$data['eId']?>"><?=$data['name']?></a></td>
        <td><a href="/edit_area_room.php?change_room=1&phase=1&room=<?=$data['rId']?>"><?=$data['room']?></a></td>
        <td><?=date('d/m/Y H:i', $data['start'])?></td>
        <td><?=date('d/m/Y H:i', $data['end'])?></td>
    </tr>
<?php }, function() { ?>
    <tr>
        <td colspan="4" style="text-align:center">Aucune réservation à afficher</td>
    </tr>
<?php }); ?>

</table>