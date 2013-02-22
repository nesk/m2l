<?php
// One month before the actual date
$chartStart = date('d/m/Y', mktime(0, 0, 0, date('n')-1));
?>

<div style="width:50%;float:right">
    
    <h2>Statistiques</h2>

    <form id="chart-form">
        <select name="chart-type">
            <option value="roomUsage">Utilisation de chaque salle</option>
            <option value="entriesNb">Nombre de réservations</option>
        </select>

        <span id="chart-blocks">
            <!--
                Each block with an id containing an option value will
                be displayed when the corresponding option is selected
            -->
            
            <span id="chart-blocks-entriesNb">
                par
                <select name="chart-period">
                    <option value="day">jour</option>
                    <option value="week" selected="selected">semaine</option>
                    <option value="month">mois</option>
                </select>
            </span>
        </span>

        du <input type="text" name="chart-start" value="<?=$chartStart?>"/>
        au <input type="text" name="chart-end" value="<?=date('d/m/Y')?>"/>

        <input type="submit" value="Afficher" />
    </form>

    <div id="chart"></div>

</div>