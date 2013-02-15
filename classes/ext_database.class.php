<?php

/*
 * Database class
 *
 * Provides a connection to the database and methods to easily retrieve data.
 * Each method retrieving data takes anonymous functions in argument, this
 * allows the caller to get rid of the loop management.
 */

class Database {

    private $db;
    private $user;

    public function __construct() {
        $this->db = $db = new PDO('mysql:host=localhost;dbname=mrbs', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec('SET NAMES UTF8');

        $this->user = getUserName();
    }

    /*
     * Entries
     */

    private function getEntries($onData, $noData, $comparison) {
        $req = $this->db->prepare('
            SELECT e.id AS eId, r.id AS rId, e.name AS name, r.room_name AS room, start_time AS start, end_time AS end, repeat_id
            FROM mrbs_entry AS e
            LEFT JOIN mrbs_room AS r ON e.room_id = r.id
            WHERE e.create_by = :user
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

    public function getPastEntries($onData, $noData) {
        $this->getEntries($onData, $noData, '<=');
    }

    public function getActualEntries($onData, $noData) {
        $this->getEntries($onData, $noData, '>');
    }

    /*
     * Statistics
     */

    private function roomUsage($start, $end, $onData) {
        $req = $this->db->prepare('
            SELECT room_name AS name, count(room_id) AS nb
            FROM mrbs_entry AS e
            JOIN mrbs_room AS r ON e.room_id = r.id
            WHERE e.create_by = :user
            AND (start_time <= :end OR end_time >= :start)
            GROUP BY r.id
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

    public function getStats($type, $start, $end, $onData) {
        switch($type) {
            case 'roomUsage':
                $this->roomUsage($start, $end, $onData);
                break;
        }
    }
}