<?php

/**
 * controllers/Login.php
 *
 * Login controller
 *
 * @author				Dhivya Manohar
 * @copyright			2016-, Special Characters
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Application {     

    /**
     * Attempt to login
     * @param type $username user input 
     * @param type $password user input
     */
    public function loginAttempt() {        
        //if able to get username
        if (isset($_POST['username']) && isset($_POST['password'])) {
            //if user name and password are invalid
            if(!$this->setNavBarLogin($_POST['username'],$_POST['password'])) {
                echo '<script>alert("Invalid username and password combination.")</script>';
                redirect('/', 'refresh');
            }
        } else {
            $this->setNavBarLogout();//sucessfully found user name & password combonation
        }
    }
    
    /**
     * Check login data against database
     * @param type $username user name to query
     * @param type $password password to query
     * @return boolean return false if unable to find a row that matches
     *          description
     */
    public function queryLogin($username, $password) {
        //database query
        $this -> db -> select('username, firstname, password');
        $this -> db -> from('clientlogin');
        $this -> db -> where('username', $username);
        $this -> db -> where('password', $password);
        
        $result = $this-> db -> get();//return results found

        //handle condition of result
        if($result -> num_rows() == 1) {
            return $result->result();
        } else {
            return false;
        }
   }
   
    /**
     * Setting the session variable according to conditions
     * @param type $username user name 
     * @param type $password password
     * @return boolean return false if not logged in
     */
    public function setNavBarLogin($username,$password){
        $result = $this->queryLogin($username,$password);

        if($result) {
            $sess_array = array();
            //go through the result and set session variable with data
            foreach($result as $row) {
                $sess_array = array(
                    'username' => $row->username,
                    'firstname' => $row->firstname
                );
            }
            $this->session->set_userdata('logged_in', $sess_array);
            
            redirect('/map', 'refresh');//if logged in, refresh to welcome page
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Logout function (clears session variable)
     */
    public function setNavBarLogout() {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('/', 'refresh'); //redirects to welcome page after logout
    }
}