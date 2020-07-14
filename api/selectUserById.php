<?php

/***
* Example of JSON
    [
        {
            "user_id": "2"
        }
    ] 
*/
include "../controls/usersControl.php";

$usersControl = new UsersControl();
$usersControl->selectUserById();

$usersControl->printHeaders();
?>