dockerComposeDirectory = "./"

init: build \
	down \
	init-directories \
	up \
	composer-install \
	load-migrations \
	load-fixtures

restart: down up

build:
	@cd $(dockerComposeDirectory) && \
	docker-compose build

up:
	@cd $(dockerComposeDirectory) && \
	docker-compose up -d

down:
	@cd $(dockerComposeDirectory) && \
	docker-compose down

ps:
	@cd $(dockerComposeDirectory) && \
	docker-compose ps

bash:
	@cd $(dockerComposeDirectory) && \
	docker-compose run --rm php-cli bash

composer-install:
	@cd $(dockerComposeDirectory) && \
	docker-compose run --rm php-cli composer install

init-directories:
	mkdir -p logs && sudo chmod 777 ./logs && \
	mkdir -p logs/nginx && touch logs/nginx/error.log

load-migrations:
	@cd $(dockerComposeDirectory) && \
    	docker-compose run --rm php-cli bin/console d:mig:mig -q

load-fixtures:
	@cd $(dockerComposeDirectory) && \
    	docker-compose run --rm php-cli bin/console doctrine:fixtures:load -q
