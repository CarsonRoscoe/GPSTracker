<!--
FILE: homepagetxt.php

DATE: March 10th, 2016

REVISIONS: March 20th, 2016: Commented

@programmer: Carson Roscoe

@designer: Carson Roscoe

NOTES: Home page HTML text to be drawn
-->
<h2>Welcome to GPSTracker!</h2>
<p>GPSTracker is a mobile social local solution for mobile users everywhere.</p>

<p>Using state of the art technology, we allow Android users to update their GPS locations live
    via our app, and then view their latest positions on our site.</p>

<p>We also allow you to see the locations of all other users of our app, however please be rest assured your data
    is securely kept in the most beautifully coloured plain-text database that money can buy.</p>

<?php
if ($this->session->userdata('logged_in')) {

} else {
    $result = '<div id="loginDiv">';
 $result .= '<form id="loginForm" method="post"action="/login">
                Username:<br>
                <input type="text" name="username"><br>
                Password:<br>
                <input type="password" name="password"><br>
                <input type="submit" value="Login">
            </form>';
                    $result .= '</div><div id="pageSelection"><ul>';

        $result .= '</div>';
        echo $result;
}
?>