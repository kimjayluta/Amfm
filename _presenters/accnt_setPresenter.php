<?php
class accnt_setPresenter {
    // HTTP Header Method: GET
    // Used to retrive a data or a view
    public function get(){
    	SessionModel::restrictNotLogged();

        View::addVar("view_title", "Account Settings");
        View::addVar("BODY_CLASS", "bg-light");
        View::addVar("username", SessionModel::getUser());
        View::addVar("FULL_NAME", SessionModel::getName());

        // Import the Bootstrap
        View::addCSS("http://".Route::domain()."/css/".md5("Bootstrap").".min.css");

        // Import JQUERy
        View::addScript("/_layouts/Binary/jquery.min.js");

        // Include the bootstrap JS
        View::addScript("http://".Route::domain()."/js/".md5("Bootstrap").".min.js");

        View::addVar("INFO", AcctManagementModel::getInfo());
    }

    public function post(){
    	Params::permit(
    		// Basic Info
		    "fn", "ln", "cn", "ad", "bdate",
		    // Primary Info
		    "username", "email"
	    );

    	if (Params::get("fn") != false && Params::get("ln") !=false && Params::get("cn") != false &&
		    Params::get("bdate") != false && Params::get("ad") != false){
		    AcctManagementModel::changeBasicInfo(
			    Params::get("fn"),
			    Params::get("ln"),
			    Params::get("cn"),
			    Params::get("bdate"),
			    Params::get("ad")
		    );

		    header("location: /account/settings");
		    exit;
	    }



	    if (Params::get("username") != false && Params::get("email") != false){
    		AcctManagementModel::changePrimaryInfo(
    			Params::get("username"),
			    Params::get("email")
		    );

    		header("location: /account/settings");
    		exit;
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
    