<?php
    include_once "../autoload.php";
    $usersControl = new UsersControl();
    $usersControl->selectUserById();
    $usersControl->printHeaders();
?>