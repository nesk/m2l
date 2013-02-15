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

    private function getEntries($onData, $noData, $comparison) {
        $req = $this->db->prepare('
            SELECT e.id AS eId, r.id AS rId, e.name AS name, r.room_name AS room, start_time AS start, end_time AS end
            FROM mrbs_entry AS e
            LEFT JOIN mrbs_room AS r ON e.room_id = r.id
            WHERE e.create_by = :user
            AND e.end_time ' . $comparison . ' :time
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

}