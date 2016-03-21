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

        $this->data['pagebody'] = 'view_file';

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

        $this->loadMap($name);
        $this->loadTable($name);

        $this->render();
    }

    function loadTable($name) {
        if ($name != null) {
            $this->load->library('table');
            $clientPositions = $this->clients->getPositionsOfUser($name);
            $this->data['postable'] = $this->generateTable($clientPositions);
        } else {
            $this->load->library('table');
            $clientPositions = $this->clients->getPositions();
            $this->data['postable'] = $this->generateTable($clientPositions);
        }
    }

    function generateTable($user) {
        //sets the table style
        $template = array('table_open' => '<table class="highlight">');
        $this->table->set_template($template);
        $this->table->set_heading('User', 'Time', 'IP', 'Device', 'Latitude', 'Longitude');

        foreach ($user as $row) {
            $this->table->add_row($row);
        }

        return $this->table->generate();
    }

    /**-------------------------------------------------------------------
     * METHOD: loadMap
     *
     * INTERFACE: void loadmap(username)
     *
     * DATE: March 10th, 2016
     *
     * REVISIONS: March 20th, 2016: Commented
     *            March 20th, 2016: refactored - Spenser
     *
     * @programmer: Carson Roscoe, Spenser Lee
     *
     * @designer: Carson Roscoe
     *
     * NOTES: Handles the Google Maps API calls and drawing a map
     * based on a given username.
     -------------------------------------------------------------------*/
    function loadMap($name) {

        // center on BCIT
        $config['center'] = 49.249458. ', ' . -123.001601;
        $config['zoom'] = 12;
        $this->googlemaps->initialize($config);

        if ($name != null) {
            $latitude = $this->coordinates->getLatestPositions($name)[0]->latitude;
            $longitude = $this->coordinates->getLatestPositions($name)[0]->longitude;
            $config['center'] = $latitude.', '.$longitude;
            $this->googlemaps->initialize($config);
            $this->loadMarkers($name);
        } else {
            $names = $this->clients->getClients();
            foreach ($names as $localname) {
                $this->loadMarkers($localname[0]);
            }
        }

        $data['map'] = $this->googlemaps->create_map();
        $this->data['content'] = $this->load->view('view_file', $data, true);
    }

    /**-------------------------------------------------------------------
     * METHOD: loadMarkers
     *
     * INTERFACE: void loadMarkers($name)
     *
     * DATE: March 20th, 2016
     *
     * REVISIONS: March 20th, 2016
     *
     * @programmer: Spenser Lee
     *
     * @designer: Spenser Lee
     *
     * NOTES: Helper function to draw map markers and polylines
     -------------------------------------------------------------------*/
    function loadMarkers($name) {
        $coordinates = $this->coordinates->getAllPositions($name);
        $firstLat = $coordinates[0]['latitude'];
        $firstLon = $coordinates[0]['longitude'];

        $marker = array();
        $polyline = array();
        $polyline['points'] = array();
        $polyline['strokeColor'] = $this->clients->generateHexValueByName($name);

        switch ($name) {
            case 'slee':
                $marker['icon'] = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
                break;
            case 'mwillems':
                $marker['icon'] = 'http://maps.google.com/mapfiles/ms/icons/purple-dot.png';
                break;
            case 'tyu':
                $marker['icon'] = 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png';
                break;
            case 'croscoe':
                $marker['icon'] = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
                break;
            default:
                $marker['icon'] = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
                break;
        }

        foreach ($coordinates as $row) {
            $latitude = $row['latitude'];
            $longitude = $row['longitude'];

            array_push($polyline['points'], $latitude . ', ' . $longitude);
            $marker['position'] = $latitude . ', ' . $longitude;
            $this->googlemaps->add_marker($marker);
        }
        $this->googlemaps->add_polyline($polyline);
    }
}
