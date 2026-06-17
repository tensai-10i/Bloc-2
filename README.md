# (RE)Sources Relationnelles

Plateforme web et mobile dédiée à la mise à disposition de ressources, outils et espaces d’échange autour des relations humaines : famille, couple, amitié, collaboration professionnelle, etc.

## Contexte

Le projet **(RE)Sources Relationnelles** s’inscrit dans une simulation de commande portée par le **Ministère des Solidarités et de la Santé**. L’objectif est de proposer une plateforme numérique accessible aux citoyens afin de consulter, créer, partager et modérer des ressources relationnelles. :contentReference[oaicite:6]{index=6}

Les enjeux principaux du projet sont :

- renforcer la cohésion sociale
- améliorer la qualité des relations humaines
- proposer des ressources fiables et accessibles
- fournir des outils de suivi, de progression et de statistiques :contentReference[oaicite:7]{index=7} :contentReference[oaicite:8]{index=8}

---

## Objectifs du projet

La plateforme doit permettre :

- la mise à disposition de ressources de différents types
- la gestion d’un catalogue structuré par catégories, types de relations et types de ressources
- la création et le partage de ressources
- la modération des contenus
- la gestion des comptes utilisateurs et des rôles
- le suivi de progression des utilisateurs
- l’édition de statistiques liées aux consultations, recherches, créations et partages :contentReference[oaicite:9]{index=9} :contentReference[oaicite:10]{index=10} :contentReference[oaicite:11]{index=11}

---

## Stack technique retenue

Conformément au cahier des charges, l’architecture cible du projet est la suivante :

### Back-end
- **Laravel**
- API REST
- Authentification **JWT**
- Architecture **MVC**

### Front-end web
- **React.js**
- **Tailwind CSS**

### Base de données
- **MySQL**

### Serveur / déploiement
- **Apache**
- **Docker**
- **Docker Compose**
- Hébergement cible sur **Debian**

### Versioning / gestion collaborative
- **Git**
- **GitHub**
- **Trello**
- **Discord / Teams**
- **Google Drive** pour la documentation centralisée :contentReference[oaicite:12]{index=12}

---

## Contraintes et standards

Le projet doit respecter les contraintes suivantes :

- architecture **MVC**
- application **web + mobile**
- compatibilité navigateurs courants
- respect du **RGPD**
- respect du **RGAA**
- anonymisation et chiffrement des données sensibles
- simplicité d’utilisation et accessibilité pour tous les publics :contentReference[oaicite:13]{index=13} :contentReference[oaicite:14]{index=14}

---

## Fonctionnalités attendues

### Espace public
- page de présentation de l’application
- page d’aide
- consultation des ressources
- filtrage et tri des ressources
- affichage du détail d’une ressource
- accès aux ressources publiques et restreintes selon le profil :contentReference[oaicite:15]{index=15}

### Comptes utilisateurs
- création de compte citoyen
- connexion
- gestion des rôles
- désactivation / réactivation de comptes
- comptes : citoyen, modérateur, administrateur, super-administrateur :contentReference[oaicite:16]{index=16} :contentReference[oaicite:17]{index=17}

### Gestion des ressources
- ajout / édition / suppression de ressources
- gestion des catégories
- validation avant publication
- partage de publication :contentReference[oaicite:18]{index=18}

### Échanges et modération
- ajout de commentaires
- réponses aux commentaires
- modération des commentaires
- validation des ressources créées par les utilisateurs :contentReference[oaicite:19]{index=19}

### Progression utilisateur
- favoris
- ressources exploitées / non exploitées
- mise de côté
- tableau de bord personnel
- démarrage d’activités / jeux
- invitation d’autres participants
- échanges de messages dans le cadre d’une ressource :contentReference[oaicite:20]{index=20}

### Statistiques
- tableau de bord statistiques
- filtres par période, catégorie, type de relation, type de ressource, zone géographique
- export des statistiques :contentReference[oaicite:21]{index=21}

---

## Priorisation MoSCoW

### Must Have
- consultation des ressources
- création de compte et connexion
- création et gestion des ressources
- modération des ressources et commentaires
- catégories / types / filtres
- système de rôles utilisateurs

### Should Have
- favoris
- mise de côté
- historique / progression

### Could Have
- traduction multilingue
- ressources ludiques ou interactives

### Won’t Have
- notifications push
- recommandation automatique par machine learning :contentReference[oaicite:22]{index=22}

---

## Architecture fonctionnelle

Le projet suit une architecture **MVC** :

- **Modèle** : gestion des données (utilisateurs, ressources, catégories, commentaires, statistiques)
- **Vue** : interface React côté web
- **Contrôleur** : logique métier côté Laravel API :contentReference[oaicite:23]{index=23}

### Découpage technique recommandé

#### Back-end Laravel
- gestion de l’authentification JWT
- gestion des rôles et permissions
- CRUD ressources / catégories / commentaires
- validation et modération
- gestion des statistiques
- endpoints API pour le front web et le mobile

#### Front-end React
- page d’accueil
- catalogue de ressources
- filtres et recherche
- page détail ressource
- espace utilisateur
- dashboard admin
- interface de modération

#### Base de données MySQL
Entités principales :
- users
- roles
- resources
- categories
- relation_types
- resource_types
- comments
- favorites
- progressions
- shares
- statistics :contentReference[oaicite:24]{index=24} :contentReference[oaicite:25]{index=25}

---

## Organisation du dépôt

```bash
resources-relationnelles/
├── backend/                 # Laravel API
├── frontend/                # React.js
├── mobile/                  # Prototype mobile
├── docker/                  # Config Apache / PHP / MySQL
├── docs/                    # Cahier de tests, UML, Merise, documentation
├── .github/                 # Workflows GitHub
└── README.md
