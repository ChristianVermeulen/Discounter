ENV = dev

help: ## Show this help message.
	@echo 'usage: make [target] ...'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

pristine: install resetdb import ## Go back to clean install state

install: ## imports data
	composer install -o

resetdb: ## resets database to pristine state
	bin/console d:d:d --force
	bin/console d:d:c
	bin/console d:m:m -q

import: ## imports data
	bin/console d:i:customer
	bin/console d:i:category
	bin/console d:i:product

run: ## See discounts on order
	bin/console discounter:discount order1
	bin/console discounter:discount order2
	bin/console discounter:discount order3

.PHONY: pristine install resetdb import run
