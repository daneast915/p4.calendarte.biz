<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

require_once 'includes/dateformats.php';
require_once 'includes/findinxml.php';

//-----------------------------------------------------------------------------
// Venue, location, building
//-----------------------------------------------------------------------------
class Venue {
    public      $venue_id;
    public      $created;
    public      $modified;
    public      $user_id;
    public      $name;
    public      $description;
    public      $address;
    public      $phone;
    public      $website;
    public      $email;
    public      $accessibility_info;
    public      $seating_info;
    public      $parking_info;
    public      $image_url;    
    public      $images;        // []
 
    
    /*-------------------------------------------------------------------------------------------------
    Venue constructor
    -------------------------------------------------------------------------------------------------*/
    public function Venue () {
        $this->venue_id = 0;
        $this->created = 0;
        $this->modified = 0;
        $this->user_id = 0;
        $this->name = '';
        $this->description = '';
        $this->address = new Address();
        $this->phone = '';
        $this->website = '';
        $this->email = NULL;
        $this->accessibility_info = NULL;
        $this->seating_info = NULL;
        $this->parking_info = NULL;
        $this->image_url = NULL;
    }

    /*-------------------------------------------------------------------------------------------------
    Populates a Venue from XML (for testing)
    -------------------------------------------------------------------------------------------------*/
    public function populateFromXML ($venueXML) {
        $this->venue_id = $venueXML->id;
        $this->name = $venueXML->name;
        $this->description = $venueXML->description;
        $this->address = new Address();
        $this->address->populateFromXML ($venueXML->address);
        $this->phone = $venueXML->phone;
        $this->website = $venueXML->website;
        $this->email = !empty($venueXML->email) ? $venueXML->email : NULL;
        $this->accessibility_info = !empty($venueXML->accessibilityinfo) ? $venueXML->accessibilityinfo : NULL;

        $i = 0;
        $this->firstImage = NULL;
        
        if (isset ($venueXML->images)) {
            foreach ($venueXML->images as $imageXML) {
                if ($i == 0 && isset($imageXML->image) && strlen($imageXML->image) > 0)
                    $this->image_url = $imageXML->image;
                $this->images[$i++] = $imageXML->image;        // []
            }
        }
    }
    
    /*-------------------------------------------------------------------------------------------------
    Populates a Venue from an associative array
    -------------------------------------------------------------------------------------------------*/
    private function populateFromAssocData ($assoc_data) {

        $this->venue_id = isset($assoc_data['venue_id']) ? $assoc_data['venue_id'] : 0;
        $this->name = $assoc_data['name'];
        $this->description = $assoc_data['description'];
        $this->address = new Address();
        $this->address->populateFromAssocData ($assoc_data);
        $this->phone = $assoc_data['phone'];
        $this->website = $assoc_data['website'];
        $this->email = !empty($assoc_data['email']) ? $assoc_data['email'] : NULL;
        $this->accessibility_info = !empty($assoc_data['accessibility_info']) ? $assoc_data['accessibility_info'] : NULL;
        $this->seating_info = !empty($assoc_data['seating_info']) ? $assoc_data['seating_info'] : NULL;
        $this->parking_info = !empty($assoc_data['parking_info']) ? $assoc_data['parking_info'] : NULL;
        $this->image_url = !empty($assoc_data['image_url']) ? $assoc_data['image_url'] : NULL;
    }
    
    /*-------------------------------------------------------------------------------------------------
    Populates a Venue from a database row
    -------------------------------------------------------------------------------------------------*/
    public function populateFromDb ($db_row) {
        $this->populateFromAssocData ($db_row);

        $this->created = $db_row['created'];
        $this->modified = $db_row['created'];
        $this->user_id = $db_row['user_id'];
    }
    
    /*-------------------------------------------------------------------------------------------------
    Populates a Venue from POST data from a Form
    -------------------------------------------------------------------------------------------------*/
    public function populateFromPostData ($post_data) {
        $this->populateFromAssocData ($post_data);
    }

    /*-------------------------------------------------------------------------------------------------
    Finds a populates a Venue from a venue_id
    -------------------------------------------------------------------------------------------------*/
    public function findInDb ($venue_id) {
        $q = 'SELECT * 
              FROM venues 
              WHERE venue_id = '.$venue_id;
        $venue_row = DB::instance(DB_NAME)->select_row($q);

        if (isset($venue_row))
            $this->populateFromDb($venue_row);

        return $venue_row;
    }

    /*-------------------------------------------------------------------------------------------------
    Static/Class method to get an array of Venue objects
    -------------------------------------------------------------------------------------------------*/
    public static function arrayFromDb ($condition = NULL) {

        # Build the query to get all the users
        $q = 'SELECT * 
              FROM venues';

        if (isset($condition))
            $q += " ".$condition;
              
        # Execute the query to get all the venues.
        # Store the result array in the variable $users
        $venue_rows = DB::instance(DB_NAME)->select_rows($q);

        $venues = array();

        foreach ($venue_rows as $venue_row) {
            $venue = new Venue();
            $venue->populateFromDb($venue_row);
            $venues[] = $venue;
        }
        
        return $venues;    
    }

    /*-------------------------------------------------------------------------------------------------
    Generates an associative array from the Venue object
    -------------------------------------------------------------------------------------------------*/
    private function generateAssocData (&$_data) {

        $_data['venue_id'] = $this->venue_id;
        $_data['created'] = $this->created;
        $_data['modified'] = $this->modified;
        $_data['user_id'] = $this->user_id;
        $_data['name'] = $this->name;
        $_data['description'] = $this->description;
        $this->address->generateAssocData ($_data);
        $_data['phone'] = $this->phone;
        $_data['website'] = $this->website;
        $_data['email'] = $this->email;
        $_data['accessibility_info'] = $this->accessibility_info;
        $_data['seating_info'] = $this->seating_info;
        $_data['parking_info'] = $this->parking_info;
        $_data['image_url'] = $this->image_url;

    }

    /*-------------------------------------------------------------------------------------------------
    Adds a new database row with the Venue data
    -------------------------------------------------------------------------------------------------*/
    public function addToDb ($user_id) {

        $_data = array();
        $this->generateAssocData ($_data);
        
        # Associate this venue with this user
        $_data['user_id'] = $user_id;
        
        # Unix timestamp of when this venue was created / modified
        $_data['created'] = Time::now();
        $_data['modified'] = Time::now();   
        
        return DB::instance(DB_NAME)->insert('venues', $_data);
    }

    /*-------------------------------------------------------------------------------------------------
    Updates an existing Venue database row
    -------------------------------------------------------------------------------------------------*/
    public function updateToDb ($user_id) {
     
        if ($this->user_id != $user_id) {
            # Can't update this
            return 0;
        }

        $_data = array();
        $this->generateAssocData ($_data);
        
        # Unix timestamp of when this venue was created / modified
        $_data['modified'] = Time::now();   
        
        $q = "WHERE venue_id = '".$this->venue_id."'";
        return DB::instance(DB_NAME)->update("venues", $_data, $q);
    }

    /*-------------------------------------------------------------------------------------------------
    Deletes a Venue database row
    -------------------------------------------------------------------------------------------------*/
    public function deleteFromDb ($user_id) {
    
        if ($this->user_id != $user_id) {
            # Can't delete this
            return 0;
        }

        # Delete the venue from the posts table
        $q = 'WHERE venue_id = '.$this->venue_id;
        return DB::instance(DB_NAME)->delete('venues', $q);
    
    }

} // #eoc

