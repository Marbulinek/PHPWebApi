# PHP WEBAPI
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Example of REST in php for User data.
There is SQL script called DatabaseMock.sql for database table "Test" which you need to create.

Project contains simple queries from/to database.

# FOLDER HIERARCHY

| Folder name   |      Info      |
|----------|:-------------:
| api | Contains .php endpoint files which are calling controllers |
| controls | Contains controll classes, e.g.: UserController, ProductController etc. Used for storing repositories, getting values. |
| core | Contains core libraries, like automapper, webapi, repositories |
| models | Contains custom models, like UserModel, ProductModel.. |


# EXAMPLE
Create model with properties user_id, name and email. Extends with Entity to support Repository. With class comment @key you will specify key[s] for database. Multiple keys will be delimited by ",".

```php
<?php 
include_once "../core/repository/entity.php";

/** @key user_id */
class User extends Entity 
{
  public $user_id;
  public $name;
  public $email;
}
?>
```

Create control - here you can manipulate data. Specify custom methods for retrieving data. WebApi supports simple repository with CRUD operations, 

```php
<?php
include_once "../core/autoloader.php";

/**
 * Example control of user
 */
class UsersControl extends WebApi{
    
    // user repository
    private $repository;

    function __construct()
    {
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
                                  ->where("`user_id` LIKE '".$data["user_id"]."'")
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
```

# API CALLS
## GET

### /api/getUsers.php
```json
[
  {
    "user_id": "1",
    "name": "John Doe",
    "email": "john.doe@mail.com"
  },
  {
    "user_id": "2",
    "name": "Ljuk Biskvit",
    "email": "ljuk.biskvit@gmail.com"
  },
  {
    "user_id": "3",
    "name": "Domca Tofinka",
    "email": "domca.tofinka@yahoo.com"
  }
]
```

## POST

### /api/postUser.php

```json
[
  {
    "name": "New User",
    "email": "new.user@mail.com"
  }
]
```

## POST
### /api/selectUserById.php

#### request
```json
[
  {
    "user_id": 2
  }
]
```

#### result
```json
[
  {
    "user_id": "2",
    "name": "Ljuk Biskvit",
    "email": "ljuk.biskvit@gmail.com"
  }
]
```

## POST
### /api/updateUserById.php
#### request
All entity keys should be listed here (user_id) and email will be changed.
```json
[
  {
    "user_id": "2",
    "email": "testovic_new@gmail.com"
  }
]
```

## POST
### /api/deleteUserById.php
#### request
All entity keys should be listed here (user_id) and entity will be deleted from repository

```json
[
  {
    "user_id": "2",
    "email": "testovic_new@gmail.com"
  }
]
```


# Mapping
How to use mapping of properties? Included automapper copy all same named properties (source/destination) of objects.

```php
// we will fetch users data from db
$row = $this->query->fetch_array(MYSQLI_ASSOC);
 
// automapper will copy same named properties from row to destination object - Users()
$user = $this->mapper->map($row, new Users());
```

