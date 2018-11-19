<?php
class SessionModel {
    // Start the Session
    public static function start(){
        if(session_status() != PHP_SESSION_ACTIVE){
            session_name("_sA");
            session_start();
        }
    }
    // Get the Login Status based on username
    public static function getLoginStatus(){
        self::start();
        return isset($_SESSION["username"], $_SESSION["userID"]);
    }
    // Restrict Logged User
    public static function restrictLogged(){
        self::start();
        // Disallow: User Visit if it is already logged in
        if (self::getLoginStatus()){
            header("location: /profile");
            exit;
        }
    }
    // Restrict Guest
    public static function restrictNotLogged(){
        self::start();
        // Disallow: User Visit if it is not yet logged in
        if (!self::getLoginStatus()){
            header("location: /login");
            exit;
        }
    }
    // Log a user
    public static function setUser(String $username, String $hash_id){
        self::start();
        $_SESSION["username"] = $username;
        $_SESSION["hash_id"] = $hash_id;
    }

    public static function setBinStatus(bool $status){
    	self::start();
		$_SESSION["bin_status"] = $status;
    }

    public static function setUniStatus(bool $status){
		self::start();
		$_SESSION["uni_status"] = $status;
    }

    // Log the users id
    public static function setID(String $userID){
        self::start();
        $_SESSION["userID"] = $userID;
    }

    // Log the user's name
    public static function setName(String $fn, String $ln){
        self::start();
        $_SESSION["name"] = $fn. " ".$ln;
    }

    // Log the user's invitor
    public static function setParentID(int $parentID){
        self::start();
        $_SESSION["uniparent"] = $parentID;
    }
	/* ======= END SETTERS ======= */


    /* ======= START GETTERS ======= */

    // Get Logged user
    public static function getUser(){
        self::start();
        return $_SESSION["username"];
    }
	// Get Logged Bin Status
    public static function getBinStatus(){
    	self::start();
    	return $_SESSION["bin_status"];
    }
    // Get Logged Uni Status
    public static function getUniStatus(){
    	self::start();
    	return $_SESSION["uni_status"];
    }
    // Get Logged User ID
    public static function getUserID(){
        self::start();
        return $_SESSION["userID"];
    }
    // Get Logged User ID
    public static function getName(){
        self::start();
        return ucwords($_SESSION["name"]);
    }
    // Get Logged Users Invitor
    public static function getParentID(){
        self::start();
        return ucwords($_SESSION["uniparent"]);
    }
    // Get Logged User HASHID
    public static function getHash(){
        self::start();
        return $_SESSION["hash_id"];
    }
    // Destroy the session
    public static function destroy(){
        self::start();
        // Destroy the current Session
        session_destroy();
    }
}
    