COMPOSE        := docker compose
COMPOSE_PREPROD := docker compose -f docker-compose.yml -f docker-compose.preprod.yml
COMPOSE_PROD   := docker compose -f docker-compose.yml -f docker-compose.prod.yml

# ─────────────────────────────────────────────────────────────────────────────
# Aide
# ─────────────────────────────────────────────────────────────────────────────

.DEFAULT_GOAL := help

help: ## Afficher l'aide
	@grep -E '^[a-zA-Z_-]+:.*##' $(MAKEFILE_LIST) \
		| awk 'BEGIN {FS = ":.*##"}; {printf "  \033[36m%-22s\033[0m %s\n", $$1, $$2}' \
		| sort

# ─────────────────────────────────────────────────────────────────────────────
# Environnement local
# ─────────────────────────────────────────────────────────────────────────────

build: ## Construire les images (local)
	$(COMPOSE) build

up: ## Démarrer les conteneurs (local)
	$(COMPOSE) up -d
	@printf "\n  \033[32m✔ App    :\033[0m \033[4;36mhttp://localhost:8000\033[0m\n  \033[32m✔ Vite   :\033[0m \033[4;36mhttp://localhost:5173\033[0m\n\n"

up-build: ## Build + démarrer (local)
	$(COMPOSE) up -d --build
	@printf "\n  \033[32m✔ App    :\033[0m \033[4;36mhttp://localhost:8000\033[0m\n  \033[32m✔ Vite   :\033[0m \033[4;36mhttp://localhost:5173\033[0m\n\n"

down: ## Arrêter et supprimer les conteneurs (local)
	$(COMPOSE) down

restart: ## Redémarrer tous les conteneurs (local)
	$(COMPOSE) restart

stop: ## Arrêter les conteneurs sans les supprimer (local)
	$(COMPOSE) stop

ps: ## Lister les conteneurs actifs
	$(COMPOSE) ps

# ─────────────────────────────────────────────────────────────────────────────
# Préprod
# ─────────────────────────────────────────────────────────────────────────────

preprod-build: ## Construire les images (préprod)
	$(COMPOSE_PREPROD) build

preprod-up: ## Démarrer les conteneurs (préprod)
	$(COMPOSE_PREPROD) up -d

preprod-up-build: ## Build + démarrer (préprod)
	$(COMPOSE_PREPROD) up -d --build

preprod-down: ## Arrêter les conteneurs (préprod)
	$(COMPOSE_PREPROD) down

preprod-restart: ## Redémarrer les conteneurs (préprod)
	$(COMPOSE_PREPROD) restart

preprod-ps: ## Lister les conteneurs (préprod)
	$(COMPOSE_PREPROD) ps

# ─────────────────────────────────────────────────────────────────────────────
# Production
# ─────────────────────────────────────────────────────────────────────────────

prod-build: ## Construire les images (prod)
	$(COMPOSE_PROD) build

prod-up: ## Démarrer les conteneurs (prod)
	$(COMPOSE_PROD) up -d

prod-up-build: ## Build + démarrer (prod)
	$(COMPOSE_PROD) up -d --build

prod-down: ## Arrêter les conteneurs (prod)
	$(COMPOSE_PROD) down

prod-restart: ## Redémarrer les conteneurs (prod)
	$(COMPOSE_PROD) restart

prod-ps: ## Lister les conteneurs (prod)
	$(COMPOSE_PROD) ps

# ─────────────────────────────────────────────────────────────────────────────
# Logs (local — suivre en temps réel avec Ctrl+C pour quitter)
# ─────────────────────────────────────────────────────────────────────────────

logs: ## Suivre tous les logs (local)
	$(COMPOSE) logs -f

logs-app: ## Logs du conteneur app (PHP-FPM)
	$(COMPOSE) logs -f app

logs-nginx: ## Logs du conteneur nginx
	$(COMPOSE) logs -f nginx

logs-mysql: ## Logs du conteneur mysql
	$(COMPOSE) logs -f mysql

logs-queue: ## Logs du conteneur queue worker
	$(COMPOSE) logs -f queue

# ─────────────────────────────────────────────────────────────────────────────
# Logs préprod
# ─────────────────────────────────────────────────────────────────────────────

preprod-logs: ## Suivre tous les logs (préprod)
	$(COMPOSE_PREPROD) logs -f

preprod-logs-app: ## Logs app (préprod)
	$(COMPOSE_PREPROD) logs -f app

preprod-logs-nginx: ## Logs nginx (préprod)
	$(COMPOSE_PREPROD) logs -f nginx

preprod-logs-queue: ## Logs queue (préprod)
	$(COMPOSE_PREPROD) logs -f queue

# ─────────────────────────────────────────────────────────────────────────────
# Logs prod
# ─────────────────────────────────────────────────────────────────────────────

prod-logs: ## Suivre tous les logs (prod)
	$(COMPOSE_PROD) logs -f

prod-logs-app: ## Logs app (prod)
	$(COMPOSE_PROD) logs -f app

prod-logs-nginx: ## Logs nginx (prod)
	$(COMPOSE_PROD) logs -f nginx

prod-logs-queue: ## Logs queue (prod)
	$(COMPOSE_PROD) logs -f queue

# ─────────────────────────────────────────────────────────────────────────────
# Consoles (shells interactifs)
# ─────────────────────────────────────────────────────────────────────────────

shell: ## Shell bash dans le conteneur app (local)
	$(COMPOSE) exec app bash

shell-nginx: ## Shell sh dans le conteneur nginx (local)
	$(COMPOSE) exec nginx sh

shell-mysql: ## Console MySQL (local)
	$(COMPOSE) exec mysql mysql -u $${DB_USERNAME} -p$${DB_PASSWORD} $${DB_DATABASE}

shell-root: ## Shell bash en root dans app (local, pour debug)
	$(COMPOSE) exec -u root app bash

preprod-shell: ## Shell bash dans app (préprod)
	$(COMPOSE_PREPROD) exec app bash

prod-shell: ## Shell bash dans app (prod)
	$(COMPOSE_PROD) exec app bash

# ─────────────────────────────────────────────────────────────────────────────
# Laravel — artisan & outils
# ─────────────────────────────────────────────────────────────────────────────

artisan: ## Lancer une commande artisan : make artisan CMD="route:list"
	$(COMPOSE) exec app php artisan $(CMD)

tinker: ## Ouvrir Laravel Tinker
	$(COMPOSE) exec app php artisan tinker

migrate: ## Lancer les migrations (local)
	$(COMPOSE) exec app php artisan migrate

migrate-fresh: ## Recréer la BDD depuis zéro (local)
	$(COMPOSE) exec app php artisan migrate:fresh --seed

migrate-status: ## Statut des migrations (local)
	$(COMPOSE) exec app php artisan migrate:status

cache-clear: ## Vider tous les caches Laravel (local)
	$(COMPOSE) exec app php artisan optimize:clear

# ─────────────────────────────────────────────────────────────────────────────
# Initialisation
# ─────────────────────────────────────────────────────────────────────────────

init: ## Initialiser le projet (copie .env.example, génère APP_KEY)
	@[ -f .env ] || cp .env.example .env
	@echo "Remplis DB_PASSWORD et DB_ROOT_PASSWORD dans .env, puis relance 'make up'"

key: ## Générer APP_KEY (à faire après init si .env est vide)
	$(COMPOSE) run --rm app php artisan key:generate

.PHONY: help \
	build up up-build down restart stop ps \
	preprod-build preprod-up preprod-up-build preprod-down preprod-restart preprod-ps \
	prod-build prod-up prod-up-build prod-down prod-restart prod-ps \
	logs logs-app logs-nginx logs-mysql logs-queue \
	preprod-logs preprod-logs-app preprod-logs-nginx preprod-logs-queue \
	prod-logs prod-logs-app prod-logs-nginx prod-logs-queue \
	shell shell-nginx shell-mysql shell-root preprod-shell prod-shell \
	artisan tinker migrate migrate-fresh migrate-status cache-clear \
	init key
