<?php

//ini_set('display_errors', 'On');
//error_reporting(E_ALL);

require_once 'includes/findinxml.php';

class events_controller extends base_controller {

	/*-------------------------------------------------------------------------------------------------
	Constructor
	-------------------------------------------------------------------------------------------------*/
    public function __construct() {
    
        parent::__construct();
	
    } 

	/*-------------------------------------------------------------------------------------------------
	events/index controller method
	-------------------------------------------------------------------------------------------------*/
    public function index() {
	
		# Setup the View
		$this->template->content = View::instance("v_events_index");
		$this->template->title   = "Events";	
		$this->template->body_id = "events";

		// Read database for events & shows
		$events = Event::arrayFromDb();

		foreach($events as $event) {
			$event->populateShowsFromDb();
		}

	    # Nest View for Events List
	    $eventsView = View::instance('v_events_list');
	    $eventsView->events = $events;	
		$this->template->content->events = $eventsView;

		# Render the View
		echo $this->template;		
	}

	/*-------------------------------------------------------------------------------------------------
	events/detail controller method
	-------------------------------------------------------------------------------------------------*/
    public function detail ($id) {

    	if (!$id) {
    		Router::redirect("/events/index");
    	}

   		$event = new Event();
   		$row = $event->findInDb($id);

	    if (isset($row)) {

	 		# Setup the View
			$this->template->content = View::instance("v_events_detail");
			$this->template->title   = "Event";	
			$this->template->body_id = "events";

	   		if ($event->organization_id != 0) {
	   			$organization = new Organization();
	   			$organization->findInDb ($event->organization_id);
	   			$event->organization = $organization;
	   		}

			$event->populateShowsFromDb();

            $canEdit = ($this->user && $this->user->user_id == $event->user_id);
            $this->template->content->canUpdateEvent = $canEdit;
            $this->template->content->canAddShow = $canEdit;

			# Render the View
		    $this->template->content->event = $event;
			echo $this->template;
		}
        else {
            echo 'Event with id ' . $id . ' not found.' . PHP_EOL;
        }
	}    

 	/*-------------------------------------------------------------------------------------------------
	Validates $POST data for Add / Edit
	-------------------------------------------------------------------------------------------------*/
    private function validateAddEditPostData (&$post_data, &$errorMessage) {

    	$error = false;
    	
		# Array for field names
		$field_names = Array(
			"name" => "Name",
			"description" => "Description"
			);
		
		# Loop through the POST data to validate
		foreach($post_data as $field_name => $value) {
			# If a field is blank, add a message
			if ($value == "" && isset($field_names[$field_name])) {
				$errorMessage .= $field_names[$field_name].' must contain a value.<br/>';
				$error = true;
			}
		}

		return $error;   	
    }

 	/*-------------------------------------------------------------------------------------------------
	events/add controller method
	-------------------------------------------------------------------------------------------------*/
   	public function add() {

   		if (!$this->user || !$_POST)
    		Router::redirect('/events/index');

        # Setup view
		$this->template->content = View::instance('v_events_add');
		$this->template->title   = "New Event";
		$this->template->client_files_body = "<script src='/js/hide-category-navigation.js' type='text/javascript'></script>";

        # Render template
		if (isset($_POST['from_organization']) && isset($_POST['organization_id'])) {
			$event = new Event();
			$event->organization_id = $_POST['organization_id'];
			$this->template->content->event = $event;

        	echo $this->template;
			return;
    	}

		# Transfer POST data to Event object
		$event = new Event();
		$event->populateFromPostData ($_POST);

		# Innocent until proven guilty
		$errorMessage = '';
		$this->template->content->error = '';

		$error = $this->validateAddEditPostData ($_POST, $errorMessage);

		# If any errors, display the page with the errors
		if ($error) {
			$event->email = $_POST['email'];

			$this->template->content->error = $errorMessage;
			$this->template->content->event = $event;
			echo $this->template;

			return;
		}
		
 		# Prevent SQL injection attacks by sanitizing the data the user entered in the form
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);

		# Cleanse the data
		$_POST = $this->userObj->cleanse_data($_POST);
    
		# Insert this event into the database
		$event->populateFromPostData ($_POST);
		$event_id = $event->addToDb ($this->user->user_id);

		# Send them to the events details screen
		Router::redirect('/events/detail/'.$event_id); 
    }

 	/*-------------------------------------------------------------------------------------------------
	events/edit controller method
	-------------------------------------------------------------------------------------------------*/
   	public function edit() {

   		if (!$this->user || !$_POST)
    		Router::redirect('/events/index');

    	$event_id = $_POST['event_id'];

		# Transfer POST data to Event object
		$event = new Event();
		$event->findInDb ($event_id);

        # Setup view
		$this->template->content = View::instance('v_events_edit');
		$this->template->title   = "Edit Event";
		$this->template->client_files_body = "<script src='/js/hide-category-navigation.js' type='text/javascript'></script>";

		$this->template->content->event = $event;

    	echo $this->template;
    }

 	/*-------------------------------------------------------------------------------------------------
	events/p_edit controller method
	-------------------------------------------------------------------------------------------------*/
   	public function p_edit() {

   		if (!$this->user || !$_POST)
    		Router::redirect('/events/index');

    	$event_id = $_POST['event_id'];

        # Setup view
		$this->template->content = View::instance('v_events_edit');
		$this->template->title   = "Edit Event";
		$this->template->client_files_body = "<script src='/js/hide-category-navigation.js' type='text/javascript'></script>";

		# Transfer POST data to Event object
		$event = new Event();
		$event->findInDb ($event_id);
		$event->populateFromPostData ($_POST);

		# Innocent until proven guilty
		$errorMessage = '';
		$this->template->content->error = '';

		$error = $this->validateAddEditPostData ($_POST, $errorMessage);

		# If any errors, display the page with the errors
		if ($error) {
			$event->email = $_POST['email'];

			$this->template->content->error = $errorMessage;
			$this->template->content->event = $event;
			echo $this->template;

			return;
		}
		
 		# Prevent SQL injection attacks by sanitizing the data the user entered in the form
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);

		# Cleanse the data
		$_POST = $this->userObj->cleanse_data($_POST);
    
		# Update this event in the database
		$event->populateFromPostData ($_POST);
		$event->updateToDb ($this->user->user_id);

		# Send them to the detail screen
		Router::redirect('/events/detail/'.$event->event_id); 
		
    }
	
	/*-------------------------------------------------------------------------------------------------
	organizations/delete controller method
	-------------------------------------------------------------------------------------------------*/
	public function delete() {

   		if (!$this->user)
    		Router::redirect('/events/index');
	
		# Delete this post
		$event = new Event();
   		$row = $event->findInDb($_POST['event_id']);

   		$error = 0;

	    if (isset($row)) {		
	    	if ($event->deleteFromDb ($this->user->user_id)) {
				# Send them to the index
				Router::redirect("/events/index/2");	
			}
			else {
				$error = 3;
			}
		}
		else {
			$error = 3;
		}

		# Send them back to index
		Router::redirect("/events/index/".$error);

	}

	/*-------------------------------------------------------------------------------------------------
	Populates an array with Venues for a <select>
	-------------------------------------------------------------------------------------------------*/
	private function populateVenueArray() {

		$venues = Venue::arrayFromDb();
		$venuesArray = array();

		foreach($venues as $venue) {
			$venuesArray[$venue->venue_id] = $venue->name;
		}

		return $venuesArray;
	}

 	/*-------------------------------------------------------------------------------------------------
	Validates $POST data for Show Add / Edit
	-------------------------------------------------------------------------------------------------*/
    private function validateShowAddEditPostData (&$post_data, &$errorMessage) {

    	$error = false;
    	
		# Array for field names
		$field_names = Array(
			"venue" => "Venue",
			"showdate" => "Date",
			"showtime" => "Time"
			);
		
		# Loop through the POST data to validate
		foreach($post_data as $field_name => $value) {
			# If a field is blank, add a message
			if ($value == "" && isset($field_names[$field_name])) {
				$errorMessage .= $field_names[$field_name].' must contain a value.<br/>';
				$error = true;
			}
		}

		return $error;   	
    }

 	/*-------------------------------------------------------------------------------------------------
	events/addshow controller method
	-------------------------------------------------------------------------------------------------*/
   	public function addshow() {

   		if (!$this->user || !$_POST)
    		Router::redirect('/events/index');

        # Setup view
		$this->template->content = View::instance('v_events_addshow');
		$this->template->title   = "New Show for Event";
		$this->template->client_files_body = "<script src='/js/hide-category-navigation.js' type='text/javascript'></script>";

		$this->template->content->venues = $this->populateVenueArray();

        # Render template
		if (isset($_POST['from_event']) && isset($_POST['event_id'])) {
			$show = new Show();
			$show->event_id = $_POST['event_id'];
			$this->template->content->show = $show;

        	echo $this->template;
			return;
    	}

		# Transfer POST data to Event object
		$show = new Show();
		$show->populateFromPostData ($_POST);

		# Innocent until proven guilty
		$errorMessage = '';
		$this->template->content->error = '';

		$error = $this->validateShowAddEditPostData ($_POST, $errorMessage);

		# If any errors, display the page with the errors
		if ($error) {
			$this->template->content->error = $errorMessage;
			$this->template->content->event = $event;
			echo $this->template;

			return;
		}
		
 		# Prevent SQL injection attacks by sanitizing the data the user entered in the form
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);

		# Cleanse the data
		$_POST = $this->userObj->cleanse_data($_POST);
    
		# Insert this show into the database
		$show->populateFromPostData ($_POST);
		$show->addToDb ($this->user->user_id);

		# Send them to the events details screen
		Router::redirect('/events/detail/'.$show->event_id); 
    }
	
	/*-------------------------------------------------------------------------------------------------
	events/search controller method
	-------------------------------------------------------------------------------------------------*/
	public function search() {

   		if (!$_POST)
     		Router::redirect('/events/index');

		# Setup the View
		$this->template->content = View::instance("v_events_index");
		$this->template->title   = "Events";	
		$this->template->body_id = "events";

		$q = '';

		# Build the query for the Search of Keyword, Start Date and End Date
		$q = "SELECT DISTINCT
				events.*
			FROM events
			INNER JOIN organizations
				ON events.organization_id = organizations.organization_id 
			INNER JOIN shows
				ON events.event_id = shows.event_id 
			INNER JOIN venues
				ON shows.venue_id = venues.venue_id 
			WHERE (events.name LIKE '%".$_POST['keyword']."%'
	        	OR events.description LIKE '%".$_POST['keyword']."%'
	        	OR organizations.name LIKE '%".$_POST['keyword']."%'
	        	OR venues.name LIKE '%".$_POST['keyword']."%'
	        	OR venues.address_city LIKE '%".$_POST['keyword']."%')";

		if (!empty($_POST['startdate'])) {
	        $date = DateTime::createFromFormat ("m/d/Y", $_POST['startdate']);
	        $date_time = $date->format("Y-m-d H:i:s");
			$q = $q." AND (shows.date_time > STR_TO_DATE('".$date_time."', '%Y-%m-%d %H:%i:%s'))";
		}

		if (!empty($_POST['enddate'])) {
	        $date = DateTime::createFromFormat ("m/d/Y", $_POST['enddate']);
	        $date->modify('+1 day');
	        $date_time = $date->format("Y-m-d H:i:s");
			$q = $q." AND (shows.date_time < STR_TO_DATE('".$date_time."', '%Y-%m-%d %H:%i:%s'))";
		}

		# Run the query
		$rows = DB::instance(DB_NAME)->select_rows($q);
		
        $events = array();

        foreach ($rows as $row) {
            $event = new Event();
            $event->populateFromDb($row);
            $events[] = $event;
        }

		foreach($events as $event) {
			$event->populateShowsFromDb();
		}

	    # Nest View for Events List
	    $eventsView = View::instance('v_events_list');
	    $eventsView->events = $events;	
		$this->template->content->events = $eventsView;

		# Render the View
		echo $this->template;	
	}

} # end of the class