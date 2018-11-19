<?php

class AcctManagementModel {


	public static function getInfo(){
		// Database connection
		$database = DatabaseModel::initConnections();
		$connection = DatabaseModel::getMainConnection();

		// Process of querying data
		$sql = "SELECT `username`, `ad`, `email`, `photo`, `cn`, `bdate`, `fn`, `ln` 
					FROM `accounts` a
				LEFT JOIN `account_info` ai ON ai.`accnt_id`=a.`id`
				WHERE a.`id`=:USER_ID  LIMIT 1";

		$prepare = $database->mysqli_prepare($connection, $sql);
		$database->mysqli_execute($prepare, array(
			":USER_ID"=> SessionModel::getUserID()
		));

		// Get the matched data from the database
		$result = $database->mysqli_fetch_assoc($prepare);

		// Return false when the reference provided is wrong
		if (count($result) < 1)
			return false;

		$resultArray = $result[0];

		// Return the array from the database
		return $resultArray;
	}


	public static function changeBasicInfo($fname, $lname, $cnumber, $bdate, $address){
		// Database connection
		$database = DatabaseModel::initConnections();
		$connection = DatabaseModel::getMainConnection();

		try {
			// Save the account auth data
			$prepared = $database->mysqli_prepare($connection, "
				UPDATE `account_info` SET 
			    	`fn`=:FIRST_NAME,
	                `ln`=:LAST_NAME,
	                `ad`=:ADDRESS,
	                `cn`=:CONTACT_NUM,
	                `bdate`=:BDATE  WHERE `accnt_id`=:USER_ID
		    	");

			$database->mysqli_execute($prepared, array(
				":USER_ID" => SessionModel::getUserID(),
				":FIRST_NAME" => $fname,
				":LAST_NAME" => $lname,
				":CONTACT_NUM" => $cnumber,
				":BDATE" => $bdate,
				":ADDRESS" => $address
			));

			return true;
		} catch(Exception $e){
			/**
			 * An exception has occured, which means that one of our database queries
			 * failed. Print out the error message.
			 */
			echo $e->getMessage();
			return false;
		}
	}


	public static function changePrimaryInfo($username, $email){
		// Database connection
		$database = DatabaseModel::initConnections();
		$connection = DatabaseModel::getMainConnection();

		$database->mysqli_begin_transaction($connection);

		try {
			// Save the account auth data
			$prepared = $database->mysqli_prepare($connection, "
				UPDATE `account_info` SET `email`=:EMAIL WHERE `accnt_id`=:USER_ID
	        ");

			$database->mysqli_execute($prepared, array(
				":USER_ID" => SessionModel::getUserID(),
				":EMAIL" => $email
			));

			$prepared = $database->mysqli_prepare($connection, "
				UPDATE `accounts` SET `username`=:USERNAME WHERE `id`=:USER_ID
			");

			$database->mysqli_execute($prepared, array(
				":USER_ID" => SessionModel::getUserID(),
				":USERNAME" => $username
			));

			// Commit the changes when no error found.
			$database->mysqli_commit($connection);
			return true;

		} catch(Exception $e){
			/**
			 * An exception has occured, which means that one of our database queries
			 * failed. Print out the error message.
			 */
			echo $e->getMessage();


			//Rollback the transaction.
			$database->mysqli_rollback($connection);
			return false;
		}
	}

	public static function changePassword($password, $oldPassword){
		// Database connection
		$database = DatabaseModel::initConnections();
		$connection = DatabaseModel::getMainConnection();

		try {
			// Save the account auth data
			$prepared = $database->mysqli_prepare($connection, "
				UPDATE `accounts` SET `pass`=:NEW_PASSWORD WHERE `id`=:USER_ID AND `pass`=:OLD_PASSWORD;
			");

			$database->mysqli_execute($prepared, array(
				":USER_ID" => SessionModel::getUserID(),
				":NEW_PASSWORD" => $password,
				":OLD_PASSWORD" => $oldPassword
			));

			return true;
		} catch(Exception $e){
			/**
			 * An exception has occured, which means that one of our database queries
			 * failed. Print out the error message.
			 */
			echo $e->getMessage();
			return false;
		}
	}
}