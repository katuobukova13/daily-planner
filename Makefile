up:
	docker-compose up -d

init:
	cp .env.example .env
	cd ./site && cp .env.example .env
	docker exec -it app-php composer install
	cd ./site && npm install

migrate:
	docker exec -it app-php php bin/console doctrine:migrations:migrate
	docker exec -it app-php php bin/console doctrine:fixtures:load

test:
	docker exec -it app-php ./vendor/bin/phpunit --testdox

down:
	docker-compose down

