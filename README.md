# PHP WEBAPI
 [![ForTheBadge built-with-love](http://ForTheBadge.com/images/badges/built-with-love.svg)](https://GitHub.com/Marbulinek/PHPWebApi)

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT) [![GitHub contributors](https://img.shields.io/github/contributors/Marbulinek/PHPWebApi.svg)](https://GitHub.com/Marbulinek/PHPWebApi/graphs/contributors/) [![GitHub issues](https://img.shields.io/github/issues/Marbulinek/PHPWebApi.svg)](https://GitHub.com/Marbulinek/PHPWebApi/issues/) 

Example of REST in php for User data.
There is SQL script called DatabaseMock.sql for database table "Test" which you need to create.

Project contains simple queries from/to database.

# FOLDER HIERARCHY

| Folder name   |      Info      |
|----------|:-------------:
| api | Contains .php endpoint files which are calling controllers |
| controllers | Contains controll classes, e.g.: UserController, ProductController etc. Used for storing repositories, getting values. |
| core | Contains core libraries, like automapper, webapi, repositories |
| models | Contains custom models, like UserModel, ProductModel.. |
| modules | Contains custom models like Authentification module or different custom specific modules |
| services | Contains services for executing business logic |

# EXAMPLE
Create model with properties user_id, name and email. Extends with Entity to support Repository. With class comment @key you will specify key[s] for database. Multiple keys are delimited by ",".
PhpWebApi now supports module for Authentification tokens in request.

```php
<?php 
/** @key user_id */
class User extends Entity 
{
  public $user_id;
  public $name;
  public $email;
  
  // authentification token
  public $auth_id;
  public $auth;
}
?>
```

Create control - here you can manipulate data. Specify custom methods for retrieving data. WebApi supports simple repository with CRUD operations, 

```php
<?php
/**
 * Example control of user
 */
class UsersController extends WebApi
{
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

    // delete user by ID
    function deleteUserById()
    {
        //get user from json body
        $data = $this->getDataInput();
        $user = $this->userLogicService->updateUserById($data);
    }
}
?>
```

# API CALLS
## GET

### /api/getUsers.php
```javascript
[
    {
        "user_id": "1",
        "name": "John Doe",
        "email": "john.doe@gmail.com",
        "auth_id": "26",
        "auth": {
            "auth_id": "26",
            "token": "253fa15166a546ed05031a72e09f96d9",
            "expiration": "2021-05-28 15:15:25"
        }
    },
    {
        "user_id": "2",
        "name": "Ljuk Biskvit",
        "email": "testovic_new@gmail.com",
        "auth_id": "2",
        "auth": {
            "auth_id": "2",
            "token": "583da5a5427ea0d0121f9116cfbac05b",
            "expiration": "2021-05-30 00:00:00"
        }
    },
    {
        "user_id": "3",
        "name": "Domca Tofinka",
        "email": "domca.tofinka@yahoo.com",
        "auth_id": "3",
        "auth": {
            "auth_id": "3",
            "token": "040c821e2be47d0d38455bd3ddd7b0d2",
            "expiration": "2021-05-30 00:00:00"
        }
    }
]
```

## POST
### /api/login.php

#### request
```javascript
{
  "email": "john.doe@gmail.com"
}
```

#### result
```javascript
{
    "user_id": "1",
    "name": "John Doe",
    "email": "john.doe@gmail.com",
    "auth_id": "26",
    "auth": {
        "auth_id": "26",
        "token": "253fa15166a546ed05031a72e09f96d9",
        "expiration": "2021-05-28 15:15:25"
    }
}
```


### /api/postUser.php

```javascript
{
  "name": "New User",
  "email": "new.user@mail.com"
}
```

## POST
### /api/selectUserById.php

#### request
```javascript
{
  "user_id": 2
}
```

#### result
```javascript
{
  "user_id": "2",
  "name": "Ljuk Biskvit",
  "email": "ljuk.biskvit@gmail.com"
}
```

## POST
### /api/updateUserById.php
#### request
All entity keys should be listed here (user_id) and email will be changed.
```javascript
{
  "user_id": "2",
  "email": "testovic_new@gmail.com"
}
```

## POST
### /api/deleteUserById.php
#### request
All entity keys should be listed here (user_id) and entity will be deleted from repository

```javascript
{
  "user_id": "2",
  "email": "testovic_new@gmail.com"
}
```

# Authentification
There is new modul Authentificaion, which is authentificating request to api. Database table *auth* where are tokens stored. In Authentification.php file there are prepared methods for verify and regenerate tokens. Just implements custom logic and use it.

# Mapping
How to use mapping of properties? Included automapper copy all same named properties (source/destination) of objects. AutoMapper supports mapping nested properties if they are same named as data entities. Arrays are not supported nowadays.

```php
<?php
// we will fetch users data from db
$row = $this->query->fetch_array(MYSQLI_ASSOC);
 
// automapper will copy all properties from source to destination (never mind that properties doesnt exists in destination)
$user = $this->mapper->map($row, new Users());

// copy just exactly same properties from source, which are also in the destination
$user = $this->mapper->mapExactly($row, new Users());

// same as mapExactly + map exactly all nested objects properties
$user = $this->mapper->mapNested($row, new Users());

// copy all results from database query, doesnt matter if its arrray or single response
$user = $this->mapper->mapComplete($row, new Users());
?>
```

