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
     * not existing properties will be created
     */
    function map($sourceObject, $destinationClass)
    {
        foreach ($sourceObject as $key=>$value) 
        {
            $destinationClass->$key = $value;
        }
        return $destinationClass;
    }

    /**
     * Mapping just existing properties from source class to destination class
     */
    function mapExactly($sourceObject, $destinationClass)
    {
        foreach ($sourceObject as $key=>$value) 
        {
            if(property_exists($destinationClass, $key)){
                $destinationClass->$key = $value;
            }
        }
        return $destinationClass;
    }
}
?>