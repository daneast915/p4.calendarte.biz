<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

include 'includes/classes.php';

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

		// Read XML files for events & shows
	    $eventsXML = getEvents();
	    $showsXML  = getShows();
	    $venuesXML = getVenues();
	    $organizationsXML = getOrganizations();

	    // Build list of events
	    $i = 0;            
	    foreach ($eventsXML->event as $eventXML) {
	        $eventInstance = new Event();
	        $eventInstance->populateFromXML ($eventXML, $organizationsXML);
	        $eventInstance->populateShowsFromXML ($eventsXML, $organizationsXML, $showsXML, $venuesXML, $eventInstance->organization);
	        
	        $results[$i++] = $eventInstance;
	    }
	
	    # Nest View for Events List
	    $eventsView = View::instance('v_events_list');
	    $eventsView->events = $results;	
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

	    $eventsXML = getEvents();
	    $organizationsXML = getOrganizations();
	    $showsXML  = getShows();
	    $venuesXML = getVenues();

        $eventXML = findEvent($eventsXML, $id);

	    if (isset($eventXML)) {
            
	 		# Setup the View
			$this->template->content = View::instance("v_events_detail");
			$this->template->title   = "Event";	
			$this->template->body_id = "events";

            $event = new Event();
            $event->populateFromXML ($eventXML, $organizationsXML);
            $event->populateShowsFromXML ($eventsXML, $organizationsXML, $showsXML, $venuesXML);

			# Render the View
		    $this->template->content->event = $event;
			echo $this->template;
		}
        else {
            echo 'Event with id ' . $id . ' not found.' . PHP_EOL;
        }
	}    

 	/*-------------------------------------------------------------------------------------------------
	events/add controller method
	-------------------------------------------------------------------------------------------------*/
   	public function add() {

   		if (!$this->user || !$_POST)
    		Router::redirect('/events/index');

        # Setup view
		$this->template->content = View::instance('v_events_add');;	
		$this->template->title   = "New Event";
		$this->template->client_files_body = "<script src='/js/hide-category-navigation.js' type='text/javascript'></script>";

        # Render template
		if (isset($_POST['from_organization'])) {
			$this->template->content->organization_id = $_POST['organization_id'];
			$this->template->content->name = '';
			$this->template->content->description = '';
			$this->template->content->website = '';
			$this->template->content->purchase_link = '';
			$this->template->content->admission_info = '';

        	echo $this->template;
			return;
    	}
		
 		# Prevent SQL injection attacks by sanitizing the data the user entered in the form
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);

		# Innocent until proven guilty
		$error = false;
		$this->template->content->error = '';
		
		# Array for field names
		$field_names = Array(
			"organization_id" => "Organization",
			"name" => "Name",
			"description" => "Description",
			"website" => "Website",
			"purchase_link" => "Purchase Link",
			"admission_info" => "Admission Info"
			);
		
		# Loop through the POST data to validate
		foreach($_POST as $field_name => $value) {
			# Sanitize the data
			$_POST[$field_name] = $this->userObj->cleanse_data ($_POST[$field_name]);

			# If a field is blank, add a message
			if ($value == "") {
				$this->template->content->error .= $field_names[$field_name].' must contain a value.<br/>';
				$error = true;
			}
			
			# If a field contains invalid characters, add a message
			/*---
			if ($this->userObj->check_for_invalid_chars ($value))  {
				$this->template->content->error .= $field_names[$field_name].' contains invalid characters.<br/>';
				$_POST[$field_name] = '';
				$error = true;				
			}
			---*/
		}

		# If any errors, display the page with the errors
		if ($error) {
			$this->template->content->organization_id = $_POST['organization_id'];
			$this->template->content->name = $_POST['name'];
			$this->template->content->description = $_POST['description'];
			$this->template->content->website = $_POST['website'];
			$this->template->content->purchase_link = $_POST['purchase_link'];
			$this->template->content->admission_info = $_POST['admission_info'];

			echo $this->template;
			return;
		}
	
		# More data we want stored with the user
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();
    
		# Insert this event into the database
		$this->userObj->add_event ($this->user->user_id, $_POST);

		# Send them to the login screen
		Router::redirect('/events/index/1'); 
    }
	
	/*-------------------------------------------------------------------------------------------------
	events/delete controller method
	-------------------------------------------------------------------------------------------------*/
	public function delete() {

   		if (!$this->user)
    		Router::redirect('/events/index');
    			
		# Delete this post
		$this->userObj->delete_organization ($this->user->user_id, $_POST['event_id']);
			
		# Send them back
		Router::redirect("/events/index/2");	
	}

} # end of the class