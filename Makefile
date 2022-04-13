.DEFAULT_GOAL := help
help:
	@printf "\n\n"
	@printf "\e[1;31m	Usage: make [option]\e[0m\n\n";

	@awk '{ \
			if ($$0 ~ /^.PHONY:/) { \
				helpCommand = substr($$0, index($$0, ":") + 2); \
				if (helpMessage) { \
					printf "\033[32m%-30s\033[0m %s\n", \
						helpCommand, helpMessage; \
					helpMessage = ""; \
				} \
			} else if ($$0 ~ /^##/) { \
				if (helpMessage) { \
					helpMessage = helpMessage"\n                               "substr($$0, 3); \
				} else { \
					helpMessage = substr($$0, 3); \
				} \
			} else { \
				if (helpMessage) { \
					print "\n"helpMessage"\n" \
				} \
				helpMessage = ""; \
			} \
		}' \
		$(MAKEFILE_LIST)
	@printf "\n\n"

#----------------------------------------------------------------------------#
#-									VAR										-#
#----------------------------------------------------------------------------#
PHP = php
PHPUNIT = $(PHP) vendor/bin/phpunit
PHPUNITFAILURE= $(PHP) vendor/bin/phpunit --stop-on-failure

## Fixing php src file.
.PHONY: fix
fix:
	tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src

.PHONY: test
test:
ifdef filter
	$(PHPUNIT) --filter $(filter)
else
	$(PHPUNIT)
endif

## Test with stop on first failure. To test one file or one method: "make test-failure filter=[fileName || methodName]". [fileName] without .php
.PHONY: test-failure
test-failure:
ifdef filter
	$(PHPUNITFAILURE) --filter $(filter)
else
	$(PHPUNITFAILURE)
endif

## Load fixtures
.PHONY: database-fixtures
database-fixtures:
	$(PHP) bin/console hautelook:fixtures:load --no-interaction --env=dev


## Load database test
.PHONY: database-test
database-test:
	$(PHP) bin/console doctrine:database:drop --force --if-exists --env=test
	$(PHP) bin/console doctrine:database:create --env=test
	$(PHP) bin/console doctrine:schema:update --force --env=test
