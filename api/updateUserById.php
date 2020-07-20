<?php

    /***
    * Example of JSON
        [
            {
                "user_id": "2",
                "email": "testovic_new@gmail.com"
            }
        ] 
    */
    include "../controls/usersControl.php";

    $usersControl = new UsersControl();
    $usersControl->updateUserById();
?>