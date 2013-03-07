<?php

/*
 * BDRetriever class
 *
 * Provides properties and a constructor that must be used for each
 * database retriever. This class must be inherited.
 *
 * Each method retrieving data should take one or many anonymous functions in
 * argument, this allows the caller to get rid of the loop management.
 */

class DBRetriever {

    protected $db;
    protected $user;

    public function __construct(Database $db, $user) {
        $this->db = $db->getConnection();
        $this->user = $user;
    }

}