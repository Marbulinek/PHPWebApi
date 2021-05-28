<?php
/**
 * Example control of user
 */
class UsersController extends WebApi
{
    
    private $repository;
    private $authRepository;
    private $userLogicService;

    function __construct()
    {
        parent::__construct();
        
        $this->userLogicService = new UserLogicService();
    }

    // get all users
    function getUsers()
    {
        // prepare repository for users
        $users = $this->userLogicService->getUsers();
        // set the result into display json property
        $this->setResult($users);
    }

    function login()
    {
        // get data from request
        $data = $this->getDataInput();
        $user = $this->userLogicService->processLogin($data["email"]);
        // set the result into display json property
        $this->setResult($user);
    }

    // return all users, but request need to contain authentification token
    function getUsersAuth()
    {
        // we need to set correct BEARER token
        $this->getAuthDataInput();
        $users = $this->userLogicService->getUsers();
        // set the result into display json property
        $this->setResult($users);
    }

    // function for posting user
    function postUser()
    {
        //get user from json body
        $data = $this->getDataInput();
        $this->userLogicService->postUser($data);
    }

    // select user by ID
    function selectUserById()
    {
        $data = $this->getDataInput();
        // prepare repository for users
        $user = $this->userLogicService->selectUserById($data);
        // set the result into display json property
        $this->setResult($user);
    }

    // update user by ID
    function updateUserById()
    {
        //get user from json body
        $data = $this->getDataInput();
        $user = $this->userLogicService->updateUserById($data);
    }

    // update user by ID
    function deleteUserById()
    {
        //get user from json body
        $data = $this->getDataInput();
        $user = $this->userLogicService->updateUserById($data);
    }
}
?>