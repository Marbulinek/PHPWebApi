# PHP WebApi
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


# Mapping
How to use mapping of properties? Included automapper copy all same named properties (source/destination) of objects.

```php
  // we will fetch users data from db
  $row = $this->query->fetch_array(MYSQLI_ASSOC);
  
  // automapper will copy same named properties from row to destination object - Users()
  $user = $this->mapper->map($row, new Users());
```