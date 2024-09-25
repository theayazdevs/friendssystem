<?php
require ('Models/UserDataSet.php');
require ('Models/FriendData.php');
class FriendDataSet extends UserDataSet
{
    //fields that store the current database connection, and user
    protected $getConnectedDbs;
    protected $forUser;
    //constructor
    public function __construct()
    {
        $this->forUser = new UserDataSet();
        $this->getConnectedDbs = $this->forUser->connectedDbs;
    }
    //get the current user
    public function getCurrentUser()
    {
        return $this->forUser;
    }
    //return all users stored in database in friends table
    public function fetchAllUserFriends($currentUser)
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
        $statement = $this->getConnectedDbs->prepare($sqlQuery);
        $statement->execute();
        //get the result as an object
        //$allFriends = $statement->fetchAll(PDO::FETCH_OBJ);
        //echo "<br/>Query Run Result<br/>";
        //echo '<pre>' , var_dump($allFriends) , '</pre>';
        //return $allFriends;
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new FriendData($row);
        }
        return $dataSet;
    }
    public function isAlreadyFriend($friendID, $currentUserID)
    {
        $sqlQuery = "SELECT * FROM friends WHERE (friend1 = '$friendID' AND friend2 = '$currentUserID') 
                         OR (friend1 = '$currentUserID' AND friend2 = $friendID )";
        $statement = $this->getConnectedDbs->prepare($sqlQuery);
        $statement->execute();
        //get the results as an associative array
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        //counting rows to make sure only 1 row is returned, for the user being checked for friend status
        $rowCount = $statement->rowCount();
        //var_dump($row);
        //var_dump($rowCount);
        //strict comparison, same value, same data type
        if($rowCount === 1)
        {
            //status one means, not a friend
            if($row['status']==1)
            {
                //echo "Not a Friend : show add friend button";
                return 1;
            }
            //status 2 means, a friend
            else if($row['status']==2)
            {
                //echo "Friend : show remove friend button";
                return 2;
            }
            //status 3 means, request pending
            else if($row['status']==3)
            {
                //echo "Friend Request is sent : Pending";
                return 3;
            }
        }
        //anything else, is not a friend
        else
        {
            //echo "Not a Friend : show add friend button";
            return 1;
        }
    }
    //send the friend request from current user to the desired user
    public function sendFriendRequest($senderID, $recieverID)
    {
        try{
            //inserting a new row in database, with friends to be and status 3
            $sql = "INSERT INTO `friends`(friend1, friend2, status) VALUES(?,?,?)";
            $stmt = $this->getConnectedDbs->prepare($sql);
            $stmt->execute([$senderID, $recieverID, 3]);
            //echo '<pre>' , var_dump($stmt->execute([$senderID, $recieverID, 3])) , '</pre>';
            //redirecting to the friend to be view page, using HTTP response header and location
            header('Location: viewProfile.php?id='.$recieverID);
            exit;
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    //accept the friend request
    public function acceptFriendRequest($currentUserID, $senderID)
    {
        try{
//change the status of the user wanting to be friends to 2
            $toFriends = "UPDATE `friends` SET status = 2 WHERE (friend1 = '$currentUserID' AND friend2 = '$senderID') OR (friend1 = '$senderID' AND friend2 = '$currentUserID')";
            $toFriends = $this->getConnectedDbs->prepare($toFriends);
            $toFriends->execute();
            if($toFriends->execute()){
                //redirect the user, to update the current page
                header('Location: requests.php');
                //header('Location: viewProfile.php?id='.$senderID);

                exit;

            }
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    //remove a friend or friend request
    public function removeFriend($currentUserID, $senderID)
    {
        try{
//delete the row where the user removes a friend or ignores a friend request in the friends table
            $removePending = "DELETE FROM `friends` WHERE (friend1 = '$currentUserID' AND friend2 = '$senderID') OR (friend1 = '$senderID' AND friend2 = '$currentUserID')";
            $removePending = $this->getConnectedDbs->prepare($removePending);
            $removePending->execute();
            if($removePending->execute()){
                //redirect
                header('Location: requests.php');
                //header('Location: viewProfile.php?id='.$senderID);
                exit;

            }
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    //get all the user sent requests
    public function sentRequests($currentUser){
        try{
            //get the requests sent by the current user
            $sql = "SELECT * FROM `friends` WHERE friend1 = ? AND status = 3";
            $stmt = $this->getConnectedDbs->prepare($sql);
            $stmt->execute([$currentUser]);
            $allRecieved = $stmt->fetchAll(PDO::FETCH_OBJ);
            //echo "<br/>Query Run Result<br/>";
            //echo '<pre>' , var_dump($allRecieved) , '</pre>';
            return $allRecieved;
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    //get all the received requests
    public function receivedRequests($currentUser){

        try{
            //get the received requests by the current user
            $sql = "SELECT * FROM `friends` WHERE friend2 = ? AND status = 3";
            $stmt = $this->getConnectedDbs->prepare($sql);
            $stmt->execute([$currentUser]);
            //fetch all rows as an object
            $allRecieved = $stmt->fetchAll(PDO::FETCH_OBJ);
            // echo '<pre>' , var_dump($allRecieved) , '</pre>';
            return $allRecieved;
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    //function to get all the received friend requests total number
    public function getRequestsNum($currentUser)
    {
        $allRequests =  $this->receivedRequests($currentUser);
        //echo '<prev>',var_dump($allRequests),'</prev>';
        $reqNumber = count((array)$allRequests);
        //echo '<prev>',var_dump($reqNumber),'</prev>';
        return $reqNumber;
    }
}