<?php

/**-----------------------------------------------------------------------
 * SOURCE FILE: controllers/Map.php
 *  
 * PROGRAM: GPSTracker
 * 
 * CLASS: Map
 * 
 * METHODS:
 * void index(username defaulted to null)
 * void loadMap(username)
 * 
 * DATE: March 10th, 2016
 * 
 * REVISIONS: March 20th, 2016: Commented
 *
 * @programmer				Carson Roscoe
 * 
 * @designer                            Carson Roscoe
 * 
 * NOTES: Controller used for drawing the map page
 * ----------------------------------------------------------------------*/

class Map extends Application {

    /**-------------------------------------------------------------------
     * METHOD: index
     * 
     * INTERFACE: void index(username (optional))
     * 
     * DATE: March 10th, 2016
     * 
     * REVISIONS: March 20th, 2016: Commented
     *
     * @programmer: Carson Roscoe
     * 
     * @designer: Carson Roscoe
     * 
     * NOTES: When routing to the website.com/map page, this controller's
     * index method will take over. This method will handle generating the
     * page and displaying the map data for a given username(s)
     -------------------------------------------------------------------*/
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
    
    /**-------------------------------------------------------------------
     * METHOD: loadMap
     * 
     * INTERFACE: void loadmap(username)
     * 
     * DATE: March 10th, 2016
     * 
     * REVISIONS: March 20th, 2016: Commented
     *
     * @programmer: Carson Roscoe
     * 
     * @designer: Carson Roscoe
     * 
     * NOTES: Handles the Google Maps API calls and drawing a map
     * based on a given username.
     -------------------------------------------------------------------*/
    function loadMap($name) {
        if ($name != null) {
            $coordinates = $this->coordinates->getLatestPositions($name);
            $lastindex = count($coordinates)-1;
            $latitude = $coordinates[$lastindex]->latitude;
            $longitude = $coordinates[$lastindex]->longitude;
            $config['center'] = $latitude.', '.$longitude;
            $config['zoom'] = 8;
            $this->googlemaps->initialize($config);
            $marker = array();
            $marker['position'] = $coordinates[$lastindex]->latitude.', '.$coordinates[$lastindex]->longitude;
            $this->googlemaps->add_marker($marker);

            $polyline = array();
            $polyline['points'] = array();
            $polyline['strokeColor'] = $this->clients->generateHexValueByName($name);
            
            foreach($coordinates as $coordinate) {
                array_push($polyline['points'], $coordinate->latitude.', '.$coordinate->longitude);
            }

            $this->googlemaps->add_polyline($polyline);
            $data['map'] = $this->googlemaps->create_map();

            $this->data['content'] = $this->load->view('view_file', $data, true);
        } else {
            $names = $this->clients->getClients();
            $coordinates = $this->coordinates->getLatestPositions($this->session->userdata('logged_in')['username']);
            $lastindex = count($coordinates)-1;
            $latitude = $coordinates[$lastindex]->latitude;
            $longitude = $coordinates[$lastindex]->longitude;
            $config['center'] = $latitude.', '.$longitude;
            $config['zoom'] = 7;
            $this->googlemaps->initialize($config);
            
            foreach($names as $localname) {
                $localcoordinates = $this->coordinates->getLatestPositions($localname[0]);
                $lastindexlocal = count($localcoordinates)-1;
                $locallatitude = $localcoordinates[$lastindexlocal]->latitude;
                $locallongitude = $localcoordinates[$lastindexlocal]->longitude;
                
                $marker = array();
                $marker['position'] = $locallatitude.', '.$locallongitude;
                $this->googlemaps->add_marker($marker);
                
                $polyline = array();
                $polyline['points'] = array();
                $polyline['strokeColor'] = $this->clients->generateHexValueByName($localname[0]);

                foreach($localcoordinates as $coordinate) {
                    array_push($polyline['points'], $coordinate->latitude.', '.$coordinate->longitude);
                }

                $this->googlemaps->add_polyline($polyline);
            }

            $data['map'] = $this->googlemaps->create_map();

            $this->data['content'] = $this->load->view('view_file', $data, true);
        }
    }
}
