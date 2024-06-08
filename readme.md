# How to start the application:
- Start the containers

`docker compose up -d`

- Install the application dependencies

`docker compose exec php composer install`

- Run the migrations

`docker compose exec php php bin/console doctrine:migrations:migrate`

- Check [Postman collection](https://github.com/tsydenov/symfony-crud/blob/master/novex.postman_collection.json) for API requests examples
- Read [task description](https://github.com/tsydenov/symfony-crud/blob/master/to-do)

## API
### Create user
`POST /users/new`

### Show user by id
`GET /users/{id}`

### Show all users
`GET /users`

### Update user by id
`PATCH /users/{id}`

### Delete user by id
`DELETE /users/{id}`
