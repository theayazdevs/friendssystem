<?php
require_once "Models/Database.php";
class LiveSearch
{
    protected $connectedDbs;
    public function __construct()
    {
        $newDbs = new Database();
        $this->connectedDbs = $newDbs->getTheDbs();
    }
    //function to get the search results based on the query and filters
    public function liveSeacrh($searchQuery)
    {
            //searching for match, with  %----%, will fetch all data containing %text%
            //separating search query and the filters
            $searchAndFilter = explode("," ,$searchQuery);
            $searchTerm = $searchAndFilter[0];
            $searchFilter = $searchAndFilter[1];
            //first name filter
            if($searchFilter=="a") {
                $firstNameQuery = "SELECT id,firstName,lastName,email,userImage,username FROM users WHERE firstName LIKE '$searchTerm'";
                //echo "<br/>".$sqlQuery;
                $searchResult = $this->connectedDbs->prepare($firstNameQuery);
                $searchResult->execute();
            }
            //last name filter
            elseif ($searchFilter=="b")
            {
                $lastNameQuery = "SELECT id,firstName,lastName,email,userImage,username FROM users WHERE lastName LIKE '$searchTerm'";
                //echo "<br/>".$sqlQuery;
                $searchResult = $this->connectedDbs->prepare($lastNameQuery);
                $searchResult->execute();
            }
            //email filter
            elseif ($searchFilter=="c")
            {
                $emailQuery = "SELECT id,firstName,lastName,email,userImage,username FROM users WHERE email LIKE '$searchTerm'";
                //echo "<br/>".$sqlQuery;
                $searchResult = $this->connectedDbs->prepare($emailQuery);
                $searchResult->execute();
            }
            //username filter
            elseif ($searchFilter=="d")
            {
                $usernameQuery = "SELECT id,firstName,lastName,email,userImage,username FROM users WHERE username LIKE '$searchTerm'";
                //echo "<br/>".$sqlQuery;
                $searchResult = $this->connectedDbs->prepare($usernameQuery);
                $searchResult->execute();
            }
            //all filter
            elseif ($searchFilter=="all")
            {
                $allQuery = "SELECT id,firstName,lastName,email,userImage,username FROM users WHERE firstName LIKE '%$searchTerm%' OR 
                                                                                            lastName LIKE '%$searchTerm%' OR
                                                                                        email LIKE '%$searchTerm%' OR 
                                                                                    username LIKE '%$searchTerm%'";
                //echo "<br/>".$sqlQuery;
                $searchResult = $this->connectedDbs->prepare($allQuery);
                $searchResult->execute();
            }

            $sendResults = $searchResult->fetchAll(PDO::FETCH_ASSOC);
            //if more than zero return
            if ($searchResult->rowCount() > 0) {
                return $sendResults;
            } else {
                //no results, return null
                return null;
            }
    }
}