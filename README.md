# Infinity WAB - Site Web Professionnel

Un site web moderne et dynamique pour l'entreprise Infinity WAB, spécialisée dans les solutions technologiques au Burkina Faso.

## 🚀 Fonctionnalités

### Frontend
- **Design moderne et responsive** avec animations fluides
- **Interface utilisateur intuitive** inspirée des standards SaaS
- **Effets visuels subtils** : glassmorphism, micro-animations
- **100% Mobile-first** et compatible tous navigateurs
- **SEO optimisé** avec balises sémantiques

### Backend (Laravel)
- **Architecture MVC** robuste et scalable
- **Base de données MySQL** optimisée
- **API RESTful** pour les futures évolutions
- **Sécurité renforcée** avec validation et protection CSRF

### Interface d'Administration
- **Tableau de bord complet** avec statistiques
- **Gestion des services** (CRUD complet)
- **Gestion des projets** avec statuts et catégories
- **Gestion des produits** avec images et spécifications
- **Gestion des messages** avec statuts de lecture
- **Éditeur de contenu** pour les pages du site
- **Authentification sécurisée** et gestion des rôles

## 🎨 Design System

### Couleurs
- **Principal** : `#212832` (sombre)
- **Secondaire** : `#E0E1E2` (clair)
- **Neutre** : `#65696A` (gris)
- **Accent gradients** : 
  - `#00FFC3` (cyan)
  - `#00E5FF` (bleu clair)
  - `#3A1F5C` (violet)

### Typographie
- **Police** : Inter (Google Fonts)
- **Hiérarchie claire** pour l'accessibilité
- **Poids variés** pour la lisibilité
```
│   └── seeders/        # Données de test
├── resources/
│   ├── views/
│   │   ├── layouts/    # Templates principaux
│   │   ├── partials/   # Composants réutilisables
│   │   ├── admin/      # Vues d'administration
│   │   └── *.blade.php # Pages du site
│   ├── css/           # Styles personnalisés
│   └── js/            # Scripts JavaScript
├── routes/
│   └── web.php        # Routes web
└── public/            # Assets publics
```

## 🚀 Installation

### Prérequis
- PHP 8.4+
- Composer
- Node.js 18+
- MySQL 8.0+

### Étapes
1. **Cloner le projet**
   ```bash
   git clone <repository-url>
   cd infinity-wab-site
   ```

2. **Installer les dépendances PHP**
   ```bash
   composer install
   ```

3. **Installer les dépendances JS**
   ```bash
   npm install
   ```

4. **Configurer l'environnement**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configurer la base de données**
   - Modifier `.env` avec vos informations BDD
   - Créer la base de données

6. **Lancer les migrations**
   ```bash
   php artisan migrate
   ```

7. **Démarrer les serveurs**
   ```bash
   # Serveur Laravel (terminal 1)
   php artisan serve
   
   # Serveur Vite (terminal 2)
   npm run dev
   ```

## Déploiement en Production

Déploiement sur serveur **Nginx + PHP-FPM** (sans Docker) :

```bash
# Sur le serveur : cloner, configurer, déployer
git clone <repository-url>
cd infinity-wab-site
cp .env.example .env
# Éditer .env avec vos paramètres

php artisan key:generate
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force

# Pour les mises à jour
./scripts/deploy-sans-docker.sh
```

Voir [DEPLOY_SANS_DOCKER.md](DEPLOY_SANS_DOCKER.md) pour le guide complet (Nginx, PHP-FPM, MySQL, SSL).

## � Pages du Site

### Pages Publiques
- **Accueil** (`/`) : Hero section et présentation
- **Services** (`/services`) : Détail des 6 services
- **Projets** (`/projets`) : Portfolio et réalisations
- **Produits** (`/produits`) : Catalogue des produits
- **À propos** (`/a-propos`) : Vision et mission
- **Contact** (`/contact`) : Formulaire et informations

### Pages d'Administration
- **Tableau de bord** (`/admin`) : Vue d'ensemble
- **Services** (`/admin/services`) : Gestion des services
- **Projets** (`/admin/projets`) : Gestion des projets
- **Produits** (`/admin/produits`) : Gestion des produits
- **Contenu** (`/admin/contenu`) : Éditeur de contenu
- **Messages** (`/admin/messages`) : Messages des visiteurs
- **Statistiques** (`/admin/statistiques`) : Analytics

## 🎯 Objectifs Atteints

### ✅ Fonctionnalités Implémentées
- [x] **Design moderne** avec identité visuelle forte
- [x] **Interface responsive** et mobile-first
- [x] **Animations fluides** et effets visuels
- [x] **Interface d'admin** complète et fonctionnelle
- [x] **Base de données** structurée et optimisée
- [x] **SEO optimisé** avec balises sémantiques
- [x] **Code propre** et maintenable

### 🔄 En cours
- [ ] **Formulaire de contact** fonctionnel (backend)
- [ ] **Système d'authentification** admin
- [ ] **Gestion des médias** (upload images)
- [ ] **Système de notifications**

### 📋 Améliorations Futures
- [ ] **Blog/Actualités** pour le contenu dynamique
- [ ] **Système de réservations** en ligne
- [ ] **Intégration paiement** pour les services
- [ ] **API mobile** pour application dédiée
- [ ] **Multilingue** (français/anglais)
- [ ] **Tests automatisés** (unitaires et fonctionnels)

## � Tests Automatisés

Le projet inclut une suite complète de tests automatisés avec GitHub Actions :

### 📊 Types de tests
- **Tests Laravel** : Unitaires, fonctionnels et intégration avec PHPUnit
- **Tests JavaScript** : Tests Vue.js avec Vitest
- **Qualité code** : PHPStan, PHP CS Fixer, ESLint, Prettier
- **Sécurité** : Trivy, Snyk, CodeQL, audit dépendances
- **Coverage** : Rapport de couverture de code (70% minimum)

### 🚀 Workflow CI/CD
```bash
# Déclenché automatiquement sur :
- Push sur branches main/develop
- Pull requests  
- Schedule quotidien (scan sécurité)
```

### 🏆 Badges de qualité
![Tests](https://github.com/username/infinity-wab-site/workflows/CI/CD%20Pipeline/badge.svg)
![Security](https://github.com/username/infinity-wab-site/workflows/Security%20Scan/badge.svg)
![Coverage](https://codecov.io/gh/username/infinity-wab-site/branch/main/graph/badge.svg)

### 🛠️ Tests locaux
```bash
# Installation
composer install
npm install

# Tests complets
npm run ci

# Tests individuels
vendor/bin/phpunit          # Tests PHP
npm test                    # Tests JS
npm run lint                # Qualité code
```

## 📚 Documentation

- [Guide de déploiement sans Docker](DEPLOY_SANS_DOCKER.md)
- [Documentation Laravel](https://laravel.com/docs)
- [GitHub Actions](https://docs.github.com/en/actions)
- [PHPUnit Testing](https://phpunit.de/documentation.html)
- [Vitest Testing](https://vitest.dev/)

## 🤝 Support

Pour toute question ou problème:
- Email: support@infinity-wab.bf
- Documentation: `/docs`
- Issues: GitHub Issues

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

---

**Infinity WAB** - Une technologie pour le Burkina Faso par le Burkina Faso

*Développé avec ❤️ au Burkina Faso*
