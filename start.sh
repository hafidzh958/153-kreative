#!/bin/bash
set -e

echo "==> Running migrations..."
php artisan migrate --force --no-interaction

echo "==> Running seeders..."
php artisan db:seed --force --no-interaction

echo "==> Linking storage..."
php artisan storage:link --force 2>/dev/null || true

echo "==> Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
