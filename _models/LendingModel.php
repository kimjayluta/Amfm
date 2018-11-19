<?php
class LendingModel {

	public static function loanInfo(){
		// Database connection
		$database = DatabaseModel::initConnections();
		$connection = DatabaseModel::getMainConnection();

		// Process of querying data
		$sql = "SELECT `loan_type`, `loan_balance`, `maturity_date` FROM `loan` WHERE `cid`=:USER_ID LIMIT 1";
		$prepare = $database->mysqli_prepare($connection, $sql);
		$database->mysqli_execute($prepare, array(
			':USER_ID'=>SessionModel::getUserID()
		));

		// Get the matched data from the database
		$result = $database->mysqli_fetch_assoc($prepare);

		// Return false when the username/password is wrong
		if (count($result) < 1)
			return false;

		$resultArray = $result[0];

		switch ($resultArray["loan_type"]){
			case "b":
				$resultArray["loan_type"] = "Bronze Package";
				break;
			case "s":
				$resultArray["loan_type"] = "Silver Package";
				break;
			case "g":
				$resultArray["loan_type"] = "Gold Package";
				break;
			case "d":
				$resultArray["loan_type"] = "Diamond Package";
				break;
			case "v":
				$resultArray["loan_type"] = "VIP Package";
				break;
			default:
				$resultArray["loan_type"] = "Bronze Package";
				break;
		}

		// Return the user id from the database
		return $resultArray;
	}
}