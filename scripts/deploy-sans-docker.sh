#!/bin/bash
# Déploiement Infinity WAB - Production
# Usage: ./scripts/deploy-sans-docker.sh
# Chemin: /var/www/infinity-wab-site

set -e

cd "$(dirname "$0")/.."

echo "=== Déploiement Infinity WAB ==="

[[ -f .env ]] || { echo "ERREUR: .env manquant. Copiez .env.example vers .env"; exit 1; }
grep -q 'APP_KEY=base64:' .env || { echo "ERREUR: APP_KEY manquante. Exécutez: php artisan key:generate"; exit 1; }

[[ -d .git ]] && { echo "Mise à jour Git..."; git pull origin main 2>/dev/null || git pull 2>/dev/null || true; }

echo "Dépendances PHP..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "Build assets..."
npm ci
npm run build

echo "Base de données..."
php artisan migrate --force

echo "Storage..."
php artisan storage:link 2>/dev/null || true

echo "Cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

echo "Permissions..."
sudo chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
sudo chmod -R 775 storage bootstrap/cache 2>/dev/null || true

command -v supervisorctl &>/dev/null && sudo supervisorctl restart "infinity-wab-queue:*" 2>/dev/null || true

echo "=== Terminé ==="
