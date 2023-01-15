# Simple Parser

## Requirements
- Docker
- Docker-Compose

## Services
- PHP: 8.1
- Nginx: latest
- MySql: latest

## Installation
- copy `env.example` to `.env` file in terminal: `cp .env.example .env`
- set the database configs in `.env` file
- run `docker-compose up --build` to create the project
- go through the php container: `docker-compose exec -u parser php bash`
- install the project dependencies: `composer install`
- now you can run the project: `php index.php`

## Testing
Run the tests by: `./vendor/bin/phpunit --testdox`