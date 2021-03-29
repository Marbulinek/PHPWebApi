<?php
/**
 * AutoMapper class
 */
class AutoMapper
{
    function __construct()
    {
    }

    /**
     * Mapping properties from source class to destination class
     */
    function map($sourceObject, $destinationClass)
    {
        foreach ($sourceObject as $key=>$value) {
            $destinationClass->$key = $sourceObject[$key];
        }
        return $destinationClass;
    }
}
?>