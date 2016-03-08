<?php

/**
 * model/Players.php
 *
 * Player model
 *
 * @author				Jaegar Sarauer, Allen Tsang, Dhivya Manohar
 * @copyright			2016-, Special Characters
 * ------------------------------------------------------------------------
 */


class Clients extends MY_Model {
    
    /**
     * Constructor.
     * @param string $tablename Name of the database table
     * @param string $keyfield  Name of the primary key of the table
     */
    function __construct() {
        parent::__construct('clientlogin','username');
    }
    
    /**
     * Get all players that are in the database
     * @return array all players
     */
    function getClients() {
        $res = $this->all();
        $newRes = array();
        foreach($res as $queryIndex) {
            $tmpRes = array();
            array_push($tmpRes, $queryIndex->username, $queryIndex->firstname . ' ' . $queryIndex->lastname);
            array_push($newRes, $tmpRes);
        }
        return $newRes;
    }
    
    /**
     * Get all player names by username
     * @param type $username of player
     * @return type array of all players
     */
    function getClientNamesByUsername($username) {
        $res = $this->some('username', $username);
        return array($res[0]->firstname, $res[0]->lastname);
    }
}