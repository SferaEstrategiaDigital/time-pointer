#!/bin/bash

set -e

BACKUP_DIR="/backups"

PS3="Por favor, selecione o arquivo de backup para restaurar: "

select BACKUP_FILE in $BACKUP_DIR/*.sql
do
    if [[ -n "$BACKUP_FILE" ]]
    then
        echo "Iniciando a restauração do banco de dados a partir do arquivo: $BACKUP_FILE"
        
        PGPASS_FILE="$HOME/.pgpass"
        
        echo "localhost:5432:${POSTGRES_DB}:${POSTGRES_USER}:${POSTGRES_PASSWORD}" > "$PGPASS_FILE"
        
        chmod 0600 "$PGPASS_FILE"
        
        echo "Apagando o banco de dados existente..."
        psql -U "$POSTGRES_USER" -c "DROP DATABASE IF EXISTS $POSTGRES_DB;"
        
        echo "Criando novo banco de dados..."
        psql -U "$POSTGRES_USER" -c "CREATE DATABASE $POSTGRES_DB;"
        
        psql --username "$POSTGRES_USER" "$POSTGRES_DB" < "$BACKUP_FILE"
        
        rm "$PGPASS_FILE"
        
        echo "Restauração realizada com sucesso!"
        
        break
    else
        echo "Opção inválida, tente novamente!"
    fi
done
