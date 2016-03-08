<?php

/**
 * controllers/Portfolio.php
 *
 * Portfolio controller
 *
 * @author				Carson Roscoe, Jaegar Sarauer
 * @copyright			2016-, Special Characters
 * ------------------------------------------------------------------------
 */

class Map extends Application {

    /**
     * Index Page for this controller.
     */
    public function index($name = null) { 
        $loggedName = $this->session->userdata('logged_in')['username'];
        if ($loggedName === NULL) {
            //handle nobody logged in and no profile username request
            echo '<script>alert("You must be logged in to view this content.")</script>';
            redirect('/', 'refresh');
        }

        $this->data['navigation'] = $this->createNavigation(2); //create navigation bar
        $this->data['dropdownlist'] = $this->createDropDown($this->clients->getClients(), $name); //create drop down

        if ($name == null) {
            $this->data['contentTitle'] = 'Viewing All GPS Data';
        } else {
            $fullName = $this->clients->getClientNamesByUsername($name);
            $this->data['contentTitle'] = 'Viewing '.$fullName[0].' '.$fullName[1].'\'s GPS Data';
        }
        //$fullName = $this->players->getPlayerNamesByUsername($realName); //query players          

        $this->loadMap($name);
        
        $this->render();
    }
    
    function loadMap($name) {
        if ($name != null) {
            $coordinates = $this->coordinates->getLatestPosition($name);
            $latitude = $coordinates[0]->latitude;
            $longitude = $coordinates[0]->longitude;
            $config['center'] = $latitude.', '.$longitude;
            $config['zoom'] = 8;
            $this->googlemaps->initialize($config);

            $marker = array();
            $marker['position'] = $latitude.', '.$longitude;
            $this->googlemaps->add_marker($marker);

            $data['map'] = $this->googlemaps->create_map();

            $this->data['content'] = $this->load->view('view_file', $data, true);
        } else {
            $names = $this->clients->getClients();
            $coordinates = $this->coordinates->getLatestPosition($this->session->userdata('logged_in')['username']);
            $latitude = $coordinates[0]->latitude;
            $longitude = $coordinates[0]->longitude;
            $config['center'] = $latitude.', '.$longitude;
            $config['zoom'] = 7;
            $this->googlemaps->initialize($config);
            
            foreach($names as $localname) {
                $localcoordinates = $this->coordinates->getLatestPosition($localname[0]);
                $locallatitude = $localcoordinates[0]->latitude;
                $locallongitude = $localcoordinates[0]->longitude;
                
                $marker = array();
                $marker['position'] = $locallatitude.', '.$locallongitude;
                $this->googlemaps->add_marker($marker);
            }

            $data['map'] = $this->googlemaps->create_map();

            $this->data['content'] = $this->load->view('view_file', $data, true);
        }
    }
}
