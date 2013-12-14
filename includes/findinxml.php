<?php

//-----------------------------------------------------------------------------
// Using XML in lieu of MySQL for class project
//-----------------------------------------------------------------------------

//-----------------------------------------------------------------------------
// Uses simplexml_load_file core PHP function to read in XML
//-----------------------------------------------------------------------------

function getEvents()
    {
    $eventsXML = simplexml_load_file("xmldata/events.xml")
			        or die("Error: Cannot read XML file: events.xml");
    return $eventsXML;
    }

function getShows()    
    {
    $showsXML = simplexml_load_file("xmldata/shows.xml")
			        or die("Error: Cannot read XML file: shows.xml");
    return $showsXML;
    }

function getVenues()
    {
    $venuesXML = simplexml_load_file("xmldata/venues.xml")
			        or die("Error: Cannot read XML file: venues.xml");
    return $venuesXML;
    }

function getOrganizations()
    {
    $organizationsXML = simplexml_load_file("xmldata/organizations.xml")
			        or die("Error: Cannot read XML file: organizations.xml");
    return $organizationsXML;
    }

//-----------------------------------------------------------------------------
// Uses xpath function to get matching XML elements
//-----------------------------------------------------------------------------
                    
function findEventShows($showsXML, $id) 
    {
    $expression = '/shows/show[event=' . $id . ']';
    $shows = $showsXML->xpath($expression);
    return $shows;
    }

function findShowEvent($eventsXML, $id) 
    {
    $expression = '/events/event[id=' . $id . ']';
    $event = $eventsXML->xpath($expression);
    if (isset($event))
        return $event[0];
    return NULL;
    }

function findEvent($eventsXML, $id) 
    {
    $expression = '/events/event[id=' . $id . ']';
    $event = $eventsXML->xpath($expression);
    if (isset($event))
        return $event[0];
    return NULL;
    }

function findVenue($venuesXML, $id) 
    {
    $expression = '/venues/venue[id=' . $id . ']';
    $venue = $venuesXML->xpath($expression);
    if (isset($venue))
        return $venue[0];
    return NULL;
    }

function findOrganization($organizationsXML, $id) 
    {
    $expression = '/organizations/organization[id=' . $id . ']';
    $organization = $organizationsXML->xpath($expression);
    if (isset($organization))
        return $organization[0];
    return NULL;
    }
                    
function findOrganizationEvents($eventsXML, $id) 
    {
    $expression = '/events/event[organization=' . $id . ']';
    $events = $eventsXML->xpath($expression);
    return $events;
    }
                    
function findVenueShows($showsXML, $id) 
    {
    $expression = '/shows/show[venue=' . $id . ']';
    $shows = $showsXML->xpath($expression);
    return $shows;
    }    
?>