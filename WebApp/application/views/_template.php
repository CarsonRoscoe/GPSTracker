<!--
FILE: _template.php

DATE: March 10th, 2016

REVISIONS: March 20th, 2016: Commented
@programmer: Carson Roscoe
@designer: Carson Roscoe

NOTES: Our websites template. Every single page uses this as their packet.
The {tag}'s will be replaced with generated HTML from the proper controller.
-->
<?php
if (!defined('APPPATH'))
exit('No direct script access allowed');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>{pagetitle}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
        <!-- CSS  -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
        <link href="../assets/css/style.css" type="text/css" rel="stylesheet"/>
    </head>
    <body class="white">
        <main>
<!--         <header>
            <div id="header">
                <h2 id="pageHeader">{pageheader}</h2>
            </div>
        </header> -->
        <nav class="light-blue lighten-1" role="navigation">
            <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">{pageheader}</a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="/">Homepage</a></li>
                    <li><a href="/map">Map</a></li>
                    <?php
                    if ($this->session->userdata('logged_in')) {
                        $session_data = $this->session->userdata('logged_in');
                        $fullname = $this->clients->getClientNamesByUsername($session_data['username']);
                        echo '<li><a>Hi, ' . $fullname[0] . ' ' . $fullname[1] . '</a></li>';
                        echo '<li><a href="/logout">Logout</a></li>';
                    }
                     ?>
                </ul>
                <ul id="nav-mobile" class="side-nav">
                    <li><a href="/">Homepage</a></li>
                    <li><a href="/map">Map</a></li>
                    <?php
                    if ($this->session->userdata('logged_in')) {
                        $session_data = $this->session->userdata('logged_in');
                        $fullname = $this->clients->getClientNamesByUsername($session_data['username']);
                        echo '<li><a>Hi, ' . $fullname[0] . ' ' . $fullname[1] . '</a></li>';
                        echo '<li><a href="/logout">Logout</a></li>';
                    }
                     ?>
                </ul>
                <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
            </div>
        </nav>
        <!-- Page Content  -->
        <div class="section no-pad-bot" id="index-banner">
            <div class="container">
                <div class="row center">
                    <div>
                        <table id="titleTable">
                            <tr>
                                <td><h3>{contentTitle} {dropdownlist}</h3></td>
                            </tr>
                        </table>
                        <div id="contentDiv">
                            {content}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </main>
        <!-- Footer  -->
        <footer class="page-footer cyan darken-2">
            <div class="footer-copyright">
                <div class="container">
                    Copyright &copy; 2016 COMMIES.
                </div>
            </div>
        </footer>
        <!--  Scripts-->
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="../assets/js/materialize.js"></script>
        <script src="../assets/js/functions.js"></script>
    </body>
</html>