<?php
class Automapper
{
    function __construct()
    {
    }

    function map($sourceObject, $destinationClass)
    {
        foreach ($sourceObject as $key=>$value) {
            $destinationClass->$key = $sourceObject[$key];
        }
        return $destinationClass;
    }
}
?>