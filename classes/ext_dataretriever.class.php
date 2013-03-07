<?php

/*
 * DataRetriever class
 *
 * Provides methods to easily retrieve the users and the entries.
 */

class DataRetriever extends DBRetriever {

    /*
     * Users
     */

    public function getUsers($onData) {
        $req = $this->db->prepare('
            SELECT name
            FROM mrbs_users
            WHERE name != :user
            ORDER BY name
        ');

        $req->execute(array(
            'user' => getUserName() // We don't need to retrieve the current user
        ));

        while($data = $req->fetch()) {
            $onData($data);
        }
    }

    /*
     * Entries
     */

    public function getPastEntries($onData, $noData) {
        $this->getEntries($onData, $noData, '<=');
    }

    public function getActualEntries($onData, $noData) {
        $this->getEntries($onData, $noData, '>');
    }

    private function getEntries($onData, $noData, $comparison) {
        $req = $this->db->prepare('
            SELECT e.id AS eId, r.id AS rId, e.name AS name, r.room_name AS room, start_time AS start, end_time AS end, repeat_id
            FROM mrbs_entry AS e
            LEFT JOIN mrbs_room AS r ON e.room_id = r.id
            WHERE e.create_by LIKE :user
            AND e.end_time ' . $comparison . ' :time
            ORDER BY start_time
        ');

        $req->execute(array(
            'user' => $this->user,
            'time' => time()
        ));

        $isThereData = false;

        while($data = $req->fetch()) {
            $isThereData = true;
            $onData($data);
        }

        if(!$isThereData) {
            $noData();
        }
    }

}