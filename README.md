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

## 📦 Installation

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

## 🗺️ Pages du Site

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

## 🎯 État du Projet

### ✅ Implémenté
- **Design moderne** et interface responsive/mobile-first
- **Interface d'admin** complète (services, projets, produits, contenu, messages, statistiques, utilisateurs)
- **Authentification** (inscription, connexion, vérification email, reset mot de passe) avec politique de mot de passe renforcée (`app/Providers/AppServiceProvider.php`) et throttling anti-bruteforce
- **Formulaire de contact** fonctionnel avec anti-spam (honeypot + délai minimal de soumission)
- **En-têtes de sécurité** (CSP à base de nonces, HSTS, X-Frame-Options, etc. — `app/Http/Middleware/SecurityHeaders.php`)
- **Tests automatisés PHPUnit** sur l'authentification et l'administration (`tests/Feature`)
- **Base de données** avec index de performance sur les tables principales

### 🔄 Connu et non résolu
- Pas de pipeline CI/CD (aucun `.github/workflows`) : les tests/lint doivent être lancés manuellement avant de merger
- Pas de suivi d'erreurs centralisé en production (Sentry ou équivalent)
- Pas de tests JavaScript (Vitest est configuré mais aucun fichier de test JS n'existe encore)
- Pas d'authentification à deux facteurs pour le compte admin
- Pas de PHPStan/Larastan installé

### 📋 Améliorations Futures
- Blog/Actualités pour le contenu dynamique
- Système de réservations en ligne
- Intégration paiement pour les services
- API mobile pour application dédiée
- Multilingue (français/anglais)

## 🧪 Tests locaux

```bash
# Installation
composer install
npm install

# Tests PHP (nécessite une base de données de test, voir phpunit.xml)
php artisan test
# ou
vendor/bin/phpunit

# Qualité et tests JS (lint, type-check, audit npm — pas de tests JS pour l'instant)
npm run ci
```

## 📚 Documentation

- [Documentation Laravel](https://laravel.com/docs)
- [PHPUnit Testing](https://phpunit.de/documentation.html)
- [Vitest Testing](https://vitest.dev/)

## 🤝 Support

Pour toute question ou problème:
- Email: infinity-wab@infinity-wab.com
- Issues: GitHub Issues

## 📄 Licence

Code propriétaire — © Infinity WAB. Tous droits réservés. Aucune redistribution ou réutilisation sans autorisation.

---

**Infinity WAB** - Une technologie pour le Burkina Faso par le Burkina Faso

*Développé avec ❤️ au Burkina Faso*
