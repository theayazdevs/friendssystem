<?php
require 'Models/UserLocation.php';
//new user location object
$theUserLocation = new UserLocation();
//value recieved from the AJAX call
$received = $_REQUEST["q"];
//separating the comma values into an array
$methodArguments = explode(",", $received);
//calling the location updater function
$theUserLocation->updateMyLocation($methodArguments[0],$methodArguments[1],$methodArguments[2]);
//echo $theUserLocation[0];
//echo $theUserLocation[1];
//echo $theUserLocation[2];
//receiving current user's friend data
$friendsLocationData = $theUserLocation->getFriendsLocationData($methodArguments[0]);
//encoding friend data into a JSON data format
echo json_encode($friendsLocationData);
//echo "Location UPDATED on Database successfully!" ;
