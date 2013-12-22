<?php

require_once 'includes/dateformats.php';
require_once 'includes/findinxml.php';

//-----------------------------------------------------------------------------
// Show - can be several shows/concerts per Event
//-----------------------------------------------------------------------------
class Show {
    public      $show_id;
    public      $created;
    public      $modified;
    public      $user_id;

    public      $event_id;
    public      $venue_id;

    public      $event;
    public      $venue;

    public      $day;
    public      $dateString;
    public      $timeString;
    public      $dataTime;

    public      $shortDate;
    public      $longDate;
    public      $shortMonth;
    public      $dayOfMonth;
    public      $shortDay;
    public      $timeOfDay;

    // $mysqltime = date ("Y-m-d H:i:s", $phptime);
    
    
    /*-------------------------------------------------------------------------------------------------
    Show constructor
    -------------------------------------------------------------------------------------------------*/
    public function Show () {

        $this->show_id = 0;
        $this->created = 0;
        $this->modified = 0;
        $this->user_id = 0;

        $this->event_id = 0;
        $this->venue_id = 0;

        $this->event = NULL;
        $this->venue = NULL;

        $this->day = '';
        $this->dateString = '';
        $this->timeString = '';
        $this->date_time = '';

        $this->shortDate = '';
        $this->longDate = '';
        $this->shortMonth = '';
        $this->dayOfMonth = '';
        $this->shortDay = '';
        $this->timeOfDay = '';
    }

    /*-------------------------------------------------------------------------------------------------
    Populates a Show from XML (for testing)
    -------------------------------------------------------------------------------------------------*/
    function populateFromXML ($showXML, $eventsXML, $organizationsXML, $venuesXML, $eventIn = NULL, $organizationIn = NULL) {

        $this->show_id = $showXML->id;
        
        if (isset($eventIn)) {
            $this->event = $eventIn;
            $this->event_id = $eventIn->event_id;
        }
        else {
            $eventXML = findShowEvent ($eventsXML, $showXML->event);
            $this->event = new Event();
            $this->event->populateFromXML ($eventXML, $organizationsXML, $organizationIn);
            $this->event_id = $this->event->event_id;
        }

        $this->venue_id = $showXML->venue;
        $venueXML = findVenue($venuesXML, $showXML->venue);
        if (isset($venueXML)) {
            $this->venue = new Venue();
            $this->venue->populateFromXML ($venueXML);
        }

        $this->formatDateAndTimeStrings ($showXML->day, $showXML->date, $showXML->time);

    }

    /*-------------------------------------------------------------------------------------------------
    Format date and time strings
    -------------------------------------------------------------------------------------------------*/
    private function formatDateAndTimeStrings ($day, $dateString, $timeString) {
            
        $this->day = $day;
        $this->dateString = $dateString;
        $this->timeString = $timeString;
        $this->date_time = $dateString.' '.$timeString;

        $this->shortDay = getShortDay ($day);
        $this->shortDate = getShortDate ($dateString);
        $this->longDate = getLongDate ($dateString);
        $this->shortMonth = getShortMonth ($dateString);
        $this->dayOfMonth = getDayOfMonth ($dateString);
        $this->timeOfDay = get12HourTime ($timeString);

    }
    
    /*-------------------------------------------------------------------------------------------------
    Populates a Show from an associative array
    -------------------------------------------------------------------------------------------------*/
    private function populateFromAssocData ($assoc_data) {

        $this->show_id = isset($assoc_data['show_id']) ? $assoc_data['show_id'] : 0;
        $this->event_id = isset($assoc_data['event_id']) ? $assoc_data['event_id'] : 0;
        $this->venue_id = isset($assoc_data['venue_id']) ? $assoc_data['venue_id'] : 0;      
    }
    
    /*-------------------------------------------------------------------------------------------------
    Populates a Show from a database row
    -------------------------------------------------------------------------------------------------*/
    public function populateFromDb ($db_row) {
        
        $this->populateFromAssocData ($db_row);

        $this->created = $db_row['created'];
        $this->modified = $db_row['modified'];
        $this->user_id = $db_row['user_id'];

        $this->event = new Event();
        $this->event->populateFromDb ($this->event_id);

        $this->venue = new Venue();
        $this->venue->populateFromDb ($this->venue_id);
    }
    
    /*-------------------------------------------------------------------------------------------------
    Populates a Show from POST data from a Form
    -------------------------------------------------------------------------------------------------*/
    public function populateFromPostData ($post_data) {

        $this->populateFromAssocData ($post_data);
    }

    /*-------------------------------------------------------------------------------------------------
    Finds a populates a Show from a show_id
    -------------------------------------------------------------------------------------------------*/
    public function findInDb ($show_id) {

        $q = 'SELECT * 
              FROM shows 
              WHERE show_id = '.$show_id;
        $row = DB::instance(DB_NAME)->select_row($q);

        if (isset($row))
            $this->populateFromDb($row);

        return $row;
    }

    /*-------------------------------------------------------------------------------------------------
    Static/Class method to get an array of Show objects
    -------------------------------------------------------------------------------------------------*/
    public static function arrayFromDb ($condition = NULL) {

        # Build the query to get all the users
        $q = 'SELECT * 
              FROM shows';

        if (isset($condition))
            $q += " ".$condition;
              
        # Execute the query to get all the shows.
        $rows = DB::instance(DB_NAME)->select_rows($q);

        $shows = array();

        foreach ($rows as $row) {
            $show = new Show();
            $show->populateFromDb($row);
            $shows[] = $show;
        }
        
        return $shows;    
    }

    /*-------------------------------------------------------------------------------------------------
    Generates an associative array from the Show object
    -------------------------------------------------------------------------------------------------*/
    private function generateAssocData (&$_data) {

        $_data['show_id'] = $this->show_id;
        $_data['created'] = $this->created;
        $_data['modified'] = $this->modified;
        $_data['user_id'] = $this->user_id;
        $_data['organization_id'] = $this->organization_id;
        $_data['event_id'] = $this->event_id;
        $_data['date_time'] = $this->date_time;

    }

    /*-------------------------------------------------------------------------------------------------
    Adds a new database row with the Show data
    -------------------------------------------------------------------------------------------------*/
    public function addToDb ($user_id) {

        $_data = array();
        $this->generateAssocData ($_data);
        
        # Associate this show with this user
        $_data['user_id'] = $user_id;
        
        # Unix timestamp of when this show was created / modified
        $_data['created'] = Time::now();
        $_data['modified'] = Time::now();   
        
        return DB::instance(DB_NAME)->insert('shows', $_data);
    }

    /*-------------------------------------------------------------------------------------------------
    Updates an existing Show database row
    -------------------------------------------------------------------------------------------------*/
    public function updateToDb ($user_id) {
     
        if ($this->user_id != $user_id) {
            # Can't update this
            return 0;
        }

        $_data = array();
        $this->generateAssocData ($_data);
        
        # Unix timestamp of when this show was created / modified
        $_data['modified'] = Time::now();   
        
        $q = "WHERE show_id = '".$this->show_id."'";
        return DB::instance(DB_NAME)->update("shows", $_data, $q);
    }

    /*-------------------------------------------------------------------------------------------------
    Deletes a Show database row
    -------------------------------------------------------------------------------------------------*/
    public function deleteFromDb ($user_id) {
    
        if ($this->user_id != $user_id) {
            # Can't delete this
            return 0;
        }

        # Delete the show from the shows table
        $q = "WHERE show_id = '".$this->show_id."'";
        return DB::instance(DB_NAME)->delete('shows', $q);
    
    }

} # eoc
