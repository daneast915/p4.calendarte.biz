<?php

include 'dateformats.php';
include 'findinxml.php';

//-----------------------------------------------------------------------------
// Address with street, box, city, state & zip
//-----------------------------------------------------------------------------
class Address
    {
    public      $street;
    public      $box;
    public      $city;
    public      $state;
    public      $zipcode;
    
    function populateFromXML ($addressXML)
        {
        $this->street = $addressXML->street;
        $this->box = $addressXML->box;
        $this->city = $addressXML->city;
        $this->state = $addressXML->state;
        $this->zipcode = $addressXML->zipcode;
        }
    }

//-----------------------------------------------------------------------------
// Show - can be several shows/concerts per Event
//-----------------------------------------------------------------------------
class Show
    {
    public      $id;
    public      $eventId;
    public      $venueId;
    public      $day;
    public      $dateString;
    public      $timeString;

    public      $event;
    public      $venue;
    public      $shortDate;
    public      $longDate;
    public      $shortMonth;
    public      $dayOfMonth;
    public      $shortDay;
    public      $timeOfDay;
    
    function populateFromXML ($showXML, $eventsXML, $organizationsXML, $venuesXML, $eventIn = NULL, $organizationIn = NULL)
        {
        $this->id = $showXML->id;
        $this->eventId = $showXML->event;
        
        if (isset($eventIn))
            $this->event = $eventIn;
        else
            {
            $eventXML = findShowEvent ($eventsXML, $showXML->event);
            $this->event = new Event();
            $this->event->populateFromXML ($eventXML, $organizationsXML, $organizationIn);
            }

        $this->venueId = $showXML->venue;
        $venueXML = findVenue($venuesXML, $showXML->venue);
        if (isset($venueXML))
            {
            $this->venue = new Venue();
            $this->venue->populateFromXML ($venueXML);
            }
            
        $this->day = $showXML->day;
        $this->dateString = $showXML->date;
        $this->timeString = $showXML->time;

        $this->shortDate = getShortDate($this->dateString);
        $this->longDate = getLongDate($this->dateString);
        $this->shortMonth = getShortMonth($this->dateString);
        $this->dayOfMonth = getDayOfMonth($this->dateString);
        $this->shortDay = getShortDay($this->day);
        $this->timeOfDay = get12HourTime($this->timeString);
        }
    }

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
    
//-----------------------------------------------------------------------------
// Venue, location, building
//-----------------------------------------------------------------------------
class Venue
    {
    public      $id;
    public      $name;
    public      $description;
    public      $address;
    public      $phone;
    public      $website;
    public      $email;
    public      $accessibilityInfo;
    public      $firstImage;    
    public      $images;        // []
    
    function populateFromXML ($venueXML)
        {
        $this->id = $venueXML->id;
        $this->name = $venueXML->name;
        $this->description = $venueXML->description;
        $this->address = new Address();
        $this->address->populateFromXML ($venueXML->address);
        $this->phone = $venueXML->phone;
        $this->website = $venueXML->website;
        $this->email = !empty($venueXML->email) ? $venueXML->email : NULL;
        $this->accessibilityInfo = !empty($venueXML->accessibilityinfo) ? $venueXML->accessibilityinfo : NULL;

        $i = 0;
        $this->firstImage = NULL;
        
        if (isset ($venueXML->images))
            {
            foreach ($venueXML->images as $imageXML)
                {
                if ($i == 0 && isset($imageXML->image) && strlen($imageXML->image) > 0)
                    $this->firstImage = $imageXML->image;
                $this->images[$i++] = $imageXML->image;        // []
                }
            }
        }

    }
    
?>
