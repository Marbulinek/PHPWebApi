<?php
include "../controls/usersControl.php";

$usersControl = new UsersControl();
$usersControl->getUsers();

$usersControl->printHeaders();
?>