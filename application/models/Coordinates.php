<?php

/**
 * model/Movement.php
 *
 * Movement model
 *
 * @author				Jaegar Sarauer, Allen Tsang, Dhivya Manohar,
 * @copyright			2016-, Special Characters
 * ------------------------------------------------------------------------
 */

class Coordinates extends MY_Model {
    
    /**
     * Constructor
     */
    function __construct() {
        parent::__construct('clientposition','username', 'datetime');
    }
    
    /**
     * Gets movements of specified stock
     * @param type $name name of stock
     * @return array containing movement data
     */
    function getLatestPositions($name) {
        return $this->db->get_where('clientposition', array('username =' => $name))->result();
        /*$this->db->from('clientposition');
        $this->db->order_by("datetime", "asc");
        $this->db->where(array('username =' => $name));
        return $this->db->get()->result()[0];*/
    }
}