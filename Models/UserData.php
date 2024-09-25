<?php

class UserData
{
    protected $_id, $_FirstName, $_LastName,$username, $_email, $_pwd, $userImage, $lat, $lng;

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
    }
    public function jsonSerialize()
    {
        return [
                    '_id' => $this->_id,
                    '_username' => $this->username,
                    '_email' => $this->_email,
                    '_photo' => $this->userImage,
                    '_lat' => $this->lat,
                    '_lng' => $this->lng,
                ];
    }
    public function getID()
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
    //update current user location
    public function setLatitude($latUpdate){
         $this->lat = $latUpdate;
    }
    public function setLongitude($longUpdate){
         $this->lng = $longUpdate ;
    }
}