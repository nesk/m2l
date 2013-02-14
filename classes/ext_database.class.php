<?php

class Database {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=mrbs', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

}