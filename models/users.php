<?php 
include_once "../core/repository/entity.php";

/** @key user_id */
 class Users extends Entity {
    public $user_id;
    public $name;
    public $email;
}
?>