.PHONY: help up down restart build logs ps migrate rollback seed fresh test cache-clear

help: ## Show this help menu
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

up: ## Start the application
	docker compose -f docker-compose.prod.yml up -d

down: ## Stop the application
	docker compose -f docker-compose.prod.yml down

stop: ## Stop the application and remove volumes
	docker compose -f docker-compose.prod.yml down -v

restart: down up ## Restart the application

build: ## Rebuild the application
	docker compose -f docker-compose.prod.yml build --no-cache
	docker compose -f docker-compose.prod.yml up -d

logs: ## View container logs
	docker compose -f docker-compose.prod.yml logs -f

logs-db: ## View database logs
	docker compose -f docker-compose.prod.yml logs -f db

logs-app: ## View application logs
	docker compose -f docker-compose.prod.yml logs -f app

ps: ## List containers
	docker compose -f docker-compose.prod.yml ps

migrate: ## Run database migrations
	docker compose -f docker-compose.prod.yml exec app php artisan migrate

rollback: ## Rollback database migrations
	docker compose -f docker-compose.prod.yml exec app php artisan migrate:rollback

seed: ## Seed the database
	docker compose -f docker-compose.prod.yml exec app php artisan db:seed

fresh: ## Refresh database with seeds
	docker compose -f docker-compose.prod.yml exec app php artisan migrate:fresh --seed

test: ## Run tests
	docker compose -f docker-compose.prod.yml exec app php artisan test

cache-clear: ## Clear application cache
	docker compose -f docker-compose.prod.yml exec app php artisan cache:clear
	docker compose -f docker-compose.prod.yml exec app php artisan config:clear
	docker compose -f docker-compose.prod.yml exec app php artisan route:clear
	docker compose -f docker-compose.prod.yml exec app php artisan view:clear

shell: ## Access the container shell
	docker compose -f docker-compose.prod.yml exec app bash

db-shell: ## Access the database shell
	docker compose -f docker-compose.prod.yml exec db mysql -u root -p

redis-shell: ## Access the Redis shell
	docker compose -f docker-compose.prod.yml exec redis redis-cli

clean: stop ## Clean up all containers and volumes
	docker compose -f docker-compose.prod.yml rm -f
	docker volume prune -f

restart-db: ## Restart only the database container
	docker compose -f docker-compose.prod.yml restart db

restart-app: ## Restart only the application container
	docker compose -f docker-compose.prod.yml restart app

health: ## Check container health
	@echo "Checking container health..."
	@docker compose -f docker-compose.prod.yml ps
	@echo "\nContainer Logs:"
	@docker compose -f docker-compose.prod.yml logs --tail=20 
