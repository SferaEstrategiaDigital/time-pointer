#!/bin/bash

# Migrar para o banco de dados padrão
echo "Migrando banco de dados padrão..."
php artisan migrate --seed --step

# Migrar para o pgsqlA
echo "Migrando pgsqlA..."
php artisan migrate --database=pgsqlA

# Migrar para o pgsqlB
echo "Migrando pgsqlB..."
php artisan migrate --database=pgsqlB

echo "Migrações concluídas para todas as bases de dados!"
