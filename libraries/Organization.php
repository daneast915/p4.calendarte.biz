<?php

require_once 'includes/dateformats.php';
require_once 'includes/findinxml.php';
   
//-----------------------------------------------------------------------------
// Arts Organization
//-----------------------------------------------------------------------------
class Organization
    {
    public      $id;
    public      $type;
    public      $name;
    public      $description;
    public      $address;
    public      $phone;
    public      $website;
    public      $email;
    public      $director;
    public      $firstImage;    
    public      $images;        // []
    public      $events;        // []
    
    function populateFromXML ($organizationXML)
        {
        $this->id = $organizationXML->id;
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
        $this->firstImage = NULL;
        
        if (isset ($organizationXML->images))
            {
            foreach ($organizationXML->images as $imageXML)
                {
                if ($i == 0 && isset($imageXML->image) && strlen($imageXML->image) > 0)
                    $this->firstImage = $imageXML->image;
                $this->images[$i++] = $imageXML->image;        // []
                }
            }
        }

    function populateEventsFromXML ($eventsXML, $organizationsXML, $showsXML, $venuesXML)
        {
        $eventresults = findOrganizationEvents ($eventsXML, $this->id);
        if (count($eventresults) > 0) 
            {
            $i = 0;            
            while (list( , $eventXML) = each($eventresults)) 
	            {
                $eventInstance = new Event(); 
                $eventInstance->populateFromXML($eventXML, $organizationsXML, $this);
                $eventInstance->populateShowsFromXML ($eventsXML, $organizationsXML, $showsXML, $venuesXML, $this);
                $this->events[$i++] = $eventInstance;         // []
                }
            }
        }
    }
    