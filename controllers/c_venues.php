<?php

//ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);

require_once 'includes/findinxml.php';

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
    public function index($param = NULL) {
	
		# Setup the View
		$this->template->content = View::instance("v_venues_index");
		$this->template->title = "Venues";	
		$this->template->body_id = "venues";
		
		# Set message based on the $param
		if (isset($param)) {
			switch ($param) {
				case 1:
					$this->template->content->message = "Venue added.<br/>";
					break;
				case 2:
					$this->template->content->message = "Venue deleted.<br/>";
					break;
				case 3:
					$this->template->content->error = "Unable to delete Venue.<br/>";
					break;
			}
		}

	    $venues = Venue::arrayFromDb();

		# Render the View
	    $this->template->content->venues = $venues;
		echo $this->template;		
	}

	/*-------------------------------------------------------------------------------------------------
	venues/detail controller method
	-------------------------------------------------------------------------------------------------*/
    public function detail ($id) {

    	if (!$id) {
    		Router::redirect("/venues/index");
    	}

   		$venue = new Venue();
   		$row = $venue->findInDb($id);

	    if (isset($row)) {

	 		# Setup the View
			$this->template->content = View::instance("v_venues_detail");
			$this->template->title   = "Venue";	
			$this->template->body_id = "venues";

            $canEdit = ($this->user && $this->user->user_id == $venue->user_id);
            $this->template->content->canUpdateVenue = $canEdit;
 
			# Render the View
		    $this->template->content->venue = $venue;
			echo $this->template;
		}
        else {
            echo 'Venue with id ' . $id . ' not found.' . PHP_EOL;
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
			"address_street" => "Street",
			"address_city" => "City",
			"address_state" => "State",
			"address_zipcode" => "Zip Code",
			"email" => "Email Address",
			"website" => "Website"
			);
		
		# Loop through the POST data to validate
		foreach($post_data as $field_name => $value) {
			# If a field is blank, add a message
			if ($value == "" && isset($field_names[$field_name])) {
				$errorMessage .= $field_names[$field_name].' must contain a value.<br/>';
				$error = true;
			}
		}
		
		$email = $post_data['email'];
		
		# Validate the email address for format and uniqueness
		$email_error = $this->userObj->validate_email ($email);

		if (!empty($email_error)) {
			$errorMessage .= $email_error;
			$post_data['email'] = '';
			$error = true;
		}

		return $error;   	
    }

 	/*-------------------------------------------------------------------------------------------------
	organizations/add controller method
	-------------------------------------------------------------------------------------------------*/
   	public function add() {

   		if (!$this->user)
    		Router::redirect('/venues/index');

        # Setup view
		$this->template->content = View::instance('v_venues_add');
		$this->template->title   = "New Venue";
		$this->template->client_files_body = "<script src='/js/hide-category-navigation.js' type='text/javascript'></script>";

        # Render template
		if (!$_POST) {
			$venue = new Venue();
			$this->template->content->venue = $venue;

        	echo $this->template;
			return;
    	}

		# Transfer POST data to Venue object
		$venue = new Venue();
		$venue->populateFromPostData ($_POST);

		# Innocent until proven guilty
		$errorMessage = '';
		$this->template->content->error = '';

		$error = $this->validateAddEditPostData ($_POST, $errorMessage);

		# If any errors, display the page with the errors
		if ($error) {
			$venue->email = $_POST['email'];

			$this->template->content->error = $errorMessage;
			$this->template->content->venue = $venue;
			echo $this->template;

			return;
		}
		
 		# Prevent SQL injection attacks by sanitizing the data the user entered in the form
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);

		# Cleanse the data
		$_POST = $this->userObj->cleanse_data($_POST);
    
		# Insert this organization into the database
		$venue->populateFromPostData ($_POST);
		$venue->addToDb ($this->user->user_id);

		# Send them to the login screen
		Router::redirect('/venues/index/1'); 
		
    }

 	/*-------------------------------------------------------------------------------------------------
	venues/edit controller method
	-------------------------------------------------------------------------------------------------*/
   	public function edit() {

   		if (!$this->user || !$_POST)
    		Router::redirect('/venues/index');

    	$venue_id = $_POST['venue_id'];

		# Transfer POST data to Venue object
		$venue = new Venue();
		$venue->findInDb ($venue_id);

        # Setup view
		$this->template->content = View::instance('v_venues_edit');
		$this->template->title   = "Edit Venue";
		$this->template->client_files_body = "<script src='/js/hide-category-navigation.js' type='text/javascript'></script>";

		$this->template->content->venue = $venue;

    	echo $this->template;
    }

 	/*-------------------------------------------------------------------------------------------------
	venues/p_edit controller method
	-------------------------------------------------------------------------------------------------*/
   	public function p_edit() {

   		if (!$this->user || !$_POST)
    		Router::redirect('/venues/index');

    	$venue_id = $_POST['venue_id'];

        # Setup view
		$this->template->content = View::instance('v_venues_edit');
		$this->template->title   = "Edit Venue";
		$this->template->client_files_body = "<script src='/js/hide-category-navigation.js' type='text/javascript'></script>";

		# Transfer POST data to Venue object
		$venue = new Venue();
		$venue->findInDb ($venue_id);
		$venue->populateFromPostData ($_POST);

		# Innocent until proven guilty
		$errorMessage = '';
		$this->template->content->error = '';

		$error = $this->validateAddEditPostData ($_POST, $errorMessage);

		# If any errors, display the page with the errors
		if ($error) {
			$venue->email = $_POST['email'];

			$this->template->content->error = $errorMessage;
			$this->template->content->venue = $venue;
			echo $this->template;

			return;
		}
		
 		# Prevent SQL injection attacks by sanitizing the data the user entered in the form
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);

		# Cleanse the data
		$_POST = $this->userObj->cleanse_data($_POST);
    
		# Update this venue in the database
		$venue->populateFromPostData ($_POST);
		$venue->updateToDb ($this->user->user_id);

		# Send them to the login screen
		Router::redirect('/venues/detail/'.$venue->venue_id); 
		
    }
	
	/*-------------------------------------------------------------------------------------------------
	organizations/delete controller method
	-------------------------------------------------------------------------------------------------*/
	public function delete() {

   		if (!$this->user)
    		Router::redirect('/venues/index');
	
		# Delete this post
		$venue = new Venue();
   		$row = $venue->findInDb($_POST['venue_id']);

   		$error = 0;

	    if (isset($row)) {		
	    	if ($venue->deleteFromDb ($this->user->user_id)) {
				# Send them to the index
				Router::redirect("/venues/index/2");	
			}
			else {
				$error = 3;
			}
		}
		else {
			$error = 3;
		}

		# Send them back to index
		Router::redirect("/venues/index/".$error);

	}

} # end of the class