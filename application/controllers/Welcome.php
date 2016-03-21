<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**-----------------------------------------------------------------------
 * SOURCE FILE: controllers/Welcome.php
 *  
 * PROGRAM: GPSTracker
 * 
 * CLASS: Welcome
 * 
 * METHODS:
 * void index()
 * 
 * DATE: March 10th, 2016
 * 
 * REVISIONS: March 20th, 2016: Commented
 *
 * @programmer				Carson Roscoe
 * 
 * @designer                            Carson Roscoe
 * 
 * NOTES: Controller used for generating the homepage
 * ----------------------------------------------------------------------*/
class Welcome extends Application {

    /**-------------------------------------------------------------------
     * METHOD: index
     * 
     * INTERFACE: void index()
     * 
     * DATE: March 10th, 2016
     * 
     * REVISIONS: March 20th, 2016: Commented
     *
     * @programmer: Carson Roscoe
     * 
     * @designer: Carson Roscoe
     * 
     * NOTES: When routing to the websites homepage, this controller will
     * be routed too and take over generating the website for the user.
     * This index method is what will be invoked.
     -------------------------------------------------------------------*/
    public function index() { 
        $empty = array();
        $this->data['content'] = $this->parser->parse('homepagetext', $empty, TRUE);
        $this->data['navigation'] = $this->createNavigation(1);//create navigation bar - MY_CONTROLLER.php
        $this->data['dropdownlist'] = ''; //create drop down - MY_CONTROLLER.php

        $this->data['contentTitle'] = 'Record And Display Your GPS Data Today!';//set page title

        $this->render();
    }        
}
