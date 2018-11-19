<?php
class RegisterAuthModel {

    public static function register($fn, $ln, $bd, $ad, $ea, $cn, $un, $pw){
        $database = DatabaseModel::initConnections();
        $connection = DatabaseModel::getMainConnection();

        $database->mysqli_begin_transaction($connection);

        /**
         * We will need to wrap our queries inside a TRY / CATCH block.
         * That way, we can rollback the transaction if a query fails and a PDO exception occurs.
         * Our catch block will handle any exceptions that are thrown.
         */
        try {
            // Save the account auth data
            $prepared = $database->mysqli_prepare($connection, "
                INSERT INTO `accounts`(`username`, `pass`, `hash_id`) 
                      VALUES (:username,:password, :hash_id);
            ");

            $database->mysqli_execute($prepared, array(
                ":username" => $un,
                ":password" => $pw,
	            ":hash_id" =>md5($un).time()
            ));

            // Save the insert id
            $id = $database->mysqli_insert_id($connection);

            // Start executing the account information
            $prepared = $database->mysqli_prepare($connection, "
              INSERT INTO `account_info`(`fn`, `ln`, `ad`, `email`, `photo`, `cn`, `accnt_id`, `bdate`) 
                  VALUES (:first_name, :last_name, :address, :email, NULL , :contact_num, :account_id, :birth_date)
              ");
            $database->mysqli_execute($prepared, array(
                ":first_name" => $fn,
                ":last_name" => $ln,
                ":address" => $ad,
                ":email" => $ea,
                ":contact_num" => $cn,
                ":account_id" => $id,
                ":birth_date" => $bd
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
}