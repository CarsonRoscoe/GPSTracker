<?php

/**-----------------------------------------------------------------------
 * SOURCE FILE: controllers/Clients.php
 *
 * PROGRAM: GPSTracker
 *
 * CLASS: Clients
 *
 * METHODS:
 * queryResult getClients()
 * queryResult getClientByUsername(username)
 * string generateHexValueByName(username)
 *
 * DATE: March 10th, 2016
 *
 * REVISIONS: March 20th, 2016: Commented
 *
 * @programmer: Carson Roscoe
 *
 * @designer: Carson Roscoe
 *
 * NOTES: Model used for handling the Clients table of our database.
 * ----------------------------------------------------------------------*/
class Clients extends MY_Model {

    /**
     * Constructor.
     * @param string $tablename Name of the database table
     * @param string $keyfield  Name of the primary key of the table
     */
    function __construct() {
        parent::__construct('clientlogin','username');
    }

    function getPositionsOfUser($name) {
        $this->db->select('username, datetime, ip, deviceName, latitude, longitude');
        $this->db->from('clientposition');
        $this->db->where("username = ", $name);
        $query = $this->db->get();

        return $query->result_array();
    }

    function getPositions() {
        $this->db->select('username, datetime, ip, deviceName, latitude, longitude');
        $this->db->from('clientposition');
        $query = $this->db->get();

        return $query->result_array();
    }

    /**-------------------------------------------------------------------
     * METHOD: getClients
     *
     * INTERFACE: queryResults getClients()
     *
     * DATE: March 10th, 2016
     *
     * REVISIONS: March 20th, 2016: Commented
     *
     * @programmer: Carson Roscoe
     *
     * @designer: Carson Roscoe
     *
     * NOTES: Returns an array of pairs, where the pair is an array
     * of usernames and first+last name combos.
     -------------------------------------------------------------------*/
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

    /**-------------------------------------------------------------------
     * METHOD: getClientNamesByUsername
     *
     * INTERFACE: queryResults getClientNamesByUsername(username)
     *
     * DATE: March 10th, 2016
     *
     * REVISIONS: March 20th, 2016: Commented
     *
     * @programmer: Carson Roscoe
     *
     * @designer: Carson Roscoe
     *
     * NOTES: Returns an array that contains a first and last name in
     * string form based on the username passed in
     -------------------------------------------------------------------*/
    function getClientNamesByUsername($username) {
        $res = $this->some('username', $username);
        return array($res[0]->firstname, $res[0]->lastname);
    }

    /**-------------------------------------------------------------------
     * METHOD: generateHexValueByName
     *
     * INTERFACE: string generateHexValueByName(username)
     *
     * DATE: March 10th, 2016
     *
     * REVISIONS: March 20th, 2016: Commented
     *
     * @programmer: Carson Roscoe
     *
     * @designer: Carson Roscoe
     *
     * NOTES: Takes a username and turns it into a hex colour value
     * that will be in the form "#FF00FF" for example.
     -------------------------------------------------------------------*/
    function generateHexValueByName($username) {
        return '#'.substr(dechex(abs(crc32($username))), 0, 6);
    }
}