<?php
class LoginAuthModel {

    public static function checkAccount($usn, $pwd) {
        // Database connection
        $database = DatabaseModel::initConnections();
        $connection = DatabaseModel::getMainConnection();

        // Process of querying data
        $sql = "SELECT id, hash_id, `bin_active`, `uni_active`, `uniparent`
					FROM `accounts` 
				WHERE `username`=:username 
					AND `pass`=:password LIMIT 1";
        $prepare = $database->mysqli_prepare($connection, $sql);
        $database->mysqli_execute($prepare, array(
            ':username'=>$usn,
            ':password'=>$pwd
        ));

        // Get the matched data from the database
        $result = $database->mysqli_fetch_assoc($prepare);

        // Return false when the username/password is wrong
        if (count($result) < 1)
            return false;

        $resultArray = $result[0];

        // Save the Full name as the primary account information
        self::saveFullName($resultArray["id"]);

        // Return the user id from the database
        return $resultArray;
    }


    public static function saveFullName($ID){
	    // Database connection
	    $database = DatabaseModel::initConnections();
	    $connection = DatabaseModel::getMainConnection();

	    /// Process of querying data
        $sql = "SELECT `fn`, `ln` FROM `account_info` WHERE `accnt_id`=:userID LIMIT 1";
        $prepare = $database->mysqli_prepare($connection, $sql);
        $database->mysqli_execute($prepare, array(
	        ':userID'=>$ID
        ));

        // Get the matched data from the database
        $result = $database->mysqli_fetch_assoc($prepare);

        // Return false when the username/password is wrong
        if (count($result) < 1)
	        return false;

        SessionModel::setName($result[0]["fn"], $result[0]["ln"]);
    }
}
    