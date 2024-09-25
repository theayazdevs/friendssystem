<?php
    require_once 'Models/UserDataSet.php';
    $signupUser = new UserDataSet();
    //when the sign-up button is pressed
    if(isset($_POST['submit']))
    {
        $signupUser->profileCreator();
    }
    // check if user is already logged-in
    if(isset($_SESSION['email'])){
        header('Location: profile.php');
    }
    //echo "sign up page";
    require_once ('Views/registerUser.phtml');