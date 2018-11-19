<?php
class loginPresenter {

	public static function displayError(){
		\Plugins\FlashCard::setFlashCard("Authentication Error", "/login", "Invalid Username or Password");
		header("location: /login");
		exit;
	}

    public function get(){
	    // Restrict Logged User
	    SessionModel::restrictLogged();

        View::addVar("view_title", "AMFM Login");
        View::addVar("BODY_CLASS", "bg-light");
        View::addCSS("/_layouts/login/login.css");
        View::addCSS("http://".Route::domain()."/css/".md5("Bootstrap").".min.css");

        View::addVar("fc", @Plugins\FlashCard::getFlashCard()[0]);

	    View::addScript("/_layouts/Home/js/jquery.min.js");
	    View::addScript("/_layouts/Home/js/bootstrap.min.js");
    }

    public function post(){
        Params::permit('usn', 'pwd');

        $usn = Params::get('usn');
        $pwd = Params::get('pwd');

        // Check if all form is may laman
        if (!isset($usn, $pwd)){
        	self::displayError();
        }

        // Check the length of Usn
        if(strlen($usn) < 3 || strlen($usn) > 32){
	        self::displayError();
        }

        // Check the length of password
        if(strlen($pwd) < 3 || strlen($pwd) > 32){
	        self::displayError();
        }

        // Start Account checking...
        $account = LoginAuthModel::checkAccount($usn, $pwd);
        if ($account !== false){
        	// Save the session
            SessionModel::setUser($usn, $account["hash_id"]);
            SessionModel::setBinStatus($account["bin_active"]);
            SessionModel::setUniStatus($account["uni_active"]);
            SessionModel::setID($account["id"]);
            SessionModel::setParentID($account["uniparent"]);

            // Reload the page to redirect to the new page
            header("location: /");
            exit;
        }

        // Show the invalid error
	   self::displayError();
    }

    public function put(){
        Route::returnCode(401);
    }

    public function delete(){
        Route::returnCode(401);
    }
}
    