<?php

/***
 * Example of POST
 * 
    [
        {
            "name": null,
            "email": null,
            "firstName": "Ljuk Biskvit",
            "lastName": "ljuk.biskvit@gmail.com"
        }
    ]
 */

include "../controls/usersControl.php";

$usersControl = new UsersControl();
$usersControl->postUser();

?>