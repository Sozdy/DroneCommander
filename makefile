PATH := $(PATH):$(shell pwd)/bin
RESET=\033[0m
GREEN=\033[92m
YELLOW=\033[1;33m

local-up: ## Build and run project locally using docker-compose
	@docker-compose -f docker-compose.local.yml up -d --build --remove-orphans --force-recreate
	@make check-env
	@make dependencies
	@make token
	@make clear
	@make migrate
	@echo "${GREEN}Local-up complete.${RESET}"

dependencies: ## @PRIVATE Install composer dependencies
	@echo "${YELLOW}Installing dependencies...${RESET}"
	@docker exec -it dronecommander-drone-commander-php-fpm-1 composer install

token: ## @PRIVATE Create private keys
	@echo "${YELLOW}Creating private keys...${RESET}"
	@if grep -q '^APP_KEY=$$' .env; then docker exec dronecommander-drone-commander-php-fpm-1 php artisan key:generate; fi

clear: ## @PRIVATE Reset cache files
	@echo "${YELLOW}Resetting cache files...${RESET}"
	@docker exec -it dronecommander-drone-commander-php-fpm-1 php artisan config:clear
	@docker exec -it dronecommander-drone-commander-php-fpm-1 php artisan route:clear
	@docker exec -it dronecommander-drone-commander-php-fpm-1 php artisan view:clear
	@docker exec -it dronecommander-drone-commander-php-fpm-1 php artisan cache:clear

migrate: ## @PRIVATE Migrate database
	@echo "${YELLOW}Migrate database...${RESET}"
	@docker exec -it dronecommander-drone-commander-php-fpm-1 php artisan migrate

check-env: ## @PRIVATE Check and copy .env file if not exists
	@echo "${YELLOW}Check .env...${RESET}"
	@if [ ! -f .env ]; then \
        echo "Copying .env.example to .env"; \
        cp .env.example .env; \
    fi

local-down: ## Stop and remove running project containers
	@docker-compose -f docker-compose.local.yml down

test:	## Run tests
	@echo "${YELLOW}Running tests...${RESET}"
	@docker exec -it dronecommander-drone-commander-php-fpm-1 ./vendor/bin/pest

help: ## Show help
	@echo "Public commands:"
	@echo ""
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | grep -v '# @PRIVATE' | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[92m%-25s\033[36m %s\n", $$1, $$2}'
	@echo ""
