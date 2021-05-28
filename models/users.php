<?php 

/** 
 * @key user_id 
 */
class Users extends Entity
{
    public $user_id;
    public $name;
    public $email;

    // authentification token
    public $auth_id;
    public $auth;
}
?>