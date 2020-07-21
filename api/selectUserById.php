<?php
    include "../core/autoload.php";

    $usersControl = new UsersControl();
    $usersControl->selectUserById();

    $usersControl->printHeaders();
?>