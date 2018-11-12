# tracker

## Install

### Common

- `git clone git@bitbucket.org:seniorcote/tracker.git && cd tracker`
- `cp .env.dist .env`
- `cp backend/.env.dist backend/.env`
- `docker-compose up -d --build`
- `docker-compose exec php composer install`
- `docker-compose exec php php bin/console d:m:m` roll migrations
- `docker-compose exec php php bin/console d:s:u --force` create a refresh tokens table
- `docker-compose exec php php bin/console h:f:l` roll fixtures

### Generate the SSH keys

Pass phrase can be taken from `backend/.env` or set your own pass phrase, do not forget to update .env file.

- `mkdir backend/config/jwt`
- `openssl genrsa -out backend/config/jwt/private.pem -aes256 4096`
- `openssl rsa -pubout -in backend/config/jwt/private.pem -out backend/config/jwt/public.pem`

### Optional

- `cp pre-commit.dist .git/hooks/pre-commit && chmod +x .git/hooks/pre-commit` set php-cs-fixer in pre-commit hook