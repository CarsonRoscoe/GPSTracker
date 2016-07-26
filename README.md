# GPSTracker

GPSTracker is a application/server/webapp combo created with the intention of gathering GPS data from mobile devices, sending it to a server and having that data be populated on a apache hosted webapp for users to view the data of themselves/other users at a later date.

GPSTracker is split into three componenets: The Java Android client app, the Java socket server and the PHP Apache hosted Webapp.

# Apache WebApp

PHP Apache WebApp written using the CodeIgniter framework and GoogleMaps API. The WebApp allows users to visually see on a map where they have been, as well as other users of the application. The WebApp requires users to log in in order to use.

# Android APP

Java Android client application used for communicating your current GPS positions to the Java socket server. The app utilizes the TCP/IP protocol suite to send updates every few minutes, or every time you change locations.

# Java Server 

Java socket server used to gather GPS coordinate updates from Android clients and store these updates in a SQL database that is accessible by the Apache WebApp.
