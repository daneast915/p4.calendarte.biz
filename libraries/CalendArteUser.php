<?php

/*-------------------------------------------------------------------------------------------------
 CalendArteUser is an extension of the framework's User class.
 It contains convenience methods for database access.
-------------------------------------------------------------------------------------------------*/
class CalendArteUser extends User {

	/*-------------------------------------------------------------------------------------------------
	Update the profile of a user
	
	@param  $token     - the user's token
	@param  $user_data - array of data to be used in the user's profile update
	@return DB update return
	-------------------------------------------------------------------------------------------------*/
	public function update_profile ($token, $user_data /* array */ ) {
	
		return DB::instance(DB_NAME)->update("users", $user_data, "WHERE token = '".$token."'");
		
	}
	
	/*-------------------------------------------------------------------------------------------------
	Insert a new user into the db
	
	@param  $user_data - array of data to be used in the new user profile
	@return DB insert return
	-------------------------------------------------------------------------------------------------*/
	public function add_new_user ($user_data) {
	
		# Insert this user into the database
		$user_id = DB::instance(DB_NAME)->insert('users', $user_data);

	}

	public function add_organization ($user_id, $data) {
	
		$_data = $data;
		
		# Associate this organization with this user
		$_data['user_id'] = $user_id;
		
		# Unix timestamp of when this organization was created / modified
		$_data['created'] = Time::now();
		$_data['modified'] = Time::now();	
		
		return DB::instance(DB_NAME)->insert('organizations', $_data);
	
	}	

	public function delete_organization ($user_id, $organization_id) {
	
		# Delete the post from the posts table
		$where_condition = 'WHERE organization_id = '.$organization_id;
		return DB::instance(DB_NAME)->delete('organizations', $where_condition);
	
	}

	public function add_venue ($user_id, $data) {
	
		$_data = $data;
		
		# Associate this venue with this user
		$_data['user_id'] = $user_id;
		
		# Unix timestamp of when this venue was created / modified
		$_data['created'] = Time::now();
		$_data['modified'] = Time::now();	
		
		return DB::instance(DB_NAME)->insert('venues', $_data);
	
	}	

	public function delete_venue ($user_id, $venue_id) {
	
		# Delete the venue from the posts table
		$where_condition = 'WHERE venue_id = '.$venue_id;
		return DB::instance(DB_NAME)->delete('venues', $where_condition);
	
	}

	public function add_event ($user_id, $data) {
	
		$_data = $data;
		
		# Associate this event with this user
		$_data['user_id'] = $user_id;
		
		# Unix timestamp of when this event was created / modified
		$_data['created'] = Time::now();
		$_data['modified'] = Time::now();	
		
		return DB::instance(DB_NAME)->insert('events', $_data);
	
	}	

	public function delete_event ($user_id, $venue_id) {
	
		# Delete the event from the posts table
		$where_condition = 'WHERE event_id = '.$event_id;
		return DB::instance(DB_NAME)->delete('event', $where_condition);
	
	}

	/*-------------------------------------------------------------------------------------------------
	Validates an email address for format and uniqueness
	
	@param  $email        - the email address to validate
	@param  $check_unique - bool, whether or not to check for uniqueness
	@return Any error message text, or empty string
	-------------------------------------------------------------------------------------------------*/
	public function validate_email ($email, $check_unique = TRUE) {
	
		if (!empty($email)) {
			# Validate the email address for formatting
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return "Email is invalid. Please use another.<br/>";
			}
			# Guarantee the email address is unique
			else if ($check_unique && !$this->confirm_unique_email($email)) {
				return "Email has already been used. Please use another.<br/>";
			}
		}
		
		return '';
			
	}

	/*-------------------------------------------------------------------------------------------------
	Check for invalid characters
	
	@param  $data - string data to check for invalid characters
	@return true if invalid characters found, or false if none found
	-------------------------------------------------------------------------------------------------*/
	public function check_for_invalid_chars ($data) {
	
		if (strpos($data, '<') !== FALSE ||
		    strpos($data, '>') !== FALSE ||
		    strpos($data, '/') !== FALSE ||
		    strpos($data, '\\') !== FALSE)
		    return true;
		    
		return false;
		
	}	
	
	/*-------------------------------------------------------------------------------------------------
	Cleanse user data - convert to HTML entities and strip slashes
	
	@param  $data - string data to be cleansed
	@return cleansed string
	-------------------------------------------------------------------------------------------------*/
	public function cleanse_data ($data) {

		if(is_array($data)){
		
			foreach($data as $k => $v){
				if(is_array($v)){
					$data[$k] = self::cleanse_data($v);
				} else {
					$data[$k] = htmlentities(stripslashes(nl2br($v)),ENT_QUOTES,"Utf-8");
				}
			}
			
		} else {
			$data = htmlentities(stripslashes(nl2br($data)),ENT_QUOTES,"Utf-8");
		}

		return $data;
					
	}

} #eof