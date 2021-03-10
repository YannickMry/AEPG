.PHONY: vendor
analyze:
	npm audit
	composer valid
	php bin/console doctrine:schema:valid --skip-sync
	php bin/phpcs
	php vendor/bin/phpstan analyse -c phpstan.neon src --level 7 --no-progress

.PHONY: vendor
analyze-windows:
	npm audit
	composer valid
	php bin/console doctrine:schema:valid --skip-sync
	php bin/phpcs
	vendor\bin\phpstan.bat analyse -c phpstan.neon src --level 7 --no-progress

.PHONY: tests
tests:
	vendor/bin/behat
	php bin/phpunit --testdox

database-test:
	php bin/console doctrine:database:drop --if-exists --force --env=test
	php bin/console doctrine:database:create --env=test
	php bin/console doctrine:schema:update --force --env=test

fixtures-test:
	php bin/console doctrine:fixtures:load -n --env=test

prepare-test:
	make database-test
	make fixtures-test

database-dev:
	php bin/console doctrine:database:drop --if-exists --force --env=dev
	php bin/console doctrine:database:create --env=dev
	php bin/console doctrine:schema:update --force --env=dev

fixtures-dev:
	php bin/console doctrine:fixtures:load -n --env=dev

prepare-dev:
	make database-dev
	make fixtures-dev

install:
	composer install
	npm install
	cp .env.dist .env.dev.local
	cp .env.dist .env.test.local
.PHONY: install

deploy:
	composer install
	npm install
	make database-dev
	make fixtures-dev
	npm run build