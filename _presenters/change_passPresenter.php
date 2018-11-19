<?php
class change_passPresenter {

	public static function showError(String $msg){
		\Plugins\FlashCard::setFlashCard(
			"Request Error", "/account/password", $msg
		);

		header("location: /account/password");
		exit;
	}

    public function get(){
        View::addVar("view_title", "Change Password Page");
        View::addVar("BODY_CLASS", "bg-light");
        View::addVar("username", SessionModel::getUser());
        View::addVar("FULL_NAME", SessionModel::getName());

        // Import the Bootstrap
        View::addCSS("http://".Route::domain()."/css/".md5("Bootstrap").".min.css");

        // Import JQUERy
        View::addScript("/_layouts/Binary/jquery.min.js");

        // Include the bootstrap JS
        View::addScript("http://".Route::domain()."/js/".md5("Bootstrap").".min.js");

        // Add the flashCard
	    View::addVar("fc", \Plugins\FlashCard::getFlashCard()[0]);
    }

    public function post(){
    	Params::permit("pwd", "pwd1", "pwd2");

    	// Password Parameters
    	$pwd = Params::get("pwd");
    	$pwd1 = Params::get("pwd1");
    	$pwd2 = Params::get("pwd2");


    	if ($pwd != false && $pwd1 != false && $pwd2 != false){

    		// The password entered has to be 8-32 characters
    		if (
			    (strlen($pwd) < 8 || strlen($pwd) > 32 ) &&
			    (strlen($pwd1) < 8 || strlen($pwd1) > 32 ) &&
			    (strlen($pwd2) < 8 || strlen($pwd2) > 32 )
		    ){
			    self::showError(" Password must be 8-32 characters only! ");
		    }

		    // The new password has to match
		    if (strlen($pwd1) != strlen($pwd2)){
			    self::showError(" New password does not match, please try again.");
		    }


		    // Execute change on password
			if (AcctManagementModel::changePassword($pwd1, $pwd)){
				\Plugins\FlashCard::setFlashCard(
					"Request Success", "/account/password", " Password has successfully changed"
				);

				header("location: /account/password");
				exit;
			}else{
				self::showError("Make sure to entered the valid current password.");
			}
	    }
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
    