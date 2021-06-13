Candidate Wojciech Śliwka

Docker compose
--------
```
docker-compose up --build -d --force-recreate
```
The project will be available at http://localhost/

### Prepare project
first run the project you need to run the command in the container bitpanda_php
```
docker exec -it bitpanda_php php artisan db:seed
```

### Run tests
```
docker exec -it bitpanda_php vendor/bin/phpunit tests
```

Tasks
--------
## PHP Technical test

### 1.

Create a new Laravel project using composer

Attached you will find a DB dump. Create a DB connection in laravel using the .env file.

Seed the DB based on the dump

In the resulted DB you will have these 3 tables: `users`, `countries` and `user_details`.
```
* users: id, email, active
* countries: id, name, iso2, iso3 
* user_details: id, user_id, citizenship_country_id, first_name, last_name, phone_number
```

* 1. Create a call which will return all the users which are `active` (users table) and have an Austrian citizenship.
* 2. Create a call which will allow you to edit user details just if the user details are there already.
* 3. Create a call which will allow you to delete a user just if no user details exist yet.
* 4. Write a feature test for 3. with valid and invalid data

Tips:
- you can use Eloquent to simplify (eg: model binding)

## PHP Technical test

### 2.

Create a new Laravel project using composer

Attached you will find a DB dump and a .csv file.

Create a DB connection in laravel using the .env file.

Seed the DB based on the dump

In the resulted DB you will have these 1 table: `transactions`.
```
* transactions: id, code, amount, user_id, created_at, updated_at
```

You have two sources. One DB and one is the .csv file

Write two services(classes) that implement an interface which will allow you to retrieve the data.

1. Create an endpoint which will return the transactions in a json with an extra parameter which will specify the source

endpoints:
* .../transactions?source=db
* .../transactions?source=csv

Some ideas:
- you can create a factory to determine the class handler
- you can also validate the source value and if the value is unknown throw an exception (eg: /transactions?source=html)