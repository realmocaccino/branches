#!/bin/bash

# Start MariaDB in the background
mariadbd-safe --datadir=/var/lib/mysql &

# Wait until MariaDB is ready
until mysql -u root -proot -e "SELECT 1;" >/dev/null 2>&1; do
  echo "Waiting for MariaDB to be ready..."
  sleep 2
done

# Create database and user if they don’t exist
mysql -u root -proot -e "
CREATE DATABASE IF NOT EXISTS ${MYSQL_DATABASE};
CREATE USER IF NOT EXISTS '${MYSQL_USER}'@'%' IDENTIFIED BY '${MYSQL_PASSWORD}';
GRANT ALL PRIVILEGES ON ${MYSQL_DATABASE}.* TO '${MYSQL_USER}'@'%';
FLUSH PRIVILEGES;
"

# Run Laravel migrations
php artisan migrate --force

# Insert default settings (after migrations)
mysql -u ${MYSQL_USER} -p${MYSQL_PASSWORD} ${MYSQL_DATABASE} -e "
INSERT INTO settings (url, email, name, description_pt, description_en, description_es, description_fr, analytics, robots, advertisements, created_at, updated_at)
VALUES ('https://example.com', 'admin@example.com', 'My Laravel App', 'Descrição em Português', 'Description in English', 'Descripción en Español', 'Description en Français', '', 'Y', 'N', NOW(), NOW());
"

# Start Apache in the foreground
apache2-foreground
