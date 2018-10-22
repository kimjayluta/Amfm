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
    }

    // HTTP Header Method: POST
    // Usually used when to insert a new data
    public function post(){
        Route::returnCode(401);
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
    