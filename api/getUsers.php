<?php
include "core/database.php";
include "models/usersDto.php";

//db connect
$db = new Database();
$query = $db->query("SELECT * FROM `Users` ");

//prepare result array
$result = array();

//fetch data
while($row = $query->fetch_array())
{
    $user = new UsersDto();
    $user->user_id = $row["user_id"];
    $user->name = $row["name"];
    $user->email = $row["email"];
    array_push($result, $user);
}

//return api
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>