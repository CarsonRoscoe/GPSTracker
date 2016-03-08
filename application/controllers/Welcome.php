<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * controllers/Welcome.php
 *
 * Welcome controller
 *
 * @author				Carson Roscoe, Jaegar Sarauer
 * @copyright			2016-, Special Characters
 * ------------------------------------------------------------------------
 */

class Welcome extends Application {
	/**
	 * Index Page for this controller.
	 */
    public function index() { 
        $empty = array();
        $this->data['content'] = $this->parser->parse('homepagetext', $empty, TRUE);
        $this->data['navigation'] = $this->createNavigation(1);//create navigation bar - MY_CONTROLLER.php
        $this->data['dropdownlist'] = ''; //create drop down - MY_CONTROLLER.php

        $this->data['contentTitle'] = 'Record And Display Your GPS Data Today!';//set page title

        $this->render();
    }        
}
