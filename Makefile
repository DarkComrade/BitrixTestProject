include .env

.DEFAULT_GOAL := help

help: ## This help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

up: ## Up Docker-project
	docker-compose up -d

down: ## Down Docker-project
	docker-compose down --remove-orphans

stop: ## Stop Docker-project
	docker-compose stop

build: ## Build Docker-project
	docker-compose build

build-no-cache: ## Build Docker-project
	docker-compose build --no-cache

ps: ## Build Docker-project
	docker-compose ps

initDump: ## Восстановить начальный дамп
	 gunzip -c ./dump/init_dump.sql.gz | docker-compose exec -T db mysql -u root --password=$(MYSQL_ROOT_PASSWORD) $(MYSQL_DATABASE)

initBitrixCore: ## распаковать ядро битрикса в проект
	 tar -xvf ./bitrixCore/bitrix.tar -C ./www/
