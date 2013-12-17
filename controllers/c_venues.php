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

 	/*-------------------------------------------------------------------------------------------------
	organizations/add controller method
	-------------------------------------------------------------------------------------------------*/
   	public function add() {

   		if (!$this->user)
    		Router::redirect('/venues/index');

        # Setup view
		$this->template->content = View::instance('v_venues_add');;	
		$this->template->title   = "New Venue";
		$this->template->client_files_body = "<script src='/js/hide-category-navigation.js' type='text/javascript'></script>";

        # Render template
		if (!$_POST) {
			$this->template->content->name = '';
			$this->template->content->description = '';
			$this->template->content->address_street = '';
			$this->template->content->address_city = '';
			$this->template->content->address_state = '';
			$this->template->content->address_zipcode = '';
			$this->template->content->email = '';
			$this->template->content->phone = '';
			$this->template->content->website = '';
			$this->template->content->image_url = '';
			$this->template->content->seating_chart = '';
			$this->template->content->accessibility_info = '';
			$this->template->content->parking_info = '';

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
			"name" => "Name",
			"description" => "Description",
			"address_street" => "Street",
			"address_city" => "City",
			"address_state" => "State",
			"address_zipcode" => "Zip Code",
			"email" => "Email Address",
			"website" => "Website"
			);
		
		# Loop through the POST data to validate
		foreach($_POST as $field_name => $value) {
			# Sanitize the data
			$_POST[$field_name] = $this->userObj->cleanse_data ($_POST[$field_name]);

			# If a field is blank, add a message
			if ($value == "" && isset($field_names[$field_name])) {
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
		
		$email = $_POST['email'];
		
		# Validate the email address for format and uniqueness
		$email_error = $this->userObj->validate_email ($email);
		if (!empty($email_error)) {
			$this->template->content->error .= $email_error;
			$email = '';
			$error = true;
		}

		# If any errors, display the page with the errors
		if ($error) {
			$this->template->content->name = $_POST['name'];
			$this->template->content->description = $_POST['description'];
			$this->template->content->address_street = $_POST['address_street'];
			$this->template->content->address_city = $_POST['address_city'];
			$this->template->content->address_state = $_POST['address_state'];
			$this->template->content->address_zipcode = $_POST['address_zipcode'];
			$this->template->content->website = $_POST['website'];
			$this->template->content->phone = $_POST['phone'];
			$this->template->content->image_url = $_POST['image_url'];
			$this->template->content->seating_chart = $_POST['seating_chart'];
			$this->template->content->accessibility_info = $_POST['accessibility_info'];
			$this->template->content->parking_info = $_POST['parking_info'];
			
			$this->template->content->email = $email;

			echo $this->template;
			return;
		}
	
		# More data we want stored with the user
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();
    
		# Insert this organization into the database
		$this->userObj->add_venue ($this->user->user_id, $_POST);

		# Send them to the login screen
		Router::redirect('/venues/index/1'); 
    }
	
	/*-------------------------------------------------------------------------------------------------
	organizations/delete controller method
	-------------------------------------------------------------------------------------------------*/
	public function delete() {

   		if (!$this->user)
    		Router::redirect('/venues/index');
	
		# Delete this post
		$this->userObj->delete_venue ($this->user->user_id, $_POST['venue_id']);
			
		# Send them back
		Router::redirect("/venues/index/2");	
	}

} # end of the class