<?php
class BinaryPresenter {
    public function get(){
    	// Do not allow those users that is not logged
	    SessionModel::restrictNotLogged();

	    // Set up the body class and the view_title
	    View::addVar("view_title", "Binary Affiliation Program");
	    View::addVar("BODY_CLASS", "bg-light");

	    // Add the User Data as variables
	    View::addVar("username", SessionModel::getUser());
	    View::addVar("FULL_NAME", SessionModel::getName());

	    // Add the CSS dependencies
	    View::addCSS("/_layouts/Binary/Treant.css");
	    View::addCSS("/_layouts/Binary/collapsable.css");
	    View::addCSS("http://".Route::domain()."/css/".md5("Bootstrap").".min.css");

	    // Add the compiled JS dependencies
	    View::addScript("http://".Route::domain()."/js/".md5("JQueryOnly").".min.js");
	    View::addScript("http://".Route::domain()."/js/".md5("Bootstrap").".min.js");

	    // Add the JS dependencies
	    View::addScript("/_layouts/Binary/Treant.js");
	    View::addScript("/_layouts/Binary/jquery.easing.js");
	    View::addScript("/_layouts/Binary/collapsable.js");
	    View::addScript("/_layouts/Binary/raphael.js");
	    View::addScript("/_layouts/Binary/raphael.js");

	    // Use the server domain name address on the layout
	    View::addVar("DN", Route::domain());
	    View::addVar("HASH_ID", SessionModel::getHash());

	    // Check of already registered on the binary program
	    if (SessionModel::getBinStatus()){
		    View::addVar("BINARY", SessionModel::getBinStatus());
		    return;
	    }

	    // Check if the user has a pending request to the server
	    $_REFHASH = BinPathModel::checkOnPending("binary");
	    if ($_REFHASH !== false){
		    View::addVar("REFERENCE", $_REFHASH);
		    return;
	    }

	    // Permit only r parameters and remove the others
	    Params::permit("r");

	    // Add Variable of the provided reference, use false when not valid.
	    if (Params::get("r")){
		    $_REFERENCE = Params::get("r");
		    $_REFERENCE = BinPathModel::checkReference($_REFERENCE);
		    View::addVar("VALID_REFERENCE", $_REFERENCE);
		    return;
	    }

    }

    public function post(){
    	// Require the following Parameter to use the post method
    	Params::permit("targetID", "cancelRequest");

	    if (Params::get("cancelRequest")){
			$removedPending = BinPathModel::removePending("binary");
			if ($removedPending){
				echo 1;
				exit;
			}
		}

		if (Params::get("targetID")){
			$pendingStatus = BinPathModel::addPending(Params::get("targetID"), "binary");
			if ($pendingStatus){
				echo 1;
				exit;
			}
		}

    	// Send a server response
    	exit;
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
