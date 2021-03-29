<?php
class Entity
{
    /**
     * Returning properties
     */
    public function getProperties() 
    {
        return get_object_vars($this);
    }

    /**
     * Getting ID from entity
     */
    public function getID()
    {
        $result = "";
        $reflector = new ReflectionClass($this);

        $comment = $reflector->getDocComment();
        $comment = explode("@key ", $comment);

        foreach($comment as $key =>$value)
        {
            $comment = explode(",", $value);
        }
        $comment = array_map(array($this, 'commentTrim'), $comment);
        return $comment;
    }

    /**
     * Helper method to trim comment
     */
    private function commentTrim($param)
    {
        return trim(rtrim($param, "*/"));
    }
}
?>