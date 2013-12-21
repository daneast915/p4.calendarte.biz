<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once 'includes/findinxml.php';

class index_controller extends base_controller {
	
	/*-------------------------------------------------------------------------------------------------

	-------------------------------------------------------------------------------------------------*/
	public function __construct() {
		parent::__construct();
	} 
		
	/*-------------------------------------------------------------------------------------------------
	Accessed via http://localhost/index/index/
	-------------------------------------------------------------------------------------------------*/
	public function index() {
		
    	# If user is blank, they're not logged in; redirect them to the Login page
    	//if (!$this->user) {
			# Setup view
			$this->template->content = View::instance('v_index_index');	
			$this->template->title   = "Welcome";
			$this->template->body_id = "index";

			// Read XML files for events & shows
		    $eventsXML = getEvents();
		    $showsXML  = getShows();
		    $venuesXML = getVenues();
		    $organizationsXML = getOrganizations();

		    # Build list of events
		    $i = 0;            
		    foreach ($eventsXML->event as $eventXML)
			    {
		        $eventInstance = new Event();
		        $eventInstance->populateFromXML ($eventXML, $organizationsXML);
		        $eventInstance->populateShowsFromXML ($eventsXML, $organizationsXML, $showsXML, $venuesXML);
		        
		        if ($eventInstance->topPick)
		            $results[$i++] = $eventInstance;
		        }

		    # Nest View for Events List
		    $eventsView = View::instance('v_events_list');
		    $eventsView->events = $results;	
			$this->template->content->events = $eventsView;
	
			# Render template
			echo $this->template;
		//	}
		//else
    	//	Router::redirect("/posts/index");	

	} # End of method
		
	/*-------------------------------------------------------------------------------------------------
	Accessed via http://localhost/index/about/
	-------------------------------------------------------------------------------------------------*/
	public function about() {

		# Setup view
		$this->template->content = View::instance('v_index_about');	
		$this->template->title   = "About";
		$this->template->body_id = "about";	

		echo $this->template;
	}
} # End of class
