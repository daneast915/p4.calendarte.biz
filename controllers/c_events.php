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
	
		# Setup view
		$this->template->content = View::instance('v_posts_add');
		$this->template->title = "New Post";
		
		# Render templates
		if (!$_POST) {
			echo $this->template;
			return;
		}

		# Innocent until proven guilty
		$error = false;
		$this->template->content->error = '';
		
 		# Prevent SQL injection attacks by sanitizing the data the user entered in the form
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);
			
		# Validate the post
		if (empty($_POST['content'])) {
			$this->template->content->error .= 'Post must not be empty.<br/>';
			$error = true;
		}

		# If any errors, display the page with the errors
		if ($error) {
			echo $this->template;
			return;
		}

		# Add a post for this user
		$_POST['content'] = $this->userObj->cleanse_data ($_POST['content']);
		$this->userObj->add_event ($this->user->user_id, $_POST);
		
		# Feedback
		Router::redirect("/events/index/1");
	}
	
	/*-------------------------------------------------------------------------------------------------
	events/delete controller method
	-------------------------------------------------------------------------------------------------*/
	public function delete() {
	
		# Delete this post
		$this->userObj->delete_event ($this->user->user_id, $_POST['event_id']);
			
		# Send them back
		Router::redirect("/events/index/2");	
	}

} # end of the class