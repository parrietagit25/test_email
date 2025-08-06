#!/bin/bash

echo "🚀 Desplegando Sistema de Correos en el Servidor"
echo "================================================"

# Verificar si estamos en el directorio correcto
if [ ! -f "docker-compose.yml" ]; then
    echo "❌ No se encontró docker-compose.yml. Asegúrate de estar en el directorio correcto."
    exit 1
fi

# Crear archivo .env para el servidor
echo "📝 Configurando variables de entorno..."
cat > .env << EOF
# SendGrid API Key - REEMPLAZA CON TU API KEY REAL
SENDGRID_API_KEY=SG.your-api-key-here

# Configuración del remitente
FROM_EMAIL=noreply@tuempresa.com
FROM_NAME=Sistema de Correos
EOF

echo "✅ Archivo .env creado"
echo "⚠️  IMPORTANTE: Edita el archivo .env y reemplaza SG.your-api-key-here con tu API Key real de SendGrid"

# Verificar si Docker está corriendo
if ! docker info > /dev/null 2>&1; then
    echo "❌ Docker no está corriendo. Iniciando Docker..."
    sudo systemctl start docker
fi

# Detener contenedores existentes si los hay
echo "🛑 Deteniendo contenedores existentes..."
docker-compose down

# Construir la imagen
echo "🔨 Construyendo imagen Docker..."
docker-compose build --no-cache

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
    echo "🎉 ¡Despliegue completado!"
    echo "📧 Accede a tu aplicación en: http://tu-servidor:8083"
    echo ""
    echo "📋 Información del despliegue:"
    echo "- Puerto: 8083"
    echo "- Contenedor: email-app"
    echo "- Estado: docker ps"
    echo ""
    echo "🔧 Comandos útiles:"
    echo "- Ver logs: docker-compose logs -f"
    echo "- Reiniciar: docker-compose restart"
    echo "- Detener: docker-compose down"
    echo ""
    echo "⚠️  RECUERDA: Edita el archivo .env con tu API Key real de SendGrid"
else
    echo "❌ Error al iniciar el contenedor"
    exit 1
fi
