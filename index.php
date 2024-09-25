<?php
//require_once 'Models/User.php';
require_once 'Models/UserDataSet.php';
//$loginUser = new User();
$loginUser = new UserDataSet();
$resultRows = [];
$searchValue = "";
//check if email and password have been supplied
if (isset($_POST['email']) && isset($_POST['password'])) {
    //echo $_POST['email'].'<br>';
    //$loginUser->userLogin($_POST['email'],$_POST['password']);
    $loginError = $loginUser->userLogin($_POST['email'], $_POST['password']);
    if ($loginError == 1) {
        echo '<div class="alert alert-danger text-center">
                    <strong class="mx-2">Password is incorrect!</strong>
              </div>';
    } elseif ($loginError == 2) {
        echo '<div class="alert alert-danger text-center">
                    <strong class="mx-2">Incorrect or unregistered Email!</strong>
              </div>';
    }
}
//if submit search has been pressed
if (isset($_GET['submitSearch'])) {
    //whatever the user want sto search is stored in the variable
    $searchValue = $_GET['txtSearch'];
    //echo "<h1>Going to search method</h1>";
    //echo "<h1>Search value is: ".$searchValue."</h1>";
    //the search value is passed to the function search users
    $resultRows = $loginUser->searchUsers($searchValue);
    //echo "<h1>Result from user method: ".$resultRows."</h1>";
}
//if session exists and the email is not null, send to profile page
if (isset($_SESSION['email'])) {
    header('Location: profile.php');
    //echo '<h1>current user email is:'.$_SESSION['email'].'</h1>';
    exit;
}
//$allUsers = [];
$allUsers = $loginUser->allUsers(0);
require_once('Views/index.phtml');
