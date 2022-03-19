##-
##-	Usage | make [option]
##-
help:		##- Show this help.
	@sed -e '/#\{2\}-/!d; s/\\$$//; s/:[^#\t]*/:/; s/#\{2\}- *//' $(MAKEFILE_LIST)

##-

CONTAINER = basic-docker
PHPQA = docker run --init -it --user "$(shell id -u):$(shell id -g)" --rm -v "$(CURDIR)/:/var/www" -v "$(CURDIR)/tmp-phpqa:/tmp" -w /var/www jakzal/phpqa:php8.0-alpine

##-		-- Docker Commands --
##-

start: 		##- Start Docker
	@ docker-compose up -d --build

stop: 		##- Stop Docker
	@ docker-compose down

##-
##-		-- QA Task Runners --
##-
test:		##- Run Tests with PHP Unit
	@ docker exec -it $(CONTAINER) php -d xdebug.mode=coverage vendor/bin/phpunit -c phpunit.xml.dist --debug -vvv

stan:		##- Verify Code with PHPStan
	@ mkdir -p $(CURDIR)/tmp-phpqa/ && chmod 775 $(CURDIR)/tmp-phpqa/
	@ $(PHPQA) phpstan

format:		##- Verify format code
	@ mkdir -p $(CURDIR)/tmp-phpqa/ && chmod 775 $(CURDIR)/tmp-phpqa/
	@ $(PHPQA) ecs --fix --clear-cache

##-
##-