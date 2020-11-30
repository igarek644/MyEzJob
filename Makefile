APP_NAME = MyEzJob

SHELL ?= /bin/bash
ARGS = $(filter-out $@,$(MAKECMDGOALS))

IMAGE_TAG = latest
IMAGE_NAME = ipravdyvyi/php-nginx

BUILD_ID ?= $(shell /bin/date "+%Y%m%d-%H%M%S")

.SILENT: ;               # no need for @
.ONESHELL: ;             # recipes execute in same shell
.NOTPARALLEL: ;          # wait for this target to finish
.EXPORT_ALL_VARIABLES: ; # send all vars to shell
Makefile: ;              # skip prerequisite discovery

# Run make help by default
.DEFAULT_GOAL = help

.PHONY: build
build:
	docker build \
		--build-arg VERSION=$(VERSION) \
		--build-arg BUILD_ID=$(BUILD_ID) \
		-t $(IMAGE_NAME):$(IMAGE_TAG) \
		--no-cache \
		--force-rm .

.PHONY: up
up: network
	docker-compose up -d

.PHONY: install
install: up
	docker-compose exec app composer install

.PHONY: bash
bash: up
	docker-compose exec app bash

.PHONY: help
help: .title
	@echo ''
	@echo 'Usage: make [target] [ENV_VARIABLE=ENV_VALUE ...]'
	@echo ''
	@echo 'Available targets:'
	@echo ''
	@echo '  help             Show this help and exit'
	@echo '  build            Build or rebuild services'
	@echo '  up               Starts and attaches to containers for a service'
	@echo '  bash             Go to the application container (if any)'
	@echo '                   Also this command will remove MySQL, Redis and Consul volumes'
	@echo ''

%:
	@: