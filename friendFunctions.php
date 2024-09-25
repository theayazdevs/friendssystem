<?php
    require_once ('Models/FriendDataSet.php');
    $friendObj = new FriendDataSet();
    $currentUserID = $_SESSION['user_id'];
    $viewID =  $_GET['id'];
    //when send request button is pressed
    if(isset($_POST["sndRequest"]))
    {
        //echo "Friend Request pressed ";
        //echo " Sending request to       -------------          ".$viewID;
        $friendObj->sendFriendRequest($currentUserID, $viewID);
    }
    //when remove friend or cancel request button is pressed
    elseif (isset($_POST["rmvFriend"]))
    {
        //echo "Remove Request pressed";
        $friendObj->removeFriend($currentUserID, $viewID);
    }
    //when accept request button is pressed
    elseif (isset($_POST["acceptRequest"]))
    {
        //echo "Accept request pressed</br>";
        //echo $viewID;
        $friendObj->acceptFriendRequest($currentUserID, $viewID);
    }
