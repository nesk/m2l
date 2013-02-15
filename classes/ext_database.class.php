<?php

/*
 * Database class
 *
 * Provides a connection to the database and methods to easily retrieve data.
 * Each method retrieving data takes an anonymous function in argument, this
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

    private function getEntries($onData, $comparison) {
        $req = $this->db->prepare('
            SELECT e.name AS name, r.room_name AS room
            FROM mrbs_entry AS e
            LEFT JOIN mrbs_room AS r ON e.room_id = r.id
            WHERE e.create_by = :user
            AND e.end_time ' . $comparison . ' :time
        ');

        $req->execute(array(
            'user' => $this->user,
            'time' => time()
        ));

        while($data = $req->fetch()) {
            $onData($data);
        }
    }

    public function getPastEntries($onData) {
        $this->getEntries($onData, '<=');
    }

    public function getActualEntries($onData) {
        $this->getEntries($onData, '>');
    }

}