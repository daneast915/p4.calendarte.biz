<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

include 'includes/classes.php';

class organizations_controller extends base_controller {

	/*-------------------------------------------------------------------------------------------------
	Constructor
	-------------------------------------------------------------------------------------------------*/
    public function __construct() {
    
        parent::__construct();
	
    } 

	/*-------------------------------------------------------------------------------------------------
	organizations/index controller method
	-------------------------------------------------------------------------------------------------*/
    public function index() {
 
 		# Setup the View
		$this->template->content = View::instance("v_organizations_index");
		$this->template->title   = "Organizations";	
		$this->template->body_id = "organizations";

	    $organizationsXML = getOrganizations();

	    $i = 0;            
	    foreach ($organizationsXML->organization as $organizationXML) {
	        $organization = new Organization();
	        $organization->populateFromXML($organizationXML);

			$results[$i++] = $organization;
	    }

		# Render the View
	    $this->template->content->organizations = $results;
		echo $this->template;	
		
	}

	/*-------------------------------------------------------------------------------------------------
	organizations/detail controller method
	-------------------------------------------------------------------------------------------------*/
    public function detail ($id) {

    	if (!$id) {
    		Router::redirect("/organizations/index");
    	}

	    $organizationsXML = getOrganizations();    
	    $eventsXML = getEvents();
	    $showsXML  = getShows();
	    $venuesXML = getVenues();
	    
        $organizationXML = findOrganization($organizationsXML, $id);
	
	    if (isset($organizationXML)) {
            
	 		# Setup the View
			$this->template->content = View::instance("v_organizations_detail");
			$this->template->title   = "Organization";	
			$this->template->body_id = "organizations";

            $organization = new Organization();
            $organization->populateFromXML ($organizationXML);
            $organization->populateEventsFromXML ($eventsXML, $organizationsXML, $showsXML, $venuesXML);

            if (isset($organization->events) && count($organization->events) > 0) {    
			    # Nest View for Events List
			    $eventsView = View::instance('v_events_list');
			    $eventsView->events = $organization->events;	
				$this->template->content->events = $eventsView;
            }

			# Render the View
		    $this->template->content->organization = $organization;
			echo $this->template;
		}
        else {
            echo 'Organization with id ' . $id . ' not found.' . PHP_EOL;
        }
    }    

} # end of the class