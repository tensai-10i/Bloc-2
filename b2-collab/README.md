# B2 Collab

Application web collaborative construite avec Laravel 12, Tailwind CSS et Alpine.js.

---

## Prérequis

- [Docker](https://www.docker.com/) et Docker Compose v2
- `make`

Aucune installation locale de PHP, Node.js ou MySQL n'est nécessaire.

---

## Installation

### 1. Cloner le dépôt

```bash
git clone <url-du-repo>
cd b2-collab
```

### 2. Configurer l'environnement

```bash
cp .env.example .env
```

Ouvrir `.env` et renseigner les variables suivantes :

```dotenv
APP_URL=http://localhost:8000

DB_PASSWORD=un_mot_de_passe
DB_ROOT_PASSWORD=un_mot_de_passe_root
```

Les autres valeurs sont pré-configurées pour Docker et fonctionnent sans modification.

### 3. Construire et démarrer les conteneurs

```bash
make up-build
```

### 4. Générer la clé applicative

```bash
make key
```

### 5. Accéder à l'application

| Service | URL |
|---------|-----|
| Application | http://localhost:8000 |
| Vite (hot reload) | http://localhost:5173 |

Les migrations sont exécutées automatiquement au démarrage.

---

## Commandes quotidiennes

```bash
make up          # Démarrer les conteneurs
make down        # Arrêter et supprimer les conteneurs
make restart     # Redémarrer les conteneurs
make ps          # Voir l'état des conteneurs
```

### Logs

```bash
make logs        # Tous les conteneurs
make logs-app    # PHP-FPM (Laravel)
make logs-nginx  # Nginx
make logs-mysql  # MySQL
make logs-queue  # Queue worker
```

### Consoles

```bash
make shell         # Bash dans le conteneur app
make shell-mysql   # Console MySQL
make tinker        # Laravel Tinker
```

### Laravel

```bash
make migrate                      # Lancer les migrations
make migrate-fresh                # Recréer la base de données (+ seeders)
make migrate-status               # Voir l'état des migrations
make artisan CMD="route:list"     # Toute commande artisan
make cache-clear                  # Vider les caches
```

---

## Environnements

### Préprod

```bash
# Copier et adapter le .env pour la préprod
make preprod-up-build
```

### Production

```bash
# Copier et adapter le .env pour la prod
make prod-up-build
```

| Environnement | Commande de démarrage | Port |
|---|---|---|
| Local | `make up-build` | 8000 |
| Préprod | `make preprod-up-build` | 80 |
| Production | `make prod-up-build` | 80 |

---

## Architecture Docker

| Conteneur | Rôle |
|-----------|------|
| `app` | PHP 8.4-FPM — exécute Laravel |
| `nginx` | Serveur web — reverse proxy vers app |
| `mysql` | Base de données MySQL 8.0 |
| `queue` | Worker de queue Laravel |
| `vite` | Serveur de développement Vite (local uniquement) |

---

## Stack technique

- **Backend** : Laravel 12, PHP 8.4
- **Frontend** : Vite, Tailwind CSS, Alpine.js
- **Base de données** : MySQL 8.0
- **Authentification** : Laravel Sanctum + Breeze
