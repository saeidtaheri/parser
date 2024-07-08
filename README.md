# Simple Parser

## Requirements
- Docker
- Docker-Compose

## Services
- PHP: 8.3
- Nginx: latest
- MySql: latest

## Installation
- Copy `env.example` to `.env` file: `cp .env.example .env`
- Set the database configs in `.env` file
- Run `docker-compose up --build` to create the project
- Go through the php container: `docker-compose exec -u parser php bash`
- Install the project dependencies: `composer install`

## Execution
- After configuring the database, you can run `php index.php`

## Testing
Run the tests by: `./vendor/bin/phpunit --testdox`