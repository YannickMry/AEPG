.PHONY: install
install:
	composer install
	npm install

.PHONY: vendor
analyze:
	npm audit
	composer valid
	php bin/console doctrine:schema:validate
	php vendor/bin/phpcs

.PHONY: tests
tests:
	php bin/phpunit --coverage-html ./var/web/html-coverage --coverage-clover ./var/web/clover-coverage/clover.xml

fixtures-test:
	php bin/console doctrine:fixtures:load -n --env=test

fixtures-dev:
	php bin/console doctrine:fixtures:load -n --env=dev

database-test:
	php bin/console doctrine:database:drop --if-exists --force --env=test
	php bin/console doctrine:database:create --env=test
	php bin/console doctrine:schema:update --force --env=test

database-dev:
	php bin/console doctrine:database:drop --if-exists --force --env=dev
	php bin/console doctrine:database:create --env=dev
	php bin/console doctrine:schema:update --force --env=dev

prepare-test:
	make database-test
	make fixtures-test

prepare-dev:
	make database-dev
	make fixtures-dev

prepare-env:
	cp .env.dist .env.dev.local
	cp .env.dist .env.test.local