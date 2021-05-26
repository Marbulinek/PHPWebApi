<?php
    include_once "../autoload.php";
    $usersControl = new UsersController();
    $usersControl->getUsers();
    $usersControl->getResponse();
?>