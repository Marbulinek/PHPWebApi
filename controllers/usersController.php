<?php
/**
 * Example control of user
 */
class UsersController extends WebApi
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

        // set the result into display json property
        $this->setResult($users);
    }

    function login()
    {
        // get data from request
        $data = $this->getDataInput();

        $user = $this->repository->select()
                         ->join("Auth", "`Users`.`auth_id`=`Auth`.`auth_id`")
                         ->where("`email` LIKE '".$data["email"]."' ")
                         ->build();

        // set the result into display json property
        $this->setResult($user);
    }

    // return all users, but request need to contain authentification token
    function getUsersAuth()
    {
        // we need to set correct BEARER token
        $data = $this->getAuthDataInput();
    
        // prepare repository for users
        $users = $this->repository->select()
                                   ->build();
            
        // set the result into display json property
        $this->setResult($users);
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

        // set the result into display json property
        $this->setResult($user);
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