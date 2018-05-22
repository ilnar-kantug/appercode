up-docker:
	docker-compose up -d

down-docker:
	docker-compose down

build-docker:
	docker-compose up --build -d

test:
	docker-compose exec php-cli vendor/bin/phpunit

install-assets:
	docker-compose exec node yarn install

rebuild-assets:
	docker-compose exec node npm rebuild node-sass --force

dev-assets:
	docker-compose exec node yarn run dev

watch-assets:
	docker-compose exec node yarn run watch

perm:
	sudo chmod -R 777 vendor -R
	sudo chmod -R 777 storage -R
	sudo chmod -R 777 bootstrap/cache -R
	if [ -d "node_modules" ]; then sudo chmod -R 777 -R; fi
	if [ -d "public/build" ]; then sudo chmod -R 777 -R; fi