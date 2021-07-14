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
            if(property_exists($destinationClass, $key))
            {
                $destinationClass->$key = $value;
            }
        }
        return $destinationClass;
    }

    /**
     * Mapping together with all nested properties
     */
    function mapNested($sourceObject, $destinationClass)
    {
        $parentClass = $this->mapExactly($sourceObject, $destinationClass);
        $properties = get_object_vars($destinationClass);
        foreach($properties as $key => $property){
            if($property == null)
            {
                //check if class exists
                if(class_exists($key))
                {
                    $nestedClass = new $key;
                    $parentClass = $this->mapExactly($sourceObject, $nestedClass);
                }
                $destinationClass->$key = $parentClass;
            }
        }
        return $destinationClass;
    }

    /**
     * Complete mapping
     */
    function mapComplete($sourceObjects, $destinationClass)
    {
        if(count($sourceObjects) > 1){
            $result = array();
            foreach($sourceObjects as $sourceObject)
            {
                $result[] = $this->mapNested($sourceObject, new $destinationClass);
            }
            return $result;
        }else{
            $result = $this->mapNested($sourceObjects[0], new $destinationClass);
            return $result;
        }
    }

}
?>