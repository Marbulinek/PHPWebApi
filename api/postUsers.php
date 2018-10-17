<?php
include "../core/database.php";
include "../models/usersDto.php";

//db connect
$db = new Database();

//post data
$data = json_decode(file_get_contents('php://input'), true);

$user = new UsersDto();
$user->user_id = $data["user_id"];
$user->name = $data["name"];
$user->email = $data["email"];

//send to database
print_r($user);
?>