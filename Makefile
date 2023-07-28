include .env

.DEFAULT_GOAL := help

help: ## This help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

up: ## Запуск докер проекта
	docker-compose up -d

down: ## Выключение докер проекта
	docker-compose down --remove-orphans

stop: ## Остановка докер проекта
	docker-compose stop

build: ## Собрать докер проекта
	docker-compose build

build-no-cache: ## Собрать проект докера в режиме без кеша
	docker-compose build --no-cache

ps: ## Вывод списка контейнеров докера
	docker-compose ps

initDump: ## Восстановить начальный дамп
	 gunzip -c ./dump/init_dump.sql.gz | docker-compose exec -T db mysql -u root --password=$(MYSQL_ROOT_PASSWORD) $(MYSQL_DATABASE)

initBitrixCore: ## Распаковать ядро битрикса в проект
	 tar -xvf ./bitrixCore/bitrix.tar -C ./www/

composerInstall: ## Подтягивание зависимостей композер
	docker-compose exec php bash -c "composer install --ignore-platform-reqs --working-dir=/var/www/bitrix/local/"

migrateInstall: ## Подтягивание зависимостей композер
	docker-compose exec php bash -c "php /var/www/bitrix/local/migrator install"

migrateUp: ## Подтягивание зависимостей композер
	docker-compose exec php bash -c "cd /var/www/bitrix/local/ && php /var/www/bitrix/local/migrator migrate"