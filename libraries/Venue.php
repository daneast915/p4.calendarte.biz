<?php

require_once 'includes/dateformats.php';
require_once 'includes/findinxml.php';

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