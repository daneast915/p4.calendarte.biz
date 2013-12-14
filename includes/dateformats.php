<?php

//-----------------------------------------------------------------------------
// Gets the date or time in several different formats
//-----------------------------------------------------------------------------

function getLongDate($dateString)
    {
    $date = date_create($dateString);
    $datefmt = date_format($date,"F j, Y");
    return $datefmt;
    }

function getShortDate($dateString)
    {
    $date = date_create($dateString);
    $datefmt = date_format($date,"M j");
    return $datefmt;
    }
    
function get12HourTime($timeString)
    {
    $time = date_create($timeString);
    $timefmt = date_format($time,"g:i a");
    return $timefmt;
    }
    
function getShortMonth($dateString)
    {
    $date = date_create($dateString);
    $datefmt = date_format($date,"M");
    return $datefmt;
    }
    
function getDayOfMonth($dateString)
    {
    $date = date_create($dateString);
    $datefmt = date_format($date,"j");
    return $datefmt;
    }
    
function getShortDay($dayString)
    {
    $datefmt = substr($dayString,0,3);
    return $datefmt;
    }
    
?>