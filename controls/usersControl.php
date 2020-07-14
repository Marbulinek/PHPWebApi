<?php
include_once "../core/webapi.php";
include_once "../models/users.php";

class UsersControl extends WebApi{
    
    // get all users
    function getUsers()
    {
        $this->query = $this->db->query("SELECT * FROM `Users` ");
        while($row = $this->query->fetch_array(MYSQLI_ASSOC))
        {
            $user = $this->mapper->map($row, new Users());

            array_push($this->result, $user);
        }
    }

    // function for posting user
    function postUser()
    {
        $data = $this->getDataInput();

        $user = $this->mapper->map($row, new Users());

        $this->db->query("INSERT INTO `Users` (`name`, `email`)
                     VALUES('".$user->firstName."', '".$user->email."')");
        print_r($user);
    }

    // select user by ID
    function selectUserById()
    {
        $data = $this->getDataInput();

        $this->query = $this->db->query("SELECT * FROM `Users` WHERE `user_id` = '".$data["user_id"]."' ");
        $row = $this->query->fetch_array(MYSQLI_ASSOC);
        
        $user = $this->mapper->map($row, new Users());
        array_push($this->result, $user);
    }
}
?>