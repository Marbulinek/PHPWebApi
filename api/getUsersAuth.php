<?php
    include_once "../autoload.php";
    $usersControl = new UsersController();
    $usersControl->getUsersAuth();
    $usersControl->getResponse();
?>
