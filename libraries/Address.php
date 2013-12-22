<?php

//-----------------------------------------------------------------------------
// Address with street, box, city, state & zip
//-----------------------------------------------------------------------------
class Address {
    public      $street;
    public      $box;
    public      $city;
    public      $state;
    public      $zipcode;
    
    function populateFromXML ($addressXML) {
        $this->street = $addressXML->street;
        $this->box = $addressXML->box;
        $this->city = $addressXML->city;
        $this->state = $addressXML->state;
        $this->zipcode = $addressXML->zipcode;
    }
    
    function populateFromAssocData ($assoc_data) {
        $this->street = $assoc_data['address_street'];
        $this->box = isset($assoc_data['address_box']) ? $assoc_data['address_box'] : '';
        $this->city = $assoc_data['address_city'];
        $this->state = $assoc_data['address_state'];
        $this->zipcode = $assoc_data['address_zipcode'];
    }
    
    function generateAssocData (&$assoc_data) {
        $assoc_data['address_street'] = $this->street;
        $assoc_data['address_box'] = $this->box;
        $assoc_data['address_city'] = $this->city;
        $assoc_data['address_state'] = $this->state;
        $assoc_data['address_zipcode'] = $this->zipcode;
    }
}