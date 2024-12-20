.PHONY        :

SYMFONY       = symfony
CONSOLE       = $(SYMFONY) console
BIN     	  = ./vendor/bin
RECTOR        = $(BIN)/rector
PHPSTAN       = $(BIN)/phpstan
PHP_CS_FIXER  = $(BIN)/php-cs-fixer
DEPLOYER      = $(BIN)/dep

cs: rector fixer stan

stan:
	@$(PHPSTAN) analyse -c phpstan.dist.neon

rector:
	@$(RECTOR) process --clear-cache

fixer:
	PHP_CS_FIXER_IGNORE_ENV=true php ./vendor/bin/php-cs-fixer fix src --allow-risky=yes --using-cache=no

deploy:
	@$(DEPLOYER) deploy
