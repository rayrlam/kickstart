.PHONY: config-clear cache-clear view-clear test clear-log del-log clear

CONTAINER_NAME=php

config-clear:
	@echo "Clearing configuration cache..."
	docker exec -it $(CONTAINER_NAME) php artisan config:clear

cache-clear:
	@echo "Clearing application cache..."
	docker exec -it $(CONTAINER_NAME) php artisan cache:clear

view-clear:
	@echo "Clearing compiled views..."
	docker exec -it $(CONTAINER_NAME) php artisan view:clear

test:
	@echo "Running tests..."
	docker exec -it $(CONTAINER_NAME) php artisan test

clear-log:
	@echo "Clearing content of daily Laravel log files..."
	docker exec -it $(CONTAINER_NAME) sh -c 'truncate -s 0 storage/logs/laravel-*.log'

del-log:
	@echo "Deleting daily Laravel log files..."
	docker exec -it $(CONTAINER_NAME) sh -c 'rm -f storage/logs/laravel-*.log'

clear: config-clear cache-clear view-clear