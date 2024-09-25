<?php

class FriendData
{
    protected $_id, $_FirstName, $_LastName,$username, $_email, $_pwd, $userImage, $lat, $lng;
    protected $id, $friend1, $friend2, $status;

    public function __construct($dbRow)
    {
        $this->_id = $dbRow['id'];
        $this->_FirstName = $dbRow['firstName'];
        $this->_LastName = $dbRow['lastName'];
        $this->username = $dbRow['username'];
        $this->_email = $dbRow['email'];
        $this->_pwd = $dbRow['password'];
        $this->userImage = $dbRow['userImage'];
        $this->lat = $dbRow['lat'];
        $this->lng = $dbRow['lng'];
        $this->id = $dbRow['id'];
        $this->friend1 = $dbRow['friend1'];
        $this->friend2 = $dbRow['friend2'];
        $this->status = $dbRow['status'];
    }
    public function getUserID()
    {
        return $this->_id;
    }
    public function getFirstName()
    {
        return $this->_FirstName;
    }

    public function getLastName()
    {
        return $this->_LastName;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getEmail(){
        return $this->_email;
    }
    public function getPassword(){
        return $this->_pwd;
    }
    public function getUserImage(){
        return $this->userImage;
    }
    public function getLatitude(){
        return $this->lat;
    }
    public function getLongitude(){
        return $this->lng;
    }
    public function getID()
    {
        return $this->id;
    }
    public function getFriendOne()
    {
        return $this->friend1;
    }

    public function getFriendTwo()
    {
        return $this->friend2;
    }
    public function getStatus()
    {
        return $this->status;
    }
}