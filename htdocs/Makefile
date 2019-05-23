.PHONY: install
install:
	composer install
	cp -ap config/.env.dev config/.env

.PHONY: refresh-autoload
refresh-autoload:
	composer dump-autoload

.PHONY: generate-entities
generate-entities:
	php vendor/bin/doctrine orm:convert-mapping --from-database annotation ./src/Entity/

# make table=Users generate-entity
.PHONY: generate-entity
generate-entity:
	php vendor/bin/doctrine orm:convert-mapping --filter="${table}" --from-database annotation ./src/Entity/