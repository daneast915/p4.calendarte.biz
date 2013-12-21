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
					$this->template->content->message = "Your new organization was added.<br/>";
					break;
				case 2:
					$this->template->content->message = "Your organization was deleted.<br/>";
					break;
			}
		}

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

			$this->template->content->canAddEvent = true;
			$this->template->content->canUpdateOrganization = true;

			# Render the View
		    $this->template->content->organization = $organization;
			echo $this->template;
		}
        else {
            echo 'Organization with id ' . $id . ' not found.' . PHP_EOL;
        }
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
			$this->template->content->name = '';
			$this->template->content->description = '';
			$this->template->content->director = '';
			$this->template->content->email = '';
			$this->template->content->phone = '';
			$this->template->content->website = '';
			$this->template->content->image_url = '';

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
			"director" => "Director",
			/*---
			"address_street" => "Street",
			"address_city" => "City",
			"address_state" => "State",
			"address_zipcode" => "Zip Code",
			---*/
			"phone" => "Phone",
			"email" => "Email Address",
			"website" => "Website",
			"image_url" => "Image"
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
			$this->template->content->director = $_POST['director'];
			$this->template->content->website = $_POST['website'];
			$this->template->content->phone = $_POST['phone'];
			$this->template->content->image_url = $_POST['image_url'];
			
			$this->template->content->email = $email;

			echo $this->template;
			return;
		}
	
		# More data we want stored with the user
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();
    
		# Insert this organization into the database
		$this->userObj->add_organization ($this->user->user_id, $_POST);

		# Send them to the login screen
		Router::redirect('/organizations/index/1'); 
    }
	
	/*-------------------------------------------------------------------------------------------------
	organizations/delete controller method
	-------------------------------------------------------------------------------------------------*/
	public function delete() {

   		if (!$this->user)
    		Router::redirect('/organizations/index');

		# Delete this post
		$this->userObj->delete_organization ($this->user->user_id, $_POST['organization_id']);
			
		# Send them back
		Router::redirect("/organizations/index/2");	
	}

 	/*-------------------------------------------------------------------------------------------------
	organizations/edit controller method
	-------------------------------------------------------------------------------------------------*/
   	public function edit() {

   		if (!$this->user || !$_POST)
    		Router::redirect('/organizations/index');

    	$organization_id = $_POST['organization_id'];

    	$organization = findOrganization ($organization_id);

		# Setup view
		$content = View::instance('v_organizations_edit');

		$content->$organization_id = $organization->$organization_id;
		$content->name = $organization->name;
		$content->description = $organization->description;
		$content->director = $organization->director;
		$content->website = $organization->website;
		$content->phone = $organization->phone;
		$content->image_url = $organization->image_url;
		$content->email = $organization->email;
		
		$this->template->content = $content;
		$this->template->title = 'Edit Organization';
		$this->template->client_files_body = "<script src='/js/hide-category-navigation.js' type='text/javascript'></script>";
	
		if (!$_POST) {
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
			"director" => "Director",
			/*---
			"address_street" => "Street",
			"address_city" => "City",
			"address_state" => "State",
			"address_zipcode" => "Zip Code",
			---*/
			"phone" => "Phone",
			"email" => "Email Address",
			"website" => "Website",
			"image_url" => "Image"
			);
					
		# Loop through the POST data to validate
		foreach($_POST as $field_name => $value) {
			# If a field is blank, add a message
			if ($value == "") {
				$this->template->content->error .= $field_names[$field_name].' must contain a value.<br/>';
				$error = true;				
			}
			
			if ($this->userObj->check_for_invalid_chars ($value))  {
				$this->template->content->error .= $field_names[$field_name].' contains invalid characters.<br/>';
				$_POST[$field_name] = '';
				$error = true;				
			}
		}
		
		# Sanitize the fields
		$_POST['name'] = $this->userObj->cleanse_data ($_POST['name']);
		
		$email = $_POST['email'];

		# Validate the email address for format and uniqueness
		$email_error = $this->userObj->validate_email ($email, FALSE);
		if (!empty($email_error)) {
			$this->template->content->error .= $email_error;
			$email = '';
			$error = true;
		}
		
		if (!empty($email) && $email != $this->user->email) {
			if (!$this->confirm_unique_email($email)) {
				$this->template->content->error .=  "Email has already been used. Please use another.<br/>";
				$email = '';
				$error = true;
			}
		}

		# If any errors, display the page with the errors
		if ($error) {
			$this->template->content->name = $_POST['name'];
			$this->template->content->email = $email;
			
			echo $this->template;
			return;
		}
		
		# Passed validation

		# More data we want stored with the user
		$_POST['modified'] = Time::now();
		
		# Do the update
		$this->userObj->update_organization ($organization_id, $_POST);
		   
		# Send them back to the profile page.
		Router::redirect("/organizations/detail/".$organization_id);
    }
	
} # end of the class