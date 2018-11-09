# tracker-backend

## Install

- `git clone git@bitbucket.org:seniorcote/tracker-backend.git && cd tracker-backend`
- `cp .env.dist .env`
- `cp backend/.env.dist backend/.env`
- `cp pre-commit.dist .git/hooks/pre-commit && chmod +x .git/hooks/pre-commit`
- `docker-compose up -d --build`
- `docker-compose exec php composer install`
- `docker-compose exec php php bin/console d:m:m`
- `docker-compose exec php php bin/console h:f:l`

After fixtures rolling, the user will be available with the following data: `user@mail.ru` | `passw0rd`.
