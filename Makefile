compose-run-dev: compose-build compose-run dev-all

compose-build:
	docker-compose build;
compose-run:
	docker-compose up -d;