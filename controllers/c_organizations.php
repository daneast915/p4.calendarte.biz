<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once 'includes/findinxml.php';

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
    public function index($param = NULL) {
 
 		# Setup the View
		$this->template->content = View::instance("v_organizations_index");
		$this->template->title   = "Organizations";	
		$this->template->body_id = "organizations";
		
		# Set message based on the $param
		if (isset($param)) {
			switch ($param) {
				case 1:
					$this->template->content->message = "Your organization was added.<br/>";
					break;
				case 2:
					$this->template->content->message = "Your organization was deleted.<br/>";
					break;
				case 3:
					$this->template->content->error = "Unable to delete organization.<br/>";
					break;
			}
		}


	    $organizations = Organization::arrayFromDb();

		# Render the View
	    $this->template->content->organizations = $organizations;
		echo $this->template;	
		
	}

	/*-------------------------------------------------------------------------------------------------
	organizations/detail controller method
	-------------------------------------------------------------------------------------------------*/
    public function detail ($id) {

    	if (!$id) {
    		Router::redirect("/organizations/index");
    	}

   		$organization = new Organization();
   		$row = $organization->findInDb($id);

	    if (isset($row)) {
            
	 		# Setup the View
			$this->template->content = View::instance("v_organizations_detail");
			$this->template->title   = "Organization";	
			$this->template->body_id = "organizations";

			$organization->populateEventsFromDb();

            if (isset($organization->events) && count($organization->events) > 0) {    
			    # Nest View for Events List
			    $eventsView = View::instance('v_events_list');
			    $eventsView->events = $organization->events;	
				$this->template->content->events = $eventsView;
            }

            $canEdit = ($this->user && $this->user->user_id == $organization->user_id);
			$this->template->content->canAddEvent = $canEdit;
			$this->template->content->canUpdateOrganization = $canEdit;

			# Render the View
		    $this->template->content->organization = $organization;
			echo $this->template;
		}
        else {
            echo 'Organization with id ' . $id . ' not found.' . PHP_EOL;
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
			"description" => "Description",
			"director" => "Director",
			"address_street" => "Street",
			"address_city" => "City",
			"address_state" => "State",
			"address_zipcode" => "Zip Code",
			"website" => "Website",
			"image_url" => "Image"
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
    		Router::redirect('/organizations/index');

        # Setup view
		$this->template->content = View::instance('v_organizations_add');;	
		$this->template->title   = "New Organization";
		$this->template->client_files_body = "<script src='/js/hide-category-navigation.js' type='text/javascript'></script>";

        # Render template
		if (!$_POST) {
			$organization = new Organization();
			$this->template->content->organization = $organization;

        	echo $this->template;
			return;
    	}

		# Transfer POST data to Organization object
		$organization = new Organization();
		$organization->populateFromPostData ($_POST);

		# Innocent until proven guilty
		$errorMessage = '';
		$this->template->content->error = '';

		$error = $this->validateAddEditPostData ($_POST, $errorMessage);

		# If any errors, display the page with the errors
		if ($error) {
			$organization->email = $_POST['email'];

			$this->template->content->error = $errorMessage;
			$this->template->content->organization = $organization;
			echo $this->template;

			return;
		}
		
 		# Prevent SQL injection attacks by sanitizing the data the user entered in the form
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);

		# Cleanse the data
		$_POST = $this->userObj->cleanse_data($_POST);
    
		# Insert this organization into the database
		$organization->populateFromPostData ($_POST);
		$organization->addToDb ($this->user->user_id);

		# Send them to the login screen
		Router::redirect('/organizations/index/1'); 
    }

 	/*-------------------------------------------------------------------------------------------------
	organizations/edit controller method
	-------------------------------------------------------------------------------------------------*/
   	public function edit() {

   		if (!$this->user || !$_POST)
    		Router::redirect('/organizations/index');

    	$organization_id = $_POST['organization_id'];

		# Transfer POST data to Organization object
		$organization = new Organization();
		$organization->findInDb ($organization_id);

        # Setup view
		$this->template->content = View::instance('v_organizations_edit');
		$this->template->title   = "Edit Organization";
		$this->template->client_files_body = "<script src='/js/hide-category-navigation.js' type='text/javascript'></script>";

		$this->template->content->organization = $organization;

    	echo $this->template;
    }

 	/*-------------------------------------------------------------------------------------------------
	organizations/p_edit controller method
	-------------------------------------------------------------------------------------------------*/
   	public function p_edit() {

   		if (!$this->user || !$_POST)
    		Router::redirect('/organizations/index');

    	$organization_id = $_POST['organization_id'];

        # Setup view
		$this->template->content = View::instance('v_organizations_edit');
		$this->template->title   = "Edit Organization";
		$this->template->client_files_body = "<script src='/js/hide-category-navigation.js' type='text/javascript'></script>";

		# Transfer POST data to Organization object
		$organization = new Organization();
		$organization->findInDb ($organization_id);
		$organization->populateFromPostData ($_POST);

		# Innocent until proven guilty
		$errorMessage = '';
		$this->template->content->error = '';

		$error = $this->validateAddEditPostData ($_POST, $errorMessage);

		# If any errors, display the page with the errors
		if ($error) {
			$organization->email = $_POST['email'];

			$this->template->content->error = $errorMessage;
			$this->template->content->organization = $organization;
			echo $this->template;

			return;
		}
		
 		# Prevent SQL injection attacks by sanitizing the data the user entered in the form
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);

		# Cleanse the data
		$_POST = $this->userObj->cleanse_data($_POST);
    
		# Update this organization in the database
		$organization->populateFromPostData ($_POST);
		$organization->updateToDb ($this->user->user_id);

		# Send them to the login screen
		Router::redirect('/organizations/detail/'.$organization->organization_id); 
		
    }

	/*-------------------------------------------------------------------------------------------------
	organizations/delete controller method
	-------------------------------------------------------------------------------------------------*/
	public function delete() {

   		if (!$this->user)
    		Router::redirect('/organizations/index');
	
		# Delete this organization
		$organization = new Organization();
   		$row = $organization->findInDb($_POST['organization_id']);

   		$error = 0;

	    if (isset($row)) {		
	    	if ($organization->deleteFromDb ($this->user->user_id)) {
				# Send them to the index
				Router::redirect("/organizations/index/2");	
			}
			else {
				$error = 3;
			}
		}
		else {
			$error = 3;
		}

		# Send them back to index
		Router::redirect("/organizations/index/".$error);

	}
	
} # end of the class