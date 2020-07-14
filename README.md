# PHP WebApi
[![Build Status](https://travis-ci.org/Marbulinek/PHPWebApi.svg?branch=master)](https://travis-ci.org/Marbulinek/PHPWebApi)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Example of REST in php for User data.
There is SQL script called DatabaseMock.sql for database table "Test" which you need to create.

Project contains simple queries from/to database.

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

### /api/postUsers.php

```json
{
  "name": "New User",
  "email": "new.user@mail.com"
}
```

## POST
### /api/selectUserById.php

#### request
```json
{
  "user_id": 2
}
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
