<?php
class ProfilePresenter {
    public function get(){
	    SessionModel::restrictNotLogged();

	    // Check for a possible request loan
	    Params::permit("rl", "cr");
	    if (Params::get("rl") != false){
	    	UniPathModel::addPending(Params::get("rl"));
			header("location: /profile");
			exit;
	    }

	    // Check for a cancel the request REQUEST
	    if (Params::get("cr") != false){
	    	UniPathModel::removePending();
	    	header("location: /profile");
	    	exit;
	    }

	    // Web page configuration
	    View::addVar("view_title", "Profile Page");
	    View::addVar("BODY_CLASS", "bg-light");
	    View::addVar("username", SessionModel::getUser());
	    View::addVar("FULL_NAME", SessionModel::getName());

	    // Import the Bootstrap
	    View::addCSS("http://".Route::domain()."/css/".md5("Bootstrap").".min.css");

	    // Import the Jquery
	    View::addScript("/_layouts/Binary/jquery.min.js");

	    // Include the bootstrap JS
	    View::addScript("http://".Route::domain()."/js/".md5("Bootstrap").".min.js");

	    // Loan Array - Loan Package, Remaining Balance, maturity date
	    View::addVar("LOAN", LendingModel::loanInfo());

	    // Check if the user has a pending request to the server
	    $_LOAN_REQUEST = UniPathModel::checkOnPending();
	    if ($_LOAN_REQUEST !== false){
		    View::addVar("LOAN_REQUEST", $_LOAN_REQUEST);
		    return;
	    }

	    // Check of already registered on the binary program
	    if (SessionModel::getUniStatus()){
		    View::addVar("UNI_LEVEL", true);
		    return;
	    }
    }

    public function post(){
        Route::returnCode(401);
    }

    public function put(){
        Route::returnCode(401);
    }

    public function delete(){
        Route::returnCode(401);
    }
}