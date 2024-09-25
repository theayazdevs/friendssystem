<?php
    require_once 'Models/FriendDataSet.php';
    $friendObj = new FriendDataSet();
    $currenUser = $friendObj->getCurrentUser();;
    $resultRows = [];
    //$currentUserID = $currenUser->getSession()['user_id'];
    $currentUserID = $_SESSION['user_id'];
    //echo '<h1>User ID: '.$currentUserID.'</h1>';
    //echo '<h1>User Email: '.$currenUser->getSession()['email'].'</h1>';
    if (isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
        //echo '<br>User ID and Email exist in the session<br>';
        $userData = $currenUser->findUserById($_SESSION['user_id']);
        //echo  '<h1>User Image location: '.$user_data['user_image'].'</h1>';
        if ($userData === false) {
            header('Location: logout.php');
            //echo 'user not found or error in find user by id function in User > or user logged out';
            exit;
        }
        //get other registered users from the database
        $allUsers = $currenUser->allUsers($_SESSION['user_id']);
        $reqNumber= $friendObj->getRequestsNum($_SESSION['user_id']);
        //var_dump($allUsers);
    }
    else {
        header('Location: logout.php');
        //echo "User not found, error> because user id and email do not exist in session";
        exit;
    }
    require_once 'Views/requests.phtml';
