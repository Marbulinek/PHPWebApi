<?php
class UserLogicService{
    private $repository;
    private $authRepository;
    private $mapper;
    private $auth;

    function __construct()
    {
        // create repository of USERS
        $this->userRepository = new Repository(new Users());
        $this->authRepository = new Repository(new Auth());
        $this->auth = new Authentification();
        $this->mapper = new AutoMapper();
    }
    
    function processLogin($email)
    {
        if(isset($email))
        {
            $userFound = $this->userRepository->select()
            ->join("Auth", "`Users`.`auth_id`=`Auth`.`auth_id`")
            ->where("`email` LIKE '".$email."' ")
            ->build();

            $user = $this->mapper->mapNested($userFound[0], new Users());

            if($user->auth->token == null){
                $authObj = $this->auth->generate($user->auth);
                if($authObj != null)
                {
                    $user->auth_id = $authObj->auth_id;
                    $user->auth->auth_id = $authObj->auth_id;
                }
            }

            //save users in repository
            $this->userRepository->update($user)
                                ->build();

            // save authentification repository
            $this->authRepository->update($user->auth)
                                ->build();
            return $user;
        }
        return null;
    }

    // get all users
    public function getUsers()
    {
        // prepare repository for users
        $usersFound = $this->userRepository->select()
                                           ->join("Auth", "`Users`.`auth_id`=`Auth`.`auth_id`")
                                           ->build();
        $result = $this->mapper->mapComplete($usersFound, new Users());
        return $result;
    }

    public function postUser($data)
    {
        //map user
        $user = $this->mapper->map($data, new Users());
        //save in repository
        $this->userRepository->insert($user)
                             ->build();
    }

    public function selectUserById($data)
    {
        // prepare repository for users
        $user = $this->userRepository->select()
                                  ->join("Auth", "`Users`.`auth_id`=`Auth`.`auth_id`")
                                  ->where("`user_id` LIKE '".$data["user_id"]."' ")
                                  ->build();

        $user = $this->mapper->mapComplete($user, new Users());
        return $user;
    }

    public function updateUserById($user)
    {
        //map user
        $user = $this->mapper->map($user, new Users());
        //save in repository
        $this->userRepository->update($user)
                         ->build();
    }

    public function deleteUserById($user)
    {
        //map user
        $user = $this->mapper->map($user, new Users());
    
        //save in repository
        $this->userRepository->delete($user)
                         ->build();
    }
}
?>