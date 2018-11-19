<?php
class unilevelPresenter {
    // HTTP Header Method: GET
    // Used to retrive a data or a view
    public function get() {
	    SessionModel::restrictNotLogged();

	    View::addVar("view_title", "Unilevel");
	    View::addVar("BODY_CLASS", "bg-light");

	    View::addVar("username", SessionModel::getUser());
	    View::addVar("FULL_NAME", SessionModel::getName());

	    // Import Dependencies
	    View::addCSS("/_layouts/Binary/Treant.css");
	    View::addCSS("/_layouts/Binary/collapsable.css");

	    // Import the Bootstrap
	    View::addCSS("http://" . Route::domain() . "/css/" . md5("Bootstrap") . ".min.css");

	    // Import Bootstrap Javascript
	    View::addScript("http://".Route::domain()."/js/".md5("JQueryOnly").".min.js");
	    View::addScript("http://" . Route::domain() . "/js/" . md5("Bootstrap") . ".min.js");

	    // Import JQuery Extensions
	    View::addScript("/_layouts/Binary/Treant.js");
	    View::addScript("/_layouts/Binary/jquery.easing.js");
	    View::addScript("/_layouts/Binary/collapsable.js");
	    View::addScript("/_layouts/Binary/collapsable.js");
	    View::addScript("/_layouts/Binary/raphael.js");

	    // Use the server domain name address on the layout
	    View::addVar("DN", Route::domain());
	    View::addVar("HASH_ID", SessionModel::getHash());
	    View::addVar("USER_ID", SessionModel::getUserID());

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
    // HTTP Header Method: POST
    // Usually used when to insert a new data
    public function post(){
    	Params::permit("getNodes");

	    if (Params::get("getNodes")){
		    $dbData = UniPathModel::selectNodes();
		    echo ($dbData);
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
    