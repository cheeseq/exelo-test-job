init:
	@cp .env-example .env
	@cp docker-compose-example.yml docker-compose.yml
	@cd ./build && docker-compose build
	@docker-compose up -d
	@sleep 5
	@docker-compose exec web ./yii migrate
	@docker-compose exec web chgrp www-data web/assets runtime var/sessions
	@docker-compose exec web chmod g+rwx web/assets runtime var/sessions
	@docker-compose exec web ./yii websocket-server/start &

run:
	@docker-compose up -d
	@docker-compose exec web ./yii websocket-server/start &