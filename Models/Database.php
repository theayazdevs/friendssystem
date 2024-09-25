<?php

class Database
{
    private $databaseConn;
    public function __construct()
    {
        //setting up the connection with the database
        try {
            //host name, database name, username, and password is supplied
            $host = "je6.h.filess.io";
            $dbName = "friendsusers_aloudrope";
            $user = "friendsusers_aloudrope";
            $pass = "e2578f0af64960feb6b0fdce43672cabdf661a20";
            /*$host = "localhost";
            $dbName = "friendssystem";
            $user = "root";
            $pass = "";*/
            //using PHP PDO to connect to the database
            $this->databaseConn = new PDO("mysql:host=$host; port=3307; dbname=$dbName", $user, $pass);
            // Check connection (error handling)
            $this->databaseConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            /*if ($this->databaseConn == true) {
                echo '<h1>Database Connected Successfully!</h1>';
            }
            else
            {
                echo '<h1>Sorry, Database did not Connect!</h1>';
            }*/
        } catch (PDOException $pdoEx) {
            echo "Database Connection Error: " . $pdoEx->getMessage() . "<br/>";
            die();
        }
    }
    //function no return the database instance that is created in this class
    public function getTheDbs()
    {
        if ($this->databaseConn instanceof PDO) {
            return $this->databaseConn;
            //close connection
            //$databaseConn = null;
        }
    }
}
