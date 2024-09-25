<?php
session_start();
require_once('Models/UserData.php');
require_once "Models/Database.php";
require_once "Models/FriendData.php";
class UserLocation
{
    protected $connectedDbs;
    public function __construct()
    {
        $newDbs = new Database();
        $this->connectedDbs = $newDbs->getTheDbs();
    }
    //update current user location on database
    function updateMyLocation($currentUserID, $updateLat, $updateLong)
    {
        //echo $currentUserID;
        //echo $updateLat;
        //echo $updateLong;
        $intID = intval($currentUserID);
        $floatLat = floatval($updateLat);
        $floatLng = floatval($updateLong);
        try{
            //update Location
            $updateLocation = "UPDATE `users` SET lat = $floatLat, lng = $floatLng WHERE (id = '$intID')";
            //$sqlQ = $this->connectedDbs->query($updateLocation);
            $sqlQ = $this->connectedDbs->prepare($updateLocation);
            $sqlQ->execute();
            //echo  $updateLocation;
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    //get current user friends
    function getFriendsLocationData($currentUser)
    {
        $sqlQuery = "SELECT * FROM (
                                    SELECT *
                                    FROM users 
                                    where users.id in (
                                    select friend1 as friend
                                    from friends
                                    where (friends.friend1 = $currentUser or friends.friend2 = $currentUser)
                                    union 
                                    select friend2 as friend
                                    from friends
                                    where (friends.friend1 = $currentUser or friends.friend2 = $currentUser)
                                    )
                    and users.id != $currentUser
                ) ping inner join friends where ((friend1=ping.id and friend2=$currentUser) or (friend1=$currentUser and friend2=ping.id))";
        //echo "<br/>" . $sqlQuery;
        $statement = $this->connectedDbs->prepare($sqlQuery);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}