<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		Carson Roscoe, Jaegar Sarauer, Dhivya Manohar
 * @copyright           2016-, Carson Roscoe, Jaegar Sarauer, Dhivya Manohar
 * ------------------------------------------------------------------------
 */

class Application extends CI_Controller {

    protected $data = array();      // parameters for view components
    protected $id;                  // identifier for our content

    /**
     * Constructor.
     * Establish view parameters & load common helpers
     */

    function __construct() {
        parent::__construct();
        $this->data = array();
        $this->data['pagetitle'] = "GPSTracker";
        $this->data['pageheader'] = "GPSTracker";
        $this->load->library('parser');
    }

    /**
     * Render this page
     * Used on all. We need to load data into content in the controller
     */
    function render() {
        $this->data['data'] = &$this->data;

        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);

        $this->parser->parse('_template', $this->data);
    }

    /**
     * Parsing query fom database
     * @param type $queryData data received from database
     * @param type $ignoreIndex
     * @return string parsed data
     */
    function parseQuery($queryData, $ignoreIndex = -1) {
            $res = '';

            if ($queryData == NULL) {
                return '';
            }

            foreach($queryData as $queryIndex) {
                $res .= '<tr>';
                for ($index = 0; $index < count($queryIndex); $index++) {
                    if ($ignoreIndex !== $index) {
                        $res .= '<td>' . $queryIndex[$index] . '</td>';
                    }
                }
                $res .= '</tr>';
            }
            return $res;
    }

        function parseQueryClickable($queryData, $linkto, $IgnoreIndex = 0) {
            $res = '';

            if ($queryData == NULL) {
                return '';
            }

            foreach($queryData as $queryIndex) {
                $res .= '<tr>';
                for ($index = $IgnoreIndex; $index < count($queryIndex); $index++) {
                    $res .= '<td>';
                    if ($index === $IgnoreIndex) {
                        $res .= '<a id="clickable" href="/'. $linkto. '/' . $queryIndex[0] . '">' . $queryIndex[$index] . '</a>';
                    } else {
                        $res .= $queryIndex[$index];
                    }
                    $res .= '</td>';
                }
            }
            return $res;
    }

    /**
     * Creates the dynamic navigation bar
     * @param type $page which controller you're in
     * @return string the html to be printed to screen
     */
    protected function createNavigation($page) {
        $result = '<div id="loginDiv">';
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $fullname = $this->clients->getClientNamesByUsername($session_data['username']);
            $result .= '<form id="loginForm" method="post" action="/logout">
                Hello,
                <br>
                '.$fullname[0].' '.$fullname[1].'.
                <br>
                <br>
                <br>
                <input type="submit" value="Logout">
            </form>';
        } else {
            $result .= '<form id="loginForm" method="post"action="/login">
                Username:<br>
                <input type="text" name="username"><br>
                Password:<br>
                <input type="password" name="password"><br>
                <input type="submit" value="Login">
            </form>';
        }

        $result .= '</div><div id="pageSelection"><ul>';

        $result .= '<li><a href="/">Homepage</a></li>
                    <li><a href="/map">Map</a></li>';

        $result .= '</ul></div>';

        return $result;
    }

    /**
     * Creates a dynamic dropdown list
     * @param type $dropdowndata
     * @param type $pagename
     * @return string
     */
    function createDropDown($dropdowndata = null, $pagename = null) {
        $URI = "$_SERVER[REQUEST_URI]"; //reloading page

        //error check URI is right
        if (strlen($URI) > 1) {
            $arr = explode('/', $URI);
            $URI = $arr[0].'/'.$arr[1];
        }

        $URI.='/';

        //populates the dropdown & if you change the item it will reload page
        $result = '<select onchange="window.location=\''."http://$_SERVER[HTTP_HOST]$URI".'\' + this.value;">';
        $result .= '<option value="all">All</option>';

        $myname = $this->session->userdata('logged_in')['username'];
        if ($pagename != $myname) {
            $result .= '<option value="'.$myname.'">'.'Myself'.'</option>';
        } else {
            $fullname = $this->clients->getClientNamesByUsername($myname);
            $result .= '<option value="'.$myname.'" selected="selected">'.'Myself'. '</option>';
        }
        foreach($dropdowndata as $item) {
            $result .= '<option value="'.$item[0].'"';
            if ($item[0]==$pagename) {
                $result .= ' selected="selected"';
            }
            $result .= '>'.$item[1] . ' [' . $item[0] . ']' . '</option>';
        }
        $result .= '</select>';
        return $result;
    }

    /**
     * Creates tables for page to hold content
     * @param type $columnNames name of columns
     * @return string html string to draw to screen
     */
    function createTableColumns($columnNames) {
        $result = '<tr>';
        foreach($columnNames as $column) {
            $result .= '<td><h3>'.$column.'</h3></td>';
        }
        $result .= '</tr>';
        return $result;
    }
}
