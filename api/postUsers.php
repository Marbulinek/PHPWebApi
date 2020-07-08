<?php
include "../core/database.php";
include "../models/usersDto.php";

//db connect
$db = new Database();

//post data
$data = json_decode(file_get_contents('php://input'), true);

$user = new UsersDto();
$user->name = $data["name"];
$user->email = $data["email"];

//send to database
$db->query("INSERT INTO `Users`(`name`,`email`) VALUES('".$user->name."', '".$user->email."')");
print_r($user);
?>