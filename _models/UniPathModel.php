<?php
class UniPathModel {

	/**
	 * Check the current user if it has a pending request
	 * @return bool
	 */
	public static function checkOnPending(){
		// Database connection
		$database = DatabaseModel::initConnections();
		$connection = DatabaseModel::getMainConnection();

		// Process of querying data
		$sql = "SELECT u.`packg_type` AS `packg` FROM `pending_requests` pr 
					LEFT JOIN `uni_packg` u ON u.tid=`pr`.id 
				WHERE `pr`.`type`='unilevel' AND `pr`.`user_id`=:USER_ID LIMIT 1";
		$prepare = $database->mysqli_prepare($connection, $sql);
		$database->mysqli_execute($prepare, array(
			":USER_ID" => SessionModel::getUserID()
		));

		// Get the matched data from the database
		$result = $database->mysqli_fetch_assoc($prepare);

		// Return false when the reference provided is wrong
		if (count($result) < 1)
			return false;

		// Return the package type from the database
		switch ($result[0]["packg"]){
			case 'b':
				return "Bronze Package";
				break;
			case 's':
				return "Silver Package";
				break;
			case 'g':
				return "Gold Package";
				break;
			case 'd':
				return "Diamond Package";
				break;
			case 'v':
				return "VIP Package";
				break;
			case 'p';
				return "Personal Package";
				break;
			default;
				return "Bronze Package";
				break;
		}
	}

    public static function addPending(String $loanType){
	    // Database connection
	    $database = DatabaseModel::initConnections();
	    $connection = DatabaseModel::getMainConnection();

	    $database->mysqli_begin_transaction($connection);

	    try {
		    // Save the account auth data
		    $prepared = $database->mysqli_prepare($connection, "
                INSERT INTO `pending_requests`(`user_id`, `parent_id`, `type`) 
                		VALUES (:USER_ID, :PARENT_ID, 'unilevel');
            ");

		    $database->mysqli_execute($prepared, array(
			    ":USER_ID" => SessionModel::getUserID(),
			    ":PARENT_ID" => SessionModel::getParentID()
		    ));

		    // Save the insert id
		    $id = $database->mysqli_insert_id($connection);

		    // Save the account auth data
		    $prepared = $database->mysqli_prepare($connection, "
               INSERT INTO `uni_packg`(`tid`, `packg_type`) VALUES (:TID, :PACKG_TYPE)
            ");

		    $database->mysqli_execute($prepared, array(
			    ":TID" => $id, ":PACKG_TYPE" => $loanType
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

	public static function removePending(){
		// DELETE FROM DATABASE algorithm
		// Database connection
		$database = DatabaseModel::initConnections();
		$connection = DatabaseModel::getMainConnection();

		try {
			// Save the account auth data
			$prepared = $database->mysqli_prepare($connection, "
                DELETE FROM `pending_requests` WHERE `type`='unilevel' AND `user_id`=:USER_ID;
            ");

			$database->mysqli_execute($prepared, array(
				":USER_ID" => SessionModel::getUserID(),
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

	public static function selectNodes(){
		// Database connection
		$database = DatabaseModel::initConnections();
		$connection = DatabaseModel::getMainConnection();

		// Process of querying data
		$sql = "SELECT a.username, a.id, b.parent FROM `accounts` a 
			JOIN `unipath` b
    			ON (a.id=b.`desc`)
    		WHERE b.anc = :USER_ID AND  a.id != :USER_ID";

		$prepare = $database->mysqli_prepare($connection, $sql);
		$database->mysqli_execute($prepare, array(
			":USER_ID" => SessionModel::getUserID()
		));

		// Get the matched data from the database
		$result = $database->mysqli_fetch_assoc($prepare);

		// Return false when the reference provided is wrong
		if (count($result) < 1)
			return false;

		// Return the user id and hash from the database
		return self::node2JSON($result);
	}

	private static function node2JSON(Array $nodeData){
		$jsonArr = array();     // JS friendly arrays

		// generate the JS Array
		foreach($nodeData as $nodes){
			// Person Node Configuration
			$personNode = array(
				"collapsed" =>  true,
				"image" => "img/person_icon.png",
				"HTMLid" => "a_".$nodes["id"],
				"parentId" => "a_".$nodes["parent"],
				"text" => array(
					"data-toggle" => "tooltip",
					"data-html" => true,
					"data-title" => "<b>Username: </b>".$nodes["username"],
				)
			);

			// Normally add the person if has no person or has 2 person
			array_push($jsonArr, $personNode);
		}

		// Encode the the JSON the plot to the Javascript Graph
		return json_encode($jsonArr,JSON_PRETTY_PRINT);
	}
}
