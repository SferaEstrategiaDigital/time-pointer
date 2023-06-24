#!/bin/bash

set -e

BACKUP_DIR="/backups"
mkdir -p "$BACKUP_DIR"

echo -e "*\n!.gitignore" > "$BACKUP_DIR/.gitignore"

BACKUP_FILE="$BACKUP_DIR/backup_$(date +'%Y%m%d_%H%M%S').sql"

echo "Iniciando o backup do banco de dados..."

PGPASS_FILE="$HOME/.pgpass"

echo "localhost:5432:${POSTGRES_DB}:${POSTGRES_USER}:${POSTGRES_PASSWORD}" > "$PGPASS_FILE"

chmod 0600 "$PGPASS_FILE"

pg_dump --username "$POSTGRES_USER" --file="$BACKUP_FILE" "$POSTGRES_DB" --exclude-table *jobs*

rm "$PGPASS_FILE"

chown -R $HOME_USER: "$BACKUP_DIR"

echo "Backup realizado com sucesso! Arquivo de backup: $BACKUP_FILE"