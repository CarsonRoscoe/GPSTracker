<?php

/**-----------------------------------------------------------------------
 * SOURCE FILE: controllers/Coordinates.php
 *
 * PROGRAM: GPSTracker
 *
 * CLASS: Coordinates
 *
 * METHODS:
 * queryResult getLatestPositions(name)
 *
 * DATE: March 10th, 2016
 *
 * REVISIONS: March 20th, 2016: Commented
 *
 * @programmer: Carson Roscoe
 *
 * @designer: Carson Roscoe
 *
 * NOTES: Model used for handling communicating with the database in
 * regards to the GPS data
 * ----------------------------------------------------------------------*/
class Coordinates extends MY_Model {

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct('clientposition','username', 'datetime');
    }

    /**-------------------------------------------------------------------
     * METHOD: getLatestPositions
     *
     * INTERFACE: queryResults getLatestPositions(username)
     *
     * DATE: March 10th, 2016
     *
     * REVISIONS: March 20th, 2016: Commented
     *
     * @programmer: Carson Roscoe
     *
     * @designer: Carson Roscoe
     *
     * NOTES: Takes in a clients username and returns an array of their
     * latest GPS positions
     -------------------------------------------------------------------*/
    function getLatestPositions($name) {
        return $this->db->get_where('clientposition', array('username =' => $name))->result();
    }

    /**-------------------------------------------------------------------
     * METHOD: getAllPositions
     *
     * INTERFACE: array() getAllPositions($name)
     *
     * DATE: March 20th, 2016
     *
     * REVISIONS: March 20th, 2016
     *
     * @programmer: Spenser Lee
     *
     * @designer: Spenser Lee
     *
     * NOTES: Executes DB query to final all coordinates of a user.
     -------------------------------------------------------------------*/
    function getAllPositions($name) {
        $this->db->select('latitude, longitude');
        $this->db->from('clientposition');
        $this->db->where("username = ", $name);
        $query = $this->db->get();

        return $query->result_array();
    }
}