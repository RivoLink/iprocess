serve:
	php -S localhost:7002 -t src/
.PHONY: serve

expose:
	cd src && symfony serve --port 7002 --allow-all-ip
.PHONY: expose

open:
	open http://localhost:7002
.PHONY: open

helper:
	yarn install --cwd .helper
	composer install --working-dir .helper
.PHONY: helper

token:
	php .helper/scripts/token.php
.PHONY: token

build:
	php .helper/scripts/build.php
.PHONY: build
