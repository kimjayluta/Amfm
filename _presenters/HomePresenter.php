<?php
class HomePresenter {
    // HTTP Header Method: GET
    // Used to retrive a data or a view
    public function get(){
    	SessionModel::restrictLogged();

        View::addVar("view_title", "Binary Level");
        View::addCSS("/_layouts/Home/css/bootstrap.min.css");
        View::addCSS("/_layouts/Home/css/main.css");
        View::addCSS("/_layouts/Home/css/font-awesome.min.css");
        View::addCSS("/_layouts/Home/css/simple-line-icons.css");
        View::addCSS("/_layouts/Home/css/preloader.css");
        View::addCSS("/_layouts/Home/css/custom.css");
        View::addCSS("/_layouts/Home/css/responsive.css");
        View::addCSS("/_layouts/Home/css/index.css");

	    // Import JQuery Library
        View::addScript("/_layouts/Home/js/jquery.min.js");
	    View::addScript("/_layouts/Home/js/jquery.easing.js");
	    View::addScript("/_layouts/Home/js/jquery.counterup.js");
	    View::addScript("/_layouts/Home/js/jquery.waypoints.js");
	    View::addScript("/_layouts/Home/js/bootstrap.min.js");

	    // Import Other JS
	    View::addScript("/_layouts/Home/js/index.js");
	    View::addScript("/_layouts/Home/js/common.js");
        View::addScript("/_layouts/Home/js/util.js");
        View::addScript("/_layouts/Home/js/controls.js");
        View::addScript("/_layouts/Home/js/places_impl.js");
        View::addScript("/_layouts/Home/js/stats.js");
        View::addScript("/_layouts/Home/js/price.slider.js");
        View::addScript("/_layouts/Home/js/custom.js");
        View::addScript("/_layouts/Home/js/testimonials.js");
        View::addScript("https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js");
        View::addScript("https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js");

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
    