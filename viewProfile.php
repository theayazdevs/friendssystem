<?php
    require_once 'Models/FriendDataSet.php';
    $friendObj = new FriendDataSet();
    $userObj = $friendObj->getCurrentUser();
    $currentUserID = $_SESSION['user_id'];
    //echo $currentUserID;
    $viewID = $_GET['id'];
    //echo "<h1>Viewing ID : " . $viewID . "</h1>";
    $userData = [];
    if (isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
        $reqNumber= $friendObj->getRequestsNum($_SESSION['user_id']);
        if (isset($_GET['id'])) {
            $userData = $userObj->findUserById($_GET['id']);
            if ($userData === false) {
                header('Location: profile.php');
                exit;
            }
            else
            {
                if ($userData['id'] == $_SESSION['user_id']) {
                    header('Location: profile.php');
                    exit;
                }
            }
        }
    }
    else {
        header('Location: logout.php');
        exit;
    }
    require_once ('Views/viewProfile.phtml');