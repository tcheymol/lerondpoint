.PHONY        :

SYMFONY       = symfony
CONSOLE       = $(SYMFONY) console
BIN     	  = ./vendor/bin
RECTOR        = $(BIN)/rector
PHPSTAN       = $(BIN)/phpstan
PHP_CS_FIXER  = $(BIN)/php-cs-fixer
DEPLOYER      = $(BIN)/dep
PHP_UNIT      = $(BIN)/phpunit

cs: rector fixer stan

stan:
	@$(PHPSTAN) analyse -c phpstan.dist.neon

rector:
	@$(RECTOR) process --clear-cache

fixer:
	php ./vendor/bin/php-cs-fixer fix src --allow-risky=yes --using-cache=no --allow-unsupported-php-version=yes

deploy:
	@$(DEPLOYER) deploy

test:
	@$(PHP_UNIT)
