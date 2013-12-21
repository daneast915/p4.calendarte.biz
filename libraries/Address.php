<?php

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