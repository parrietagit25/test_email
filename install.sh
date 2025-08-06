#!/bin/bash

echo "🚀 Instalando Sistema de Correos con SendGrid"
echo "=============================================="

# Verificar si Docker está instalado
if ! command -v docker &> /dev/null; then
    echo "❌ Docker no está instalado. Por favor instala Docker primero."
    exit 1
fi

# Verificar si Docker Compose está instalado
if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose no está instalado. Por favor instala Docker Compose primero."
    exit 1
fi

echo "✅ Docker y Docker Compose están instalados"

# Crear archivo .env si no existe
if [ ! -f .env ]; then
    echo "📝 Creando archivo .env..."
    cat > .env << EOF
# SendGrid API Key
# Obtén tu API key desde: https://app.sendgrid.com/settings/api_keys
SENDGRID_API_KEY=SG.your-api-key-here

# Configuración del remitente
FROM_EMAIL=noreply@tuempresa.com
FROM_NAME=Sistema de Correos
EOF
    echo "✅ Archivo .env creado"
    echo "⚠️  IMPORTANTE: Edita el archivo .env y reemplaza SG.your-api-key-here con tu API Key real de SendGrid"
else
    echo "✅ Archivo .env ya existe"
fi

# Construir la imagen Docker
echo "🔨 Construyendo imagen Docker..."
docker-compose build

if [ $? -eq 0 ]; then
    echo "✅ Imagen construida exitosamente"
else
    echo "❌ Error al construir la imagen"
    exit 1
fi

# Ejecutar el contenedor
echo "🚀 Iniciando el contenedor..."
docker-compose up -d

if [ $? -eq 0 ]; then
    echo "✅ Contenedor iniciado exitosamente"
    echo ""
    echo "🎉 ¡Instalación completada!"
    echo "📧 Accede a tu aplicación en: http://localhost:8083"
    echo ""
    echo "📋 Próximos pasos:"
    echo "1. Edita el archivo .env con tu API Key de SendGrid"
    echo "2. Reinicia el contenedor: docker-compose restart"
    echo "3. ¡Disfruta enviando correos!"
else
    echo "❌ Error al iniciar el contenedor"
    exit 1
fi
