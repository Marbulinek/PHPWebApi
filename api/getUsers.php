<?php
    include "../core/autoload.php";

    $usersControl = new UsersControl();
    $usersControl->getUsers();

    $usersControl->printHeaders();
?>