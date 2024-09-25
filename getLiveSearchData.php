<?php
require 'Models/LiveSearch.php';
$liveSearcher = new LiveSearch();
//received search term and filter
$receivedQuery = $_REQUEST["s"];
//remove any space from around the string
$receivedQuery = trim($receivedQuery);
//pass search query to live search function
$liveResults = $liveSearcher->liveSeacrh($receivedQuery);
//if not null, return search results in a JSON format
if($liveResults!=null) {
    echo json_encode($liveResults);
    //echo  $receivedQuery;
}
else
{
    //to handle error messages
    echo "None";
}
//$receivedQuery = $_REQUEST["s"];
//echo "getting data from DBS... recieved query: " . $receivedQuery;