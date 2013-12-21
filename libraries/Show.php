<?php

require_once 'includes/dateformats.php';
require_once 'includes/findinxml.php';

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
