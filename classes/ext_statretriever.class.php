<?php

/*
 * StatRetriever class
 *
 * Provides methods to easily retrieve statistics.
 */

class StatRetriever extends DBRetriever {

    // Main function used to retrieve all the statistics
    public function getStats($type, $options, $onData) {
        $o = $options; // Shortcut

        switch($type) {
            case 'roomUsage':
                $this->roomUsage($o['start'], $o['end'], $onData);
                break;
            case 'entriesNb':
                $this->entriesNb($o['start'], $o['end'], $o['period'], $onData);
                break;
        }
    }

    /*
     * Statistics
     */

    private function roomUsage($start, $end, $onData) {
        $req = $this->db->prepare('
            SELECT room_name AS name, count(room_id) AS nb
            FROM mrbs_entry AS e
            JOIN mrbs_room AS r ON e.room_id = r.id
            WHERE e.create_by LIKE :user
            AND start_time <= :end AND end_time >= :start
            GROUP BY r.id
            ORDER BY name
        ');

        $req->execute(array(
            'user' => $this->user,
            'start' => $start,
            'end' => $end + 86399 // Going to the last second of the specified day
        ));

        while($data = $req->fetch()) {
            $onData($data);
        }
    }

    // groupby is the name of the MySQL function used to group the data
    private function entriesNb($start, $end, $period, $onData) {
        $sqlDate = 'from_unixtime(start_time)';
        
        switch($period) {
            case 'day':
                $groupby = 'dayofyear('. $sqlDate .')';
                break;
            case 'week': // Check https://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_week
                $groupby = 'week('. $sqlDate .', 3)';
                break;
            case 'month':
                $groupby = 'month('. $sqlDate .')';
                break;
        }

        $req = $this->db->prepare('
            SELECT count(id) AS nb, start_time AS date
            FROM mrbs_entry
            WHERE create_by LIKE :user
            AND start_time <= :end AND end_time >= :start
            GROUP BY '. $groupby .'
            ORDER BY date
        ');

        $req->execute(array(
            'user' => $this->user,
            'start' => $start,
            'end' => $end + 86399 // Going to the last second of the specified day
        ));

        while($data = $req->fetch()) {
            $onData($data);
        }
    }

}