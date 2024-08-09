<h1 align='center'>
  Welcome! ChallengerAPI Instructions
</h1>

<p align='center'>
  Project developed as part of the selection process for the position of Backend Developer,
with a focus on showing knowledge of the required technologies.
</p>

<div align="center">

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![Postgres](https://img.shields.io/badge/postgres-%23316192.svg?style=for-the-badge&logo=postgresql&logoColor=white)
![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)
![Swagger](https://img.shields.io/badge/-Swagger-%23Clojure?style=for-the-badge&logo=swagger&logoColor=white)
![Postman](https://img.shields.io/badge/Postman-FF6C37?style=for-the-badge&logo=postman&logoColor=white)

</div>

### Requirements

#### To run challengerAPI on your machine, it must meet the following requirements:


- [PHP 8.3](https://www.php.net/downloads)
- [Composer 2.7](https://getcomposer.org/download/)
- [Docker](https://www.docker.com/)
- API Client (ex: [Postman](https://www.postman.com/downloads/) or [Insomnia](https://insomnia.rest/download))
- [Make](https://www.gnu.org/software/make/) (optional)

### How to install

> **Obs:** For faster deployment, the following commands are being used with [make](https://www.gnu.org/software/make/), if you don't want to install them, visit the makefile in the root of the project to check the commands needed to make the api work.:

- First, clone this repository on your machine:

```
git clone https://github.com/CLucasrodrigues22/challengerAPI.git
```

- Open a new terminal windows at the root of the project and create an .env based on the .env.example:

```
cp .env.example .env
```

- Copy and paste the following environment variables into the .env of your environment:

```
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=challengeAPI
DB_USERNAME=postgres
DB_PASSWORD=password
```

#### Setting up containers with make
- Run the following command to upload the container, install dependencies and run migrations:

```
make
```

#### Setting up containers manually
- Configure the containers, use the command:

```
docker-compose up -d
```

- Access the api container:

```
docker exec -it api bash
```

- To install dependencies, run migrations, seeders, and generate api-docs for swagger, use the following commands:

```
composer update
```
```
php artisan migrate
```
```
php artisan key:generate
```
```
php artisan db:seed --class=LocationSeeder
```
```
php artisan l5-swagger:generate
```

### API endpoints

> **Obs:** For a better documentation of the api, [swagger](https://github.com/DarkaOnLine/L5-Swagger) was used, use the route on the browser: [link](http://localhost/api/documentation) to view more details.

**Endpoint List Locations:** `GET /api/v1/locations` **Obs:** Returns a list of all locations and filter result with 'name' parameter in JSON. <br/>
**Endpoint List Only Location:** `GET /api/v1/locations/{id}` **Obs:** Return a location by id in JSON. <br/>
**Endpoint Create New Location:** `POST /api/v1/locations` **Obs:** Create a new location. <br/>
**Endpoint Update Location:** `PUT /api/v1/locations/{id}` **Obs:** Update a location by id. <br/>
**Endpoint Delete Location:** `DELETE /api/v1/locations/{id}` **Obs:** Delete a location by id. <br/>


### Project structure

- `./app/DTO`: Files to transfer data between layers of an application in an organized and efficient manner following design patterns.
- `./app/Http/Controllers`: Files to handle incoming HTTP requests, send them to the correct service and return the appropriate responses.
- `./app/Http/Requests`: Files that are responsible for validating each input received by the request, for the post and put methods, with different rules for each.
- `./app/Models`: Files that serve as an abstraction layer for interacting with these tables.
- `./app/Providers`: Files with the initialization of the interfaces used by the localization methods.
- `./app/Repositories`: Files with the interfaces and technique used to abstract the data access logic, separating it from the business logic, with the methods for each resource, one of which can be defined for each ORM, so that it is not dependent only on eloquent.
- `./app/Services`: Files with classes that encapsulate specific functionality for each method, communicating between controller and repository.
- `./Docker`: Initialization files needed for docker containers.
- `./storage/api-docs`: Json file with settings for the swagger.
- `./storage/logs`: Files with the exceptions for each method in the repository, used for evaluations.
- `./tests/App/`: Unit tests for methods.



