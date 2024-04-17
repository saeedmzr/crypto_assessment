#!/usr/bin/env make

CONTAINER=app

all: update restart logs


build: .env
	@echo "===== Docker build ====="
	docker-compose build --no-cache

up: .env
	@echo "===== Docker up ====="
	docker-compose  up

down: .env
	@echo "===== Docker down ====="
	docker-compose down --remove-orphans

start: .env
	@echo "===== Docker start ====="
	docker-compose up -d

stop: .env
	@echo "===== Docker stop ====="
	docker-compose stop

restart: .env
	@echo "===== Docker restart ====="
	make down
	make start

remove: stop
	@echo "===== Remove containers ====="
	docker-compose rm -f

logs: .env
	@echo "===== Docker logs ====="
	docker-compose logs -f

run: .env
	@echo "===== Docker run container ====="
	docker-compose run --rm ${CONTAINER} bash

exec: .env
	@echo "===== Docker exec container ====="
	docker-compose run --rm ${CONTAINER} bash

stats:
	@echo "===== Docker stats ====="
	docker stats

ps:
	@echo "===== Print state of containers ====="
	docker-compose ps

update:
	@echo "===== Git Update ====="
	git pull

run-migrate-with-seed:
	@echo "===== Run Migrations with seeders ====="
	docker-compose exec  ${CONTAINER} php artisan migrate:fresh --seed


run-migrate:
	@echo "===== Run Migrations ====="
	docker-compose exec -it ${CONTAINER}  php artisan migrate:fresh

run-test:
	@echo "===== Run Migrations ====="
	docker-compose exec -it ${CONTAINER}  php artisan test

docs:
	@echo "===== Run Documentation ====="
	docker-compose exec -it ${CONTAINER}  php artisan l5-swagger:generate
