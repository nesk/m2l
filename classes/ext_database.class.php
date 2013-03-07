<?php

/*
 * Database class
 *
 * Provides a connection to the database.
 */

class Database {

    private $db;

    public function __construct() {
        $this->db = $db = new PDO('mysql:host=localhost;dbname=mrbs', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec('SET NAMES UTF8');
    }

    public function getConnection() {
        return $this->db;
    }

}