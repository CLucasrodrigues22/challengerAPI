.PHONY: default

# variables
APP_NAME=challengeAPI

# Tasks
default: run-docker-up

run-docker-up:
	@docker-compose up -d && \
	docker-compose exec -T api bash -c "composer update && \
	php artisan migrate && \
	php artisan key:generate && \
	php artisan db:seed --class=LocationSeeder && \
	php artisan l5-swagger:generate && \
	php artisan migrate --env=testing && \
	php artisan test"

test:
	@php artisan test


