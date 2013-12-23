<?php

require_once 'includes/dateformats.php';
require_once 'includes/findinxml.php';
   
//-----------------------------------------------------------------------------
// Arts Organization
//-----------------------------------------------------------------------------
class Organization {
    public      $organization_id;
    public      $created;
    public      $modified;
    public      $user_id;    
    public      $type;
    public      $name;
    public      $description;
    public      $address;
    public      $phone;
    public      $website;
    public      $email;
    public      $director;
    public      $image_url;    
    public      $images;        // []
    public      $events;        // []
     
    /*-------------------------------------------------------------------------------------------------
    Organization constructor
    -------------------------------------------------------------------------------------------------*/
    public function Organization () {

        $this->organization_id = 0;
        $this->created = 0;
        $this->modified = 0;
        $this->user_id = 0;
        $this->type = 0;
        $this->name = '';
        $this->description = '';
        $this->address = new Address();
        $this->phone = '';
        $this->website = '';
        $this->email = NULL;
        $this->director = NULL;
        $this->image_url = NULL;
        $this->images = NULL;
        $this->events = NULL;
    }

    /*-------------------------------------------------------------------------------------------------
    Populates a Organization from XML (for testing)
    -------------------------------------------------------------------------------------------------*/
    function populateFromXML ($organizationXML) {

        $this->organization_id = $organizationXML->id;
        $this->type = $organizationXML->type;
        $this->name = $organizationXML->name;
        $this->description = $organizationXML->description;
        $this->address = new Address();
        $this->address->populateFromXML ($organizationXML->address);
        $this->phone = !empty($organizationXML->phone) ? $organizationXML->phone : NULL;
        $this->website = !empty($organizationXML->website) ? $organizationXML->website : NULL;
        $this->email = !empty($organizationXML->email) ? $organizationXML->email : NULL;
        $this->director = !empty($organizationXML->director) ? $organizationXML->director : NULL;

        $i = 0;
        $this->image_url = NULL;
        
        if (isset ($organizationXML->images)) {
            foreach ($organizationXML->images as $imageXML) {
                if ($i == 0 && isset($imageXML->image) && strlen($imageXML->image) > 0)
                    $this->image_url = $imageXML->image;
                $this->images[$i++] = $imageXML->image;        // []
            }
        }
    }

    /*-------------------------------------------------------------------------------------------------
    Populates a Organization's Events from XML (for testing)
    -------------------------------------------------------------------------------------------------*/
    function populateEventsFromXML ($eventsXML, $organizationsXML, $showsXML, $venuesXML) {

        $eventresults = findOrganizationEvents ($eventsXML, $this->organization_id);
        if (count($eventresults) > 0) {
            $i = 0;            
            while (list( , $eventXML) = each($eventresults)) {
                $eventInstance = new Event(); 
                $eventInstance->populateFromXML($eventXML, $organizationsXML, $this);
                $eventInstance->populateShowsFromXML ($eventsXML, $organizationsXML, $showsXML, $venuesXML, $this);
                $this->events[$i++] = $eventInstance;         // []
            }
        }
    }
    
    /*-------------------------------------------------------------------------------------------------
    Populates a Organization from an associative array
    -------------------------------------------------------------------------------------------------*/
    private function populateFromAssocData ($assoc_data) {

        $this->organization_id = isset($assoc_data['organization_id']) ? $assoc_data['organization_id'] : 0;
        $this->type = isset($assoc_data['type']) ? $assoc_data['type'] : 0;
        $this->name = $assoc_data['name'];
        $this->description = $assoc_data['description'];
        $this->address = new Address();
        $this->address->populateFromAssocData ($assoc_data);
        $this->website = $assoc_data['website'];
        $this->director = $assoc_data['director'];
        $this->phone = !empty($assoc_data['phone']) ? $assoc_data['phone'] : NULL;
        $this->email = !empty($assoc_data['email']) ? $assoc_data['email'] : NULL;
        $this->image_url = !empty($assoc_data['image_url']) ? $assoc_data['image_url'] : NULL;
    }
    
    /*-------------------------------------------------------------------------------------------------
    Populates a Organization from a database row
    -------------------------------------------------------------------------------------------------*/
    public function populateFromDb ($db_row) {

        $this->populateFromAssocData ($db_row);

        $this->created = $db_row['created'];
        $this->modified = $db_row['modified'];
        $this->user_id = $db_row['user_id'];
    }

    /*-------------------------------------------------------------------------------------------------
    Populates a Organization's Events from the database
    -------------------------------------------------------------------------------------------------*/
    public function populateEventsFromDb () {
    
        if ($this->organization_id != 0) {
            $q = "WHERE organization_id = '".$this->organization_id."'";
            $this->events = Event::arrayFromDb ($q, $this);
        }
    }
    
    /*-------------------------------------------------------------------------------------------------
    Populates a Organization from POST data from a Form
    -------------------------------------------------------------------------------------------------*/
    public function populateFromPostData ($post_data) {

        $this->populateFromAssocData ($post_data);
    }

    /*-------------------------------------------------------------------------------------------------
    Finds a populates a Organization from a organization_id
    -------------------------------------------------------------------------------------------------*/
    public function findInDb ($organization_id) {

        $q = 'SELECT * 
              FROM organizations 
              WHERE organization_id = '.$organization_id;
        $row = DB::instance(DB_NAME)->select_row($q);

        if (isset($row))
            $this->populateFromDb($row);

        return $row;
    }

    /*-------------------------------------------------------------------------------------------------
    Static/Class method to get an array of Organization objects
    -------------------------------------------------------------------------------------------------*/
    public static function arrayFromDb ($condition = NULL) {

        # Build the query to get all the users
        $q = 'SELECT * 
              FROM organizations';

        if (isset($condition))
            $q = $q." ".$condition;
              
        # Execute the query to get all the organizations.
        $rows = DB::instance(DB_NAME)->select_rows($q);

        $organizations = array();

        foreach ($rows as $row) {
            $organization = new Organization();
            $organization->populateFromDb($row);
            $organizations[] = $organization;
        }
        
        return $organizations;    
    }

    /*-------------------------------------------------------------------------------------------------
    Generates an associative array from the Organization object
    -------------------------------------------------------------------------------------------------*/
    private function generateAssocData (&$_data) {

        $_data['organization_id'] = $this->organization_id;
        $_data['type'] = $this->type;
        $_data['created'] = $this->created;
        $_data['modified'] = $this->modified;
        $_data['user_id'] = $this->user_id;
        $_data['name'] = $this->name;
        $_data['description'] = $this->description;
        $this->address->generateAssocData ($_data);
        $_data['phone'] = $this->phone;
        $_data['website'] = $this->website;
        $_data['email'] = $this->email;
        $_data['director'] = $this->director;
        $_data['image_url'] = $this->image_url;

    }

    /*-------------------------------------------------------------------------------------------------
    Adds a new database row with the Organization data
    -------------------------------------------------------------------------------------------------*/
    public function addToDb ($user_id) {

        $_data = array();
        $this->generateAssocData ($_data);
        
        # Associate this Organization with this User
        $_data['user_id'] = $user_id;
        
        # Unix timestamp of when this Organization was created / modified
        $_data['created'] = Time::now();
        $_data['modified'] = Time::now();   
        
        return DB::instance(DB_NAME)->insert('organizations', $_data);
    }

    /*-------------------------------------------------------------------------------------------------
    Updates an existing Organization database row
    -------------------------------------------------------------------------------------------------*/
    public function updateToDb ($user_id) {
     
        if ($this->user_id != $user_id) {
            # Can't update this
            return 0;
        }

        $_data = array();
        $this->generateAssocData ($_data);
        
        # Unix timestamp of when this Organization was created / modified
        $_data['modified'] = Time::now();   
        
        $q = "WHERE organization_id = '".$this->organization_id."'";
        return DB::instance(DB_NAME)->update("organizations", $_data, $q);
    }

    /*-------------------------------------------------------------------------------------------------
    Deletes a Organization database row
    -------------------------------------------------------------------------------------------------*/
    public function deleteFromDb ($user_id) {
    
        if ($this->user_id != $user_id) {
            # Can't delete this
            return 0;
        }

        # Delete the Organization from the organizations table
        $q = "WHERE organization_id = '".$this->organization_id."'";
        return DB::instance(DB_NAME)->delete('organizations', $q);
    
    }

} #eoc
    