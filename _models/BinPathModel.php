<?php
class BinPathModel {
    public static function checkReference(String $ref){
	    // Database connection
	    $database = DatabaseModel::initConnections();
	    $connection = DatabaseModel::getMainConnection();

	    // Process of querying data
	    $sql = "SELECT `id`  FROM `accounts` WHERE `hash_id`=:REF LIMIT 1";
	    $prepare = $database->mysqli_prepare($connection, $sql);
	    $database->mysqli_execute($prepare, array(":REF"=> $ref));

	    // Get the matched data from the database
	    $result = $database->mysqli_fetch_assoc($prepare);

	    // Return false when the reference provided is wrong
	    if (count($result) < 1)
		    return false;

	    $resultArray = $result[0];

	    // Make sure the provided reference is not the user's hash id by checking the resulted id
	    if ($resultArray["id"] === SessionModel::getUserID())
	    	return false;

	    // Return the user id from the database
	    return $resultArray["id"];
    }

    public static function checkPendingPath(){
		// Check the status of the account according to its session id
	    // Database connection
	    $database = DatabaseModel::initConnections();
	    $connection = DatabaseModel::getMainConnection();

	    // Process of querying data
	    $sql = "SELECT `invitee_id`, `username` FROM `pending_binpath` pbp 
					LEFT JOIN accounts a ON pbp.`invitee_id`=a.id
				 WHERE `invitor_id` = :USER_ID";
	    $prepare = $database->mysqli_prepare($connection, $sql);
	    $database->mysqli_execute($prepare, array(
		    ":USER_ID" => SessionModel::getUserID()
	    ));

	    // Get the matched data from the database
	    $result = $database->mysqli_fetch_assoc($prepare);

	    // Return false when there is no result found
	    if (count($result) < 1)
		    return false;

	    // Return the user id and hash from the database
	    return json_encode($result, JSON_PRETTY_PRINT);
    }

	/**
	 * Check the current user if it has a pending request
	 * @return bool
	 */
    public static function checkOnPending(){
	    // Database connection
	    $database = DatabaseModel::initConnections();
	    $connection = DatabaseModel::getMainConnection();

	    // Process of querying data
	    $sql = "SELECT `a`.`hash_id` AS `hash` FROM `pending_requests` pr 
					LEFT JOIN `accounts` a ON `a`.id=`pr`.parent_id 
				WHERE `pr`.`type`='binary' AND `pr`.`user_id`=:USER_ID LIMIT 1";
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
	    return $result[0]["hash"];
    }

	/**
	 * Add to the pending List
	 * @param String $parentID
	 * @return bool
	 */
    public static function addPending(String $parentID){
	    // Database connection
	    $database = DatabaseModel::initConnections();
	    $connection = DatabaseModel::getMainConnection();

	    try {
		    // Save the account auth data
		    $prepared = $database->mysqli_prepare($connection, "
                INSERT INTO `pending_requests`(`user_id`, `parent_id`) 
                		VALUES (:USER_ID, :PARENT_ID);
            ");

		    $database->mysqli_execute($prepared, array(
			    ":USER_ID" => SessionModel::getUserID(),
			    ":PARENT_ID" => $parentID
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

    public static function removePending(){
		// DELETE FROM DATABASE algorithm
	    // Database connection
	    $database = DatabaseModel::initConnections();
	    $connection = DatabaseModel::getMainConnection();

	    try {
		    // Save the account auth data
		    $prepared = $database->mysqli_prepare($connection, "
                DELETE FROM `pending_requests` WHERE `type`='binary' AND `user_id`=:USER_ID;
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

    public static function addNode($parent, $id, bool $left){
	    $database = DatabaseModel::initConnections();
	    $connection = DatabaseModel::getMainConnection();

	    $database->mysqli_begin_transaction($connection);

	    /**
	     * We will need to wrap our queries inside a TRY / CATCH block.
	     * That way, we can rollback the transaction if a query fails and a PDO exception occurs.
	     * Our catch block will handle any exceptions that are thrown.
	     */
	    try {

		    // Start executing the deletion in the binpath
		    $prepared = $database->mysqli_prepare($connection,
			    "DELETE FROM `pending_binpath` WHERE `invitee_id`=:USER_ID AND `invitor_id`=:LOGGED_ID;"
		    );

		    $database->mysqli_execute($prepared, array(
			    ":USER_ID" => $id,
			    ":LOGGED_ID" => SessionModel::getUserID()
		    ));

		    // Start executing the the insertion in the path
		    $prepared = $database->mysqli_prepare($connection, "
              INSERT INTO `binpath`(`anc`, `desc`, `parent`, `lside`)
				(SELECT `anc`, :USER_ID AS `desc`, :PARENT_ID AS `parent`, :LEFT_SIDE FROM `binpath` WHERE `desc`=:PARENT_ID) 
					UNION
 				(SELECT :USER_ID AS `enc`, :USER_ID AS `desc`, :PARENT_ID AS `parent`, 1) 
 					ON DUPLICATE KEY UPDATE `parent`= :PARENT_ID;
            ");


		    $database->mysqli_execute($prepared, array(
				":USER_ID" => $id,
			    ":PARENT_ID" => $parent,
			    ":LEFT_SIDE" => !$left
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

    public static function selectNodes(){
	    // Database connection
	    $database = DatabaseModel::initConnections();
	    $connection = DatabaseModel::getMainConnection();

	    // Process of querying data
	    $sql = "SELECT a.username, a.id, b.lside, b.parent FROM `accounts` a 
			JOIN `binpath` b
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
		$nodeList = array();    // Node Child Counts

	    foreach($nodeData as $nodes){
	    	if (!isset($nodeList[$nodes["id"]])){
			    $nodeList[$nodes["id"]] = 0; // default 0 for the children Nodes
		    }

		    // Increment the parent
		    $nodeList[$nodes["parent"]] += 1;
	    }

	    // Generating a node Data config
	    function addNodeArr(String $parent){
		    return array(
			    "image" => "img/plus-logo.png",
			    "HTMLclass" => "add-person",
			    "parentId" => "a_".$parent,
			    "text" => array(
				    "data-toggle" => "modal",
				    "data-target" => "#addPerson",
				    "data-parent" => $parent
			    )
		    );
	    }

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

		    // Add 1 plus button and sort dependent to the lside if it has 1 child according to node list count
		    if (intval($nodeList[$nodes["parent"]]) == 1){
		    	// Left or Right Positioning
			    if (!$nodes["lside"]){

				    // Remove the last element, add the plus button first, then the person
				    array_push($jsonArr, addNodeArr($nodes["parent"]));
				    array_push($jsonArr, $personNode);
			    }else{
				    $rightNode = addNodeArr($nodes["parent"]);
				    $rightNode["text"]["data-r"] = "true";

				    array_push($jsonArr, $personNode);
				    array_push($jsonArr, $rightNode);
			    }
		    }else{

			    // Normally add the person if has no person or has 2 person
			    array_push($jsonArr, $personNode);
		    }

		    // Add 2 plus buttons to the nodes that does not have a children according to node list count
		    if (intval($nodeList[$nodes["id"]]) == 0){
			    $rightNode = addNodeArr($nodes["id"]);
			    $rightNode["text"]["data-r"] = "true";

			    array_push($jsonArr, addNodeArr($nodes["id"]));
			    array_push($jsonArr, $rightNode);
		    }

	    }

	    // Encode the the JSON the plot to the Javascript Graph
		return json_encode($jsonArr,JSON_PRETTY_PRINT);
    }
}