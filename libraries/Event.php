<?php

require_once 'includes/dateformats.php';
require_once 'includes/findinxml.php';

//-----------------------------------------------------------------------------
// Event - put on by an organization - can have multiple shows/concerts
//-----------------------------------------------------------------------------
class Event
    {
    public      $id;
    public      $name;
    public      $organization;
    public      $description;
    public      $category;
    public      $genre;
    public      $website;
    public      $admissionInfo;
    public      $shows;         // []
    public      $performers;    // []
    public      $firstImage;
    public      $topPick;
    
    function populateFromXML ($eventXML, $organizationsXML, $organizationIn = NULL)
        {
        $this->id = $eventXML->id;

        if (isset($organizationIn))
            $this->organization = $organizationIn;
        else
            {
            $organizationXML = findOrganization ($organizationsXML, $eventXML->organization);
            if (isset($organizationXML))
                {
                $this->organization = new Organization();
                $this->organization->populateFromXML ($organizationXML);
                }
            }
            
        $this->name = $eventXML->name;
        $this->description = $eventXML->description;
        $this->category = $eventXML->category;
        $this->genre = $eventXML->genre;
        $this->website = $eventXML->website;
        $this->admissionInfo = $eventXML->addmissioninfo;
        $this->topPick = !empty($eventXML->toppick) ? true : false;

        $i = 0;
        if (isset ($eventXML->performers))
            {
            foreach ($eventXML->performers as $performer)
                $this->performers[$i++] = $performer;        // []
            }
            
        $this->firstImage = $this->organization->firstImage;
        }           

    function populateShowsFromXML ($eventsXML, $organizationsXML, $showsXML, $venuesXML, $organizationIn = NULL)
        {
        $showresults = findEventShows ($showsXML, $this->id);
        if (count($showresults) > 0) 
            {
            $i = 0;            
            while (list( , $showXML) = each($showresults)) 
	            {
                $showInstance = new Show(); 
                $showInstance->populateFromXML($showXML, $eventsXML, $organizationsXML, $venuesXML, $this, $organizationIn);
                $this->shows[$i++] = $showInstance;         // []
                }
            }
        }
    }
    