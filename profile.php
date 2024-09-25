<?php
    //initializing all the classes required
    //require_once 'Models/Friend.php';
    require 'Models/FriendDataSet.php';
    $friendObj = new FriendDataSet();
    $currenUserObj = $friendObj->getCurrentUser();
    //array to store the search results
    $searchResults = [];
    //get the ID of the user from current session
    //$currentUserID = $currenUserObj->getSession()['user_id'];
    $currentUserID = $_SESSION['user_id'];
    //echo '<h1>User ID: '.$currentUserID.'</h1>';
    //echo '<h1>User Email: '.$currenUserObj->getSession()['email'].'</h1>';
    //check user id and email in the current session are not null before proceeding
    //session has been created in the user authentication function in User class
    //if (isset($currenUserObj->getSession()['user_id']) && isset($currenUserObj->getSession()['email'])) {
    if (isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
        //echo '<br>User ID and Email exist in the session<br>';
        //getting and storing the details for the logged-in user
        $userData = $currenUserObj->findUserById($_SESSION['user_id']);
        //echo  '<h1>User Image location: '.$userData['user_image'].'</h1>';
        //if no user details found, then logout
        if ($userData === false) {
            header('Location: logout.php');
            //echo 'user not found or error in find user by id function in User > or user logged out';
            exit;
        }
        //get other registered users from the database
        $allUsers = $currenUserObj->allUsers($_SESSION['user_id']);
        $reqNumber= $friendObj->getRequestsNum($_SESSION['user_id']);
        //var_dump($allUsers);
        //if search button is pressed
        if (isset($_GET['submitSearch'])) {
            //get the search value
            $searchValue = $_GET['txtSearch'];
            //echo "<h1>going to search method</h1>";
            //echo "<h1>Search value is: ".$searchValue."</h1>";
            $searchResults = $currenUserObj->searchUsers($searchValue);
        }
    }
    else {
    //no user session is found, so logout
    header('Location: logout.php');
    echo "User not found, error > user id and email do not exist in session";
    exit;
    }
    require_once ('Views/profile.phtml');
    //echo '<h1>profile phtml ends here</h1>';
