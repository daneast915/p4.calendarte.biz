<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

include 'includes/classes.php';

class venues_controller extends base_controller {


	/*-------------------------------------------------------------------------------------------------
	Constructor
	-------------------------------------------------------------------------------------------------*/
    public function __construct() {
    
        parent::__construct();
	
    } 

	/*-------------------------------------------------------------------------------------------------
	venues/index controller method
	-------------------------------------------------------------------------------------------------*/
    public function index() {
	
		# Setup the View
		$this->template->content = View::instance("v_venues_index");
		$this->template->title = "Venues";	
		$this->template->body_id = "venues";

	    $eventsXML = getEvents();
	    $organizationsXML = getOrganizations();
	    $showsXML  = getShows();
	    $venuesXML = getVenues();

	    $i = 0;            
	    foreach ($venuesXML->venue as $venueXML)
		    {
	        $venue = new Venue();
	        $venue->populateFromXML($venueXML);

			$results[$i++] = $venue;
	    }

		# Render the View
	    $this->template->content->venues = $results;
		echo $this->template;		
	}

	/*-------------------------------------------------------------------------------------------------
	venues/detail controller method
	-------------------------------------------------------------------------------------------------*/
    public function detail ($id) {

    	if (!$id) {
    		Router::redirect("/venues/index");
    	}

	    $eventsXML = getEvents();
	    $organizationsXML = getOrganizations();
	    $showsXML  = getShows();
	    $venuesXML = getVenues();

		$venueXML = findVenue($venuesXML, $id);
	
	    if (isset($venueXML)) {
	 		# Setup the View
			$this->template->content = View::instance("v_venues_detail");
			$this->template->title   = "Venue";	
			$this->template->body_id = "venues";

            $venue = new Venue();
            $venue->populateFromXML ($venueXML);

			# Render the View
		    $this->template->content->venue = $venue;
			echo $this->template;
		}
        else {
            echo 'Venue with id ' . $id . ' not found.' . PHP_EOL;
        }
    }    

} # end of the class