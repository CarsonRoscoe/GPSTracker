<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**-----------------------------------------------------------------------
 * SOURCE FILE: controllers/Login.php
 *  
 * PROGRAM: GPSTracker
 * 
 * CLASS: Login
 * 
 * METHODS:
 * void loginAttempt()
 * bool queryLogin(username, password)
 * bool setNavBarLogin(username, password)
 * void setNavBarLogout()
 * 
 * DATE: March 10th, 2016
 * 
 * REVISIONS: March 20th, 2016: Commented
 *
 * @programmer: Carson Roscoe
 * 
 * @designer: Carson Roscoe
 * 
 * NOTES: Controller used to handling logging in and logging out.
 * ----------------------------------------------------------------------*/
class Login extends Application {     

    /**-------------------------------------------------------------------
     * METHOD: loginAttempt
     * 
     * INTERFACE: void loginAttempt(void)
     * 
     * DATE: March 10th, 2016
     * 
     * REVISIONS: March 20th, 2016: Commented
     *
     * @programmer: Carson Roscoe
     * 
     * @designer: Carson Roscoe
     * 
     * NOTES: Gathers the username and password via POST and checks if
     * we can successfully login. If we can't alerts the user so and refuses
     * to let the user log in.
     -------------------------------------------------------------------*/
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
    
    /**-------------------------------------------------------------------
     * METHOD: queryLogin
     * 
     * INTERFACE: bool/result queryLogin(username, password)
     * 
     * DATE: March 10th, 2016
     * 
     * REVISIONS: March 20th, 2016: Commented
     *
     * @programmer: Carson Roscoe
     * 
     * @designer: Carson Roscoe
     * 
     * NOTES: Takes in a username and password. It then checks in the
     * database if there is a username & password combination that is valid.
     * If there is no valid combination, it returns false. If there is one,
     * it returns that result.
     -------------------------------------------------------------------*/
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
   
    /**-------------------------------------------------------------------
     * METHOD: setNavBarLogin
     * 
     * INTERFACE: bool setNavBarLogin(username, password)
     * 
     * DATE: March 10th, 2016
     * 
     * REVISIONS: March 20th, 2016: Commented
     *
     * @programmer: Carson Roscoe
     * 
     * @designer: Carson Roscoe
     * 
     * NOTES: With a given username and password it calls queryLogin to
     * see if there is valid data. If there is valid data, it populates
     * the view with such and refreshes the page to the /map route, and 
     * then returns true. If it was not a valid login, it returns false.
     -------------------------------------------------------------------*/
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
    
    /**-------------------------------------------------------------------
     * METHOD: setNavBarLogout
     * 
     * INTERFACE: void setNavBarLogout(void)
     * 
     * DATE: March 10th, 2016
     * 
     * REVISIONS: March 20th, 2016: Commented
     *
     * @programmer: Carson Roscoe
     * 
     * @designer: Carson Roscoe
     * 
     * NOTES: Logs out the user and refreshes the page
     -------------------------------------------------------------------*/
    public function setNavBarLogout() {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('/', 'refresh'); //redirects to welcome page after logout
    }
}