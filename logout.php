<?php
    session_start();
    //destroying all the session variables.
    unset($_SESSION['user_id'],$_SESSION['email']);
    //destroying the session
    session_destroy();
    //redirect to log in page
    header("Location: index.php");
    exit;
