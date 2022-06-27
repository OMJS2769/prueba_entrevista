## Installation

This project was created with laravel 8, it requires composer.

- Run `$ composer install

##Migration

-Run `$ php artisan migrate

##Seeder

Run php artisan db:seed --class=DatabaseSeeder to create test records

##Login (GET)

Call http://localhost/prueba_entrevista/public/api/login with the next parmeters

- email
- password

Response 

| Item      | Value |
| --------- | -----:|
| status  | success |
| message     |   success login |
| user_id      |    1 |
| name  | Brandon Smith |
| email     |   brandon@mail.com |
| api_token      |    8fb0a4049c19621bfd0eab9f639628398a2ff12d |
| last_session      |    2022-06-27T19:24:29.234393Z |

##Get record (GET)

Call http://localhost/prueba_entrevista/public/api/index_customer with the next parmeters

- api_token

Response

| Item      | Value |
| --------- | -----:|
| id  | 3 |
| dni  | L9O1EHE0Z8K1JB6M |
| id_reg  | 1 |
| id_com  | 1 |
| email  | payton27@johnston.info |
| name  | Kraig Stehr |
| last_name  | Goodwin |
| address  | 9529 Stroman Lodge Suite 691\nLake Catalina, WA 9704 |
| date_reg  | 2022-06-25 23:20:24 |
| created_at  | 2022-06-25T23:20:24.000000Z |
| updated_at  | 2022-06-25T23:20:24.000000Z |
| region  | JSON |
| commune  | JSON |


##Store record (POST)

Call http://localhost/prueba_entrevista/public/api/store_customer with the next parmeters

- api_token
- dni
- id_reg
- id_com
- email
- name
- last_name
- address

Response

| Item      | Value |
| --------- | -----:|
| status  | success |
| message  | Customer stored |

##Destroy record (DELETE)

Call http://localhost/prueba_entrevista/public/api/destroy_customer with the next parmeters

- api_token
- customer_id

Response

| Item      | Value |
| --------- | -----:|
| status  | success |
| message  | Customer destroyed |
