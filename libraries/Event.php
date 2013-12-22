<?php

require_once 'includes/dateformats.php';
require_once 'includes/findinxml.php';

//-----------------------------------------------------------------------------
// Event - put on by an organization - can have multiple shows/concerts
//-----------------------------------------------------------------------------
class Event
    {
    public      $event_id;
    public      $created;
    public      $modified;
    public      $user_id;   
    public      $organization_id;   
    public      $organization;
    public      $name;
    public      $description;
    public      $category;
    public      $genre;
    public      $website;
    public      $admission_info;
    public      $shows;         // []
    public      $performers;    // []
    public      $image_url;
    public      $top_pick;
      
    /*-------------------------------------------------------------------------------------------------
    Event constructor
    -------------------------------------------------------------------------------------------------*/
    public function Event () {

        $this->event_id = 0;
        $this->created = 0;
        $this->modified = 0;
        $this->user_id = 0;
        $this->organization_id = 0;
        $this->organization = NULL;
        $this->name = '';
        $this->description = '';
        $this->category = 0;
        $this->genre = 0;
        $this->website = '';
        $this->admission_info = '';
        $this->shows = NULL;
        $this->performers = NULL;        
        $this->image_url = NULL;
        $this->images = NULL;
        $this->top_pick = false;

    }

    /*-------------------------------------------------------------------------------------------------
    Populates a Event from XML (for testing)
    -------------------------------------------------------------------------------------------------*/
    function populateFromXML ($eventXML, $organizationsXML, $organizationIn = NULL) {

        $this->event_id = $eventXML->id;

        if (isset($organizationIn)) {
            $this->organization = $organizationIn;
            $this->organization_id = $organizationIn->organization_id;
        }
        else {
            $organizationXML = findOrganization ($organizationsXML, $eventXML->organization);
            if (isset($organizationXML)) {
                $this->organization = new Organization();
                $this->organization->populateFromXML ($organizationXML);
            }
        }
            
        $this->name = $eventXML->name;
        $this->description = $eventXML->description;
        $this->category = $eventXML->category;
        $this->genre = $eventXML->genre;
        $this->website = $eventXML->website;
        $this->admission_info = $eventXML->addmissioninfo;
        $this->top_pick = !empty($eventXML->toppick) ? true : false;

        $i = 0;
        if (isset ($eventXML->performers)) {
            foreach ($eventXML->performers as $performer)
                $this->performers[$i++] = $performer;        // []
        }
            
        $this->image_url = $this->organization->image_url;
    }           

    /*-------------------------------------------------------------------------------------------------
    Populates a Event's Shows from XML (for testing)
    -------------------------------------------------------------------------------------------------*/
    function populateShowsFromXML ($eventsXML, $organizationsXML, $showsXML, $venuesXML, $organizationIn = NULL) {

        $showresults = findEventShows ($showsXML, $this->event_id);
        if (count($showresults) > 0) {
            $i = 0;            
            while (list( , $showXML) = each($showresults)) {
                $showInstance = new Show(); 
                $showInstance->populateFromXML($showXML, $eventsXML, $organizationsXML, $venuesXML, $this, $organizationIn);
                $this->shows[$i++] = $showInstance;         // []
            }
        }
    }
    
    /*-------------------------------------------------------------------------------------------------
    Populates a Event from an associative array
    -------------------------------------------------------------------------------------------------*/
    private function populateFromAssocData ($assoc_data) {

        $this->event_id = isset($assoc_data['event_id']) ? $assoc_data['event_id'] : 0;
        $this->name = $assoc_data['name'];
        $this->description = $assoc_data['description'];
        $this->website = $assoc_data['website'];
        $this->image_url = !empty($assoc_data['image_url']) ? $assoc_data['image_url'] : NULL;
 
        $this->category = isset($assoc_data['category']) ? $assoc_data['category'] : 0;
        $this->genre = isset($assoc_data['genre']) ? $assoc_data['genre'] : 0;
        $this->admission_info = isset($assoc_data['admission_info']) ? $assoc_data['admission_info'] : '';
        $this->top_pick = isset($assoc_data['top_pick']) ? $assoc_data['top_pick'] : false;   
    }
    
    /*-------------------------------------------------------------------------------------------------
    Populates a Event from a database row
    -------------------------------------------------------------------------------------------------*/
    public function populateFromDb ($db_row) {

        $this->populateFromAssocData ($db_row);

        $this->created = $db_row['created'];
        $this->modified = $db_row['modified'];
        $this->user_id = $db_row['user_id'];
    }
    
    /*-------------------------------------------------------------------------------------------------
    Populates a Event from POST data from a Form
    -------------------------------------------------------------------------------------------------*/
    public function populateFromPostData ($post_data) {

        $this->populateFromAssocData ($post_data);
    }

    /*-------------------------------------------------------------------------------------------------
    Finds a populates a Event from a event_id
    -------------------------------------------------------------------------------------------------*/
    public function findInDb ($event_id) {

        $q = 'SELECT * 
              FROM events 
              WHERE event_id = '.$event_id;
        $row = DB::instance(DB_NAME)->select_row($q);

        if (isset($row))
            $this->populateFromDb($row);

        return $row;
    }

    /*-------------------------------------------------------------------------------------------------
    Static/Class method to get an array of Event objects
    -------------------------------------------------------------------------------------------------*/
    public static function arrayFromDb ($condition = NULL) {

        # Build the query to get all the users
        $q = "SELECT * 
              FROM events";

        if (isset($condition))
            $q = $q." ".$condition;

        # Execute the query to get all the events.
        $rows = DB::instance(DB_NAME)->select_rows($q);

        $events = array();

        foreach ($rows as $row) {
            $event = new Event();
            $event->populateFromDb($row);
            $events[] = $event;
        }
        
        return $events;    
    }

    /*-------------------------------------------------------------------------------------------------
    Generates an associative array from the Event object
    -------------------------------------------------------------------------------------------------*/
    private function generateAssocData (&$_data) {

        $_data['event_id'] = $this->event_id;
        $_data['created'] = $this->created;
        $_data['modified'] = $this->modified;
        $_data['user_id'] = $this->user_id;
        $_data['organization_id'] = $this->organization_id;
        $_data['name'] = $this->name;
        $_data['description'] = $this->description;
        $_data['category'] = $this->category;
        $_data['genre'] = $this->genre;
        $_data['website'] = $this->website;
        $_data['admission_info'] = $this->admission_info;
        $_data['image_url'] = $this->image_url;
        $_data['top_pick'] = $this->top_pick;
    }

    /*-------------------------------------------------------------------------------------------------
    Adds a new database row with the Event data
    -------------------------------------------------------------------------------------------------*/
    public function addToDb ($user_id) {

        $_data = array();
        $this->generateAssocData ($_data);
        
        # Associate this Event with this User
        $_data['user_id'] = $user_id;
        
        # Unix timestamp of when this Event was created / modified
        $_data['created'] = Time::now();
        $_data['modified'] = Time::now();   
        
        return DB::instance(DB_NAME)->insert('events', $_data);
    }

    /*-------------------------------------------------------------------------------------------------
    Updates an existing Event database row
    -------------------------------------------------------------------------------------------------*/
    public function updateToDb ($user_id) {
     
        if ($this->user_id != $user_id) {
            # Can't update this
            return 0;
        }

        $_data = array();
        $this->generateAssocData ($_data);
        
        # Unix timestamp of when this Event was created / modified
        $_data['modified'] = Time::now();   
        
        $q = "WHERE event_id = '".$this->event_id."'";
        return DB::instance(DB_NAME)->update("events", $_data, $q);
    }

    /*-------------------------------------------------------------------------------------------------
    Deletes a Event database row
    -------------------------------------------------------------------------------------------------*/
    public function deleteFromDb ($user_id) {
    
        if ($this->user_id != $user_id) {
            # Can't delete this
            return 0;
        }

        # Delete the Event from the events table
        $q = "WHERE event_id = '".$this->event_id."'";
        return DB::instance(DB_NAME)->delete('events', $q);
    
    }

} # eoc
    