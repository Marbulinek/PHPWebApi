<?php
include_once "../core/autoload.php";

/**
 * Example control of user
 */
class UsersControl extends WebApi
{
    
    private $repository;

    function __construct()
    {
        parent::__construct();
        
        // create repository of USERS
        $this->repository = new Repository(new Users());
    }

    // get all users
    function getUsers()
    {
        // prepare repository for users
        $users = $this->repository->select()
                                  ->build();

        // get the result into display json property
        array_push($this->result, $users);
    }

    // function for posting user
    function postUser()
    {
        //get user from json body
        $data = $this->getDataInput();
        
        //map user
        $user = $this->mapper->map($data, new Users());

        //save in repository
        $this->repository->insert($user)
                         ->build();
    }

    // select user by ID
    function selectUserById()
    {
        $data = $this->getDataInput();

        // prepare repository for users
        $users = $this->repository->select("user_id, name, email")
                                  ->where("`user_id` LIKE '".$data["user_id"]."' ")
                                  ->build();

        // get the result into display json property
        array_push($this->result, $users);
    }

    // update user by ID
    function updateUserById()
    {
        //get user from json body
        $data = $this->getDataInput();

        //map user
        $user = $this->mapper->map($data, new Users());

        //save in repository
        $this->repository->update($user)
                         ->build();
    }

    // update user by ID
    function deleteUserById()
    {
        //get user from json body
        $data = $this->getDataInput();
    
        //map user
        $user = $this->mapper->map($data, new Users());
    
        //save in repository
        $this->repository->delete($user)
                         ->build();
    }
}
?>