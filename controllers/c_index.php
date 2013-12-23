<?php

//ini_set('display_errors', 'On');
//error_reporting(E_ALL);

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
		
		# Setup view
		$this->template->content = View::instance('v_index_index');	
		$this->template->title   = "Welcome";
		$this->template->body_id = "index";

		// Read database for events & shows
		$events = Event::arrayFromDb();
		$top_picks = array();

		foreach($events as $event) {
			if ($event->top_pick) {
				$event->populateShowsFromDb();
				$top_picks[] = $event;
			}
		}

	    # Nest View for Events List
	    $eventsView = View::instance('v_events_list');
	    $eventsView->events = $top_picks;	
		$this->template->content->events = $eventsView;

		# Render template
		echo $this->template;

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
