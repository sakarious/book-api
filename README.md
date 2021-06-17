# Book Information API

> ### Laravel Book API documentation.

---

# Description

[Book Information](https://github.com/sakarious/book-api) API Backend for book information application.

# Setup

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x/installation)

Clone the repository

    git clone https://github.com/sakarious/book-api.git

Switch to the repo folder

    cd book-api

Install all the dependencies using composer

    composer install

Create a '.env' file and copy the .env.example file and make the required configuration changes in the .env file. The API uses a MySQL database. Download and install [XAMPP](https://www.apachefriends.org/download.html) and create a database. Replace the following in your .env file

-   DB_CONNECTION=mysql
-   DB_HOST=127.0.0.1
-   DB_PORT=3306
-   DB_DATABASE={DATABASE CREATED WITH XAMPP}
-   DB_USERNAME=root
-   DB_PASSWORD=(Put in your password if any else leave blank)

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

The api can be accessed at [http://localhost:8000/api](http://localhost:8000/api).

## Test

```bash

# Run tests

$ php artisan test

```

## API Specification

## Features

-   Calls an external API service to get information about books.
-   Get all Books
-   Search for Book by name, country, publisher, release year.
-   Get Book By ID
-   Create Book
-   Update Book
-   Delete Book

## Allowed HTTP Requests

-   GET : Get a resource or list of resources
-   POST : Create a resource
-   PATCH : Update a resource
-   DELETE : Delete a resource

## Base URL

`http://127.0.0.1:8000/api`

## Endpoints

`GET: api/external-books?name=a game of thrones` - Calls an external API service to get information about book where name is a query parametwer for name of book.
`GET: /v1/books` - Get all Books.
`GET: /v1/books?name=Sakarious` - Search for book by name where name is a query parameter for name of book.
`GET: /v1/books?country=Nigeria` - Search for book by country where country is a query parameter for country of book.
`GET: /v1/books?publisher=Da Genius` - Search for book by publisher where publisher is a query parameter for publisher of book.
`GET: /v1/books?release_year=2020` - Search for book by release year where release_year is a query parameter for year of book.
`GET: /v1/books/{id}` - Get a book where Book ID is {id}.
`POST: /v1/books` - Create a Book.
`PATCH: /v1/books/{id}` - Update a book where ID if book to be updated is {id}.
`Delete: /v1/books/{id}` - Delete a book where Book ID is {id}.
`POST: /v1/books/{id}/delete` - Delete a book where Book ID is {id}.

## Resources

### Get Book Information from external API service

---

Returns json data of all books to the application.

-   **URL and Method**
    `GET http://127.0.0.1:8000/api/external-books?name=a game of thrones`

-   **URL Params**
    `/external-books?name={name_of_book}`

    **Required:**

`Name of Book {name_of_book} =[string]`

-   **Success Response**

```
Status 200 OK
Content-Type: application/json; charset=utf-8

{
  "status_code": 200,
  "status": "success",
  "data": {
    "name": "A Game of Thrones",
    "isbn": "978-0553103540",
    "authors": [
      "George R. R. Martin"
    ],
    "number_of_pages": 694,
    "publisher": "Bantam Books",
    "country": "United States",
    "release_date": "1996-08-01T00:00:00"
  }
}
```

Where Book Response Object is:

| Field           | Type     | Description                              |
| --------------- | -------- | ---------------------------------------- |
| status_code     | interger | Status code of request.                  |
| status          | string   | Status of request                        |
| data            | object   | Object containing information about book |
| name            | string   | Name of book                             |
| isbn            | string   | ISBN of book                             |
| authors         | Array    | Author(s) of book.                       |
| number_of_pages | integer  | Number of book pages                     |
| publisher       | string   | Book publisher                           |
| country         | string   | Country of book.                         |
| release_date    | string   | Release Date of book.                    |

-   **Request Successful but Empty Response** - Simply means there's no information about requested book.

```
Status 200 OK
{
  "status_code": 200,
  "status": "success",
  "data": []
}
```

### Get all Books Information

---

Returns json data of information of books to the application.

-   **URL and Method**
    `GET http://127.0.0.1:8000/api/v1/books`

-   **Success Response**

```
Status 200 OK
Content-Type: application/json; charset=utf-8

{
  "status_code": 200,
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Raputuralized",
      "isbn": "123-3213243567",
      "authors": [
        "John Doe",
        " Jackson"
      ],
      "country": "United States",
      "number_of_pages": 350,
      "publisher": "Sakarious",
      "release_date": "2018-09-08 00:00:00"
    },
    {
      "id": 3,
      "name": "Sakarious",
      "isbn": "123-432-21",
      "authors": [
        "Sakarious"
      ],
      "country": "Nigeria",
      "number_of_pages": 122,
      "publisher": "Oluwashegs",
      "release_date": "2019-01-01 00:00:00"
    }

  ]
}
```

Where Book Response Object is:

| Field           | Type     | Description                              |
| --------------- | -------- | ---------------------------------------- |
| status_code     | interger | Status code of request.                  |
| status          | string   | Status of request                        |
| data            | object   | Object containing information about book |
| id              | string   | unique identifier for book               |
| name            | string   | Name of book                             |
| isbn            | string   | ISBN of book                             |
| authors         | Array    | Author(s) of book.                       |
| number_of_pages | integer  | Number of book pages                     |
| publisher       | string   | Book publisher                           |
| country         | string   | Country of book.                         |
| release_date    | string   | Release Date of book.                    |

-   **Request Successful but Empty Response** - Simply means there's no information in the database.

```
Status 200 OK
{
  "status_code": 200,
  "status": "success",
  "data": []
}
```

### Search for Book by Name

---

Returns json data of information of books to the application.

-   **URL and Method**
    `GET http://127.0.0.1:8000/api/v1/books?name=Sakarious`

-   **URL Params**
    `/v1/books?name={name}`

    **Required:**

`Name {name} =[string]`

-   **Success Response**

```
Status 200 OK
Content-Type: application/json; charset=utf-8

{
  "status_code": 200,
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Sakarious",
      "isbn": "123-3213243567",
      "authors": [
        "John Doe",
        " Jackson"
      ],
      "country": "United States",
      "number_of_pages": 350,
      "publisher": "Sakarious",
      "release_date": "2018-09-08 00:00:00"
    }
  ]
}
```

Where Book Response Object is:

| Field           | Type     | Description                              |
| --------------- | -------- | ---------------------------------------- |
| status_code     | interger | Status code of request.                  |
| status          | string   | Status of request                        |
| data            | object   | Object containing information about book |
| id              | string   | unique identifier for book               |
| name            | string   | Name of book                             |
| isbn            | string   | ISBN of book                             |
| authors         | Array    | Author(s) of book.                       |
| number_of_pages | integer  | Number of book pages                     |
| publisher       | string   | Book publisher                           |
| country         | string   | Country of book.                         |
| release_date    | string   | Release Date of book.                    |

-   **Request Successful but Empty Response** - Simply means there's no information with book name given.

```
Status 200 OK
{
  "status_code": 200,
  "status": "success",
  "data": []
}
```

### Search for Book by Country

---

Returns json data of information of books to the application.

-   **URL and Method**
    `GET http://127.0.0.1:8000/api/v1/books?country=United States`

-   **URL Params**
    `/v1/books?country={country}`

    **Required:**

`Country {country} =[string]`

-   **Success Response**

```
Status 200 OK
Content-Type: application/json; charset=utf-8

{
  "status_code": 200,
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Sakarious",
      "isbn": "123-3213243567",
      "authors": [
        "John Doe",
        " Jackson"
      ],
      "country": "United States",
      "number_of_pages": 350,
      "publisher": "Sakarious",
      "release_date": "2018-09-08 00:00:00"
    }
  ]
}
```

Where Book Response Object is:

| Field           | Type     | Description                              |
| --------------- | -------- | ---------------------------------------- |
| status_code     | interger | Status code of request.                  |
| status          | string   | Status of request                        |
| data            | object   | Object containing information about book |
| id              | string   | unique identifier for book               |
| name            | string   | Name of book                             |
| isbn            | string   | ISBN of book                             |
| authors         | Array    | Author(s) of book.                       |
| number_of_pages | integer  | Number of book pages                     |
| publisher       | string   | Book publisher                           |
| country         | string   | Country of book.                         |
| release_date    | string   | Release Date of book.                    |

-   **Request Successful but Empty Response** - Simply means there's no book information with country given.

```
Status 200 OK
{
  "status_code": 200,
  "status": "success",
  "data": []
}
```

### Search for Book by Country

---

Returns json data of information of books to the application.

-   **URL and Method**
    `GET http://127.0.0.1:8000/api/v1/books?publisher=Sakarious`

-   **URL Params**
    `/v1/books?publisher={publisher}`

    **Required:**

`Publisher {publisher} =[string]`

-   **Success Response**

```
Status 200 OK
Content-Type: application/json; charset=utf-8

{
  "status_code": 200,
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Sakarious",
      "isbn": "123-3213243567",
      "authors": [
        "John Doe",
        " Jackson"
      ],
      "country": "United States",
      "number_of_pages": 350,
      "publisher": "Sakarious",
      "release_date": "2018-09-08 00:00:00"
    }
  ]
}
```

Where Book Response Object is:

| Field           | Type     | Description                              |
| --------------- | -------- | ---------------------------------------- |
| status_code     | interger | Status code of request.                  |
| status          | string   | Status of request                        |
| data            | object   | Object containing information about book |
| id              | string   | unique identifier for book               |
| name            | string   | Name of book                             |
| isbn            | string   | ISBN of book                             |
| authors         | Array    | Author(s) of book.                       |
| number_of_pages | integer  | Number of book pages                     |
| publisher       | string   | Book publisher                           |
| country         | string   | Country of book.                         |
| release_date    | string   | Release Date of book.                    |

-   **Request Successful but Empty Response** - Simply means there's no book information with publisher given.

```
Status 200 OK
{
  "status_code": 200,
  "status": "success",
  "data": []
}
```

### Search for Book by Release Year

---

Returns json data of information of books to the application.

-   **URL and Method**
    `GET http://127.0.0.1:8000/api/v1/books?release_year=2018`

-   **URL Params**
    `/v1/books?release_year={release_year}`

    **Required:**

`Release year {release_year} =[integer]`

-   **Success Response**

```
Status 200 OK
Content-Type: application/json; charset=utf-8

{
  "status_code": 200,
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Sakarious",
      "isbn": "123-3213243567",
      "authors": [
        "John Doe",
        " Jackson"
      ],
      "country": "United States",
      "number_of_pages": 350,
      "publisher": "Sakarious",
      "release_date": "2018-09-08 00:00:00"
    }
  ]
}
```

Where Book Response Object is:

| Field           | Type     | Description                              |
| --------------- | -------- | ---------------------------------------- |
| status_code     | interger | Status code of request.                  |
| status          | string   | Status of request                        |
| data            | object   | Object containing information about book |
| id              | string   | unique identifier for book               |
| name            | string   | Name of book                             |
| isbn            | string   | ISBN of book                             |
| authors         | Array    | Author(s) of book.                       |
| number_of_pages | integer  | Number of book pages                     |
| publisher       | string   | Book publisher                           |
| country         | string   | Country of book.                         |
| release_date    | string   | Release Date of book.                    |

-   **Request Successful but Empty Response** - Simply means there's no book information with release year given.

```
Status 200 OK
{
  "status_code": 200,
  "status": "success",
  "data": []
}
```

### Get Book by ID

---

Returns json data of information of books to the application.

-   **URL and Method**
    `GET http://127.0.0.1:8000/api/v1/books/1`

-   **URL Params**
    `/v1/books/{id}`

    **Required:**

`Book ID {id} =[integer]`

-   **Success Response**

```
Status 200 OK
Content-Type: application/json; charset=utf-8

{
  "status_code": 200,
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Sakarious",
      "isbn": "123-3213243567",
      "authors": [
        "John Doe",
        " Jackson"
      ],
      "country": "United States",
      "number_of_pages": 350,
      "publisher": "Sakarious",
      "release_date": "2018-09-08 00:00:00"
    }
  ]
}
```

Where Book Response Object is:

| Field           | Type     | Description                              |
| --------------- | -------- | ---------------------------------------- |
| status_code     | interger | Status code of request.                  |
| status          | string   | Status of request                        |
| data            | object   | Object containing information about book |
| id              | string   | unique identifier for book               |
| name            | string   | Name of book                             |
| isbn            | string   | ISBN of book                             |
| authors         | Array    | Author(s) of book.                       |
| number_of_pages | integer  | Number of book pages                     |
| publisher       | string   | Book publisher                           |
| country         | string   | Country of book.                         |
| release_date    | string   | Release Date of book.                    |

-   **Request Successful but Empty Response** - Simply means there's no book information with given ID.

```
Status 200 OK
{
  "status_code": 200,
  "status": "success",
  "data": []
}
```

### Add New Book information

---

Creates a new book information in the application.

-   **URL and Method**
    `POST http://127.0.0.1:8000/api/v1/books`

-   **Request**

```
POST http://localhost:3000/api/v1/post HTTP/1.1
Content-Type: application/json

{
  'name': "Laravel",
  'isbn': "123-4564",
  'authors': "Taylor",
  'country': "United States",
  'number_of_pages': "1000",
  'publisher': "Sakarious",
  'release_date': "2012-01-01",
}
```

With the following fields:

| Parameter       | Required? | Description              |
| --------------- | --------- | ------------------------ |
| name            | required  | Name of Book.            |
| isbn            | required  | ISBN of Book             |
| authors         | required  | Book Authors.            |
| country         | required  | Country of Book.         |
| number_of_pages | required  | Number of pages of book. |
| publisher       | required  | Book Publisher.          |
| release_date    | required  | Date of release of book. |

-   **Success Response**

```
Status 201 Created
Content-Type: application/json; charset=utf-8

{
  "status_code": 201,
  "status": "success",
  "data": {
    "book": {
      "name": "Laravel",
      "isbn": "123-4564",
      "authors": [
        "Taylor"
      ],
      "number_of_pages": "100",
      "publisher": "Sakarious",
      "country": "Uniited States",
      "release_date": "2012-01-01"
    }
  }
}
```

-   **If validation fails**

```
Status 200
Content-Type: application/json; charset=utf-8

{
  "message": "Validation Failed",
  "errors": {
    "name": [
      "The name field is required."
    ],
    "isbn": [
      "The isbn field is required."
    ],
    "authors": [
      "The authors field is required."
    ],
    "country": [
      "The country field is required."
    ],
    "number_of_pages": [
      "The number of pages field is required."
    ],
    "publisher": [
      "The publisher field is required."
    ],
    "release_date": [
      "The release date field is required."
    ]
  }
}
```

### Update Book information

---

Updates book information in the application.

-   **URL and Method**
    `PATCH http://127.0.0.1:8000/api/v1/books/1`

-   **URL Params**
    `/v1/books/{id}`

    **Required:**

`Book ID {id} =[integer]`

-   **Request**

```
POST http://localhost:3000/api/v1/post HTTP/1.1
Content-Type: application/json

{
  'name': "Ja Rule",
  'isbn': "123-4564",
  'authors': "Taylor",
  'country': "United States",
  'number_of_pages': "1000",
  'publisher': "Sakarious",
  'release_date': "2012-01-01",
}
```

With the following fields:

| Parameter       | Required? | Description              |
| --------------- | --------- | ------------------------ |
| name            | required  | Name of Book.            |
| isbn            | required  | ISBN of Book             |
| authors         | required  | Book Authors.            |
| country         | required  | Country of Book.         |
| number_of_pages | required  | Number of pages of book. |
| publisher       | required  | Book Publisher.          |
| release_date    | required  | Date of release of book. |

-   **Success Response**

```
Status 200 Created
Content-Type: application/json; charset=utf-8

{
  "status_code": 200,
  "status": "success",
  "message":  "The book Ja Rule was updated successfully",
  "data": {
    "book": {
	  "id": 1
      "name": "Ja Rule",
      "isbn": "123-4564",
      "authors": [
        "Taylor"
      ],
      "number_of_pages": "100",
      "publisher": "Sakarious",
      "country": "Uniited States",
      "release_date": "2012-01-01"
    }
  }
}
```

-   **If validation fails**

```
Status 200
Content-Type: application/json; charset=utf-8

{
  "message": "Validation Failed",
  "errors": {
    "name": [
      "The name field is required."
    ],
    "isbn": [
      "The isbn field is required."
    ],
    "authors": [
      "The authors field is required."
    ],
    "country": [
      "The country field is required."
    ],
    "number_of_pages": [
      "The number of pages field is required."
    ],
    "publisher": [
      "The publisher field is required."
    ],
    "release_date": [
      "The release date field is required."
    ]
  }
}
```

-   **If book ID is not found**

```
Status 200 OK
{
  "status_code": 200,
  "status": "success",
  "data": []
}
```

### Delete Book information

---

Deletes book information in the application.

-   **URL and Method**
    `DELETE http://127.0.0.1:8000/api/v1/books/1`
    **OR**
    `POST http://127.0.0.1:8000/api/v1/books/1/delete`

-   **URL Params**
    `/v1/books/{id}`
    `/v1/books/{id}/delete`

    **Required:**

`Book ID {id} =[integer]`

-   **Success Response**

```
Status 200
Content-Type: application/json; charset=utf-8

{
  "status_code": 204,
  "status": "success",
  "message":  "The book Ja Rule was deleted successfully",
  "data": []
}
```

-   **If book ID is not found**

```
Status 200 OK
{
  "status_code": 200,
  "status": "success",
  "data": []
}
```
