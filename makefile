PATH := $(PATH):$(shell pwd)/bin
RESET=\033[0m
GREEN=\033[92m
YELLOW=\033[1;33m


local-up:
	@docker-compose -f docker-compose.local.yml up -d --build --remove-orphans --force-recreate
	@make check-env
	@make dependencies
	@make token
	@make clear
	@make migrate
	@echo "${GREEN}Local-up complete.${RESET}"

dependencies:
	@echo "${YELLOW}Installing dependencies...${RESET}"
	@docker exec -it dronecommander-drone-commander-php-fpm-1 composer install

token:
	@echo "${YELLOW}Creating private keys...${RESET}"
	@if grep -q '^APP_KEY=$$' .env; then docker exec dronecommander-drone-commander-php-fpm-1 php artisan key:generate; fi

clear:
	@echo "${YELLOW}Resetting cache files...${RESET}"
	@docker exec -it dronecommander-drone-commander-php-fpm-1 php artisan config:clear
	@docker exec -it dronecommander-drone-commander-php-fpm-1 php artisan route:clear
	@docker exec -it dronecommander-drone-commander-php-fpm-1 php artisan view:clear
	@docker exec -it dronecommander-drone-commander-php-fpm-1 php artisan cache:clear

migrate:
	@echo "${YELLOW}Migrate database...${RESET}"
	@docker exec -it dronecommander-drone-commander-php-fpm-1 php artisan migrate

check-env:
	@echo "${YELLOW}Check .env...${RESET}"
	@if [ ! -f .env ]; then \
        echo "Copying .env.example to .env"; \
        cp .env.example .env; \
    fi

local-down:
	@docker-compose -f docker-compose.local.yml down

help:
	@echo "$(YELLOW)Available targets:$(RESET)"
	@echo "$(GREEN)local-up$(RESET) - Build and run project locally using docker-compose"
	@echo "$(GREEN)dependencies$(RESET) - Install project dependencies using Composer"
	@echo "$(GREEN)token$(RESET) - Create private keys"
	@echo "$(GREEN)clear$(RESET) - Reset cache files"
	@echo "$(GREEN)migrate$(RESET) - Migrate database"
	@echo "$(GREEN)check-env$(RESET) - Check and copy .env file if not exists"
	@echo "$(GREEN)local-down$(RESET) - Stop and remove running project containers"

test:
	@echo "${YELLOW}Running tests...${RESET}"
	@docker exec -it dronecommander-drone-commander-php-fpm-1 ./vendor/bin/pest
