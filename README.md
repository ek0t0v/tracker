# tracker

## Installation and run

#### Common

- `git clone git@bitbucket.org:seniorcote/tracker.git && cd tracker`
- `cp .env.dist .env`
- `cp backend/.env.dist backend/.env`
- `docker-compose up -d --build`
- `docker-compose run composer install`
- `docker-compose exec php php bin/console d:m:m` roll migrations
- `docker-compose exec php php bin/console h:f:l` roll fixtures
- `docker-compose exec postgres pg_dump -U symfony symfony > ./backend/tests/_data/dump.sql` create database dump for tests

#### Generate the SSH keys

Pass phrase can be taken from `backend/.env` or set your own pass phrase, do not forget to update .env file.

- `mkdir backend/config/jwt`
- `openssl genrsa -out backend/config/jwt/private.pem -aes256 4096`
- `openssl rsa -pubout -in backend/config/jwt/private.pem -out backend/config/jwt/public.pem`

#### Frontend

- `docker-compose run node npm install` install dependencies
- `docker-compose run --service-ports node npm run dev` run development server

#### Optional

- `cp pre-commit.dist .git/hooks/pre-commit && chmod +x .git/hooks/pre-commit` set php-cs-fixer in pre-commit hook

## Commands

- `docker-compose exec php php vendor/bin/codecept run` run tests
- `docker-compose exec php php vendor/bin/phpstan analyze -l 4 src` run PHPStan

## Notes