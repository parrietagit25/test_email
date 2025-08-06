#!/bin/bash

echo "🔧 Instalando dependencias de Composer..."

# Verificar si el contenedor está corriendo
if ! docker ps | grep -q "test_email-email-app-1"; then
    echo "❌ El contenedor no está corriendo. Iniciando..."
    docker-compose up -d
fi

# Instalar dependencias dentro del contenedor
echo "📦 Instalando dependencias..."
docker exec -it test_email-email-app-1 composer install --no-dev --optimize-autoloader

if [ $? -eq 0 ]; then
    echo "✅ Dependencias instaladas correctamente"
    echo "🔄 Reiniciando contenedor..."
    docker-compose restart
    echo "🎉 ¡Listo! Ahora puedes acceder a http://nps.grupopcr.com.pa/email/"
else
    echo "❌ Error al instalar dependencias"
    exit 1
fi
