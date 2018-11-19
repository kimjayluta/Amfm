<?php
class signupPresenter {

	public static function showError(String $msg){
		// Add the FlashCard then reload the page
		\Plugins\FlashCard::setFlashCard(
			"Registration Error", "/signup", $msg
		);
//		echo $msg;
		header("location: /signup");
		exit;
	}

    public function get(){
	    // Restrict Logged User
	    SessionModel::restrictLogged();

        View::addVar("view_title", "AMFM Signup");
        View::addCSS("/_layouts/login/signup.css");
        View::addVar("BODY_CLASS", "bg-light");
        View::addCSS("http://".Route::domain()."/css/".md5("Bootstrap").".min.css");

	    View::addVar("fc", \Plugins\FlashCard::getFlashCard()[0]);
    }

    public function post(){
        Params::permit('fn', 'ln', 'bd', 'ad', 'cn', 'ea', 'usn', 'pwd', 'cfpwd');

        // Put to variable to be used in model
        $first_name = Params::get("fn");
        $last_name = Params::get("ln");
        $birth_date = Params::get("bd");
        $address = Params::get("ad");
        $email_add = Params::get("ea");
        $contact_num = Params::get("cn");
        $usn = Params::get("usn");
        $pwd = Params::get("pwd");
        $cfpwd = Params::get("cfpwd");

        // Check kung may laman ang gabos na data
        if(!isset($first_name, $last_name, $address, $contact_num, $usn, $pwd, $cfpwd)){
	        self::showError(" Fill all forms of data!");
        }
        // Check if the passwords match
        if($pwd != $cfpwd){
	        self::showError(" Password does not match!");
        }
        // Check the length of passsword
        if(strlen($pwd) < 8 || strlen($pwd) > 32 ){
	        self::showError(" Password must be 8-32 characters only! ");
        }
        // Check the length of username
        if (strlen($usn) < 8 || strlen($usn) > 32 ){
	        self::showError(" Username must be 8-32 characters only! ");
        }
        // Check if the characters of usn is valid
        if(!preg_match('/^[a-z\d_]{0,}$/i', $usn)){
	        self::showError(" Username must be alpha numeric characters only!");
        }
        // Check the length of first name
        if (strlen($first_name) < 1 || strlen($first_name) > 32 ){
	        self::showError(" First name must be 1-32 characters only!");
        }
        // To check the length of last name
        if (strlen($last_name) < 1 || strlen($last_name) > 32 ){
	        self::showError(" Last name must be 1-32 characters only!");
        }
        // To check the length of address
        if (strlen($address) < 1 || strlen($address) > 60 ){
	        self::showError(" Address must be 1-32 characters only! ");
        }

        // To check the length of contact number
        if(strlen($contact_num) < 5 || strlen($contact_num) > 13 ){
	        self::showError(" Contact number is Invalid!");
        }

        // Validation of contact number
        if(!preg_match('/^\d*$/',$contact_num)){
	        self::showError(" Contact number is Invalid! Please input a number only");
        }

        // Email validation
        if(!filter_var($email_add, FILTER_VALIDATE_EMAIL)){
	        self::showError(" You have entered an invalid Email Address");
        }

        // Start the Registration Backend process
        $registered = RegisterAuthModel::register($first_name, $last_name, $birth_date, $address, $email_add, $contact_num, $usn, $pwd);

        if ($registered === true){
	        \Plugins\FlashCard::setFlashCard("Registration Success", "/login", " Thank you for joining with us. Your journey to rise starts now!");
	        header("location: /login");
	        exit;
        }

        self::showError(" There was an unknown error occurs while trying to register your details. Please try again layer Thank you.");
    }

    // HTTP Header Method: PUT
    // Usually used when about to update a data
    public function put(){
        Route::returnCode(401);
    }

    // HTTP Header Method: DELETE
    // Usually used when about to delete a data
    public function delete(){
        Route::returnCode(401);
    }
}
    