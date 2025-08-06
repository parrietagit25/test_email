# Sistema de Envío de Correos con SendGrid

Un sistema básico para enviar correos electrónicos usando SendGrid, PHP y Docker.

## 🚀 Características

- ✅ Formulario web intuitivo y responsive
- ✅ Integración con SendGrid API
- ✅ Containerizado con Docker
- ✅ Interfaz moderna y atractiva
- ✅ Validación de formularios
- ✅ Manejo de errores

## 📋 Requisitos

- Docker y Docker Compose
- Cuenta de SendGrid (gratuita disponible)

## 🛠️ Instalación

### 1. Clonar el repositorio
```bash
git clone <tu-repositorio>
cd email
```

### 2. Configurar SendGrid

1. Ve a [SendGrid](https://app.sendgrid.com/settings/api_keys)
2. Crea una nueva API Key
3. Copia la API Key

### 3. Configurar variables de entorno

Crea un archivo `.env` en la raíz del proyecto:
```bash
# SendGrid API Key
SENDGRID_API_KEY=SG.tu-api-key-aqui

# Configuración del remitente
FROM_EMAIL=noreply@tuempresa.com
FROM_NAME=Sistema de Correos
```

### 4. Construir y ejecutar con Docker

```bash
# Construir la imagen
docker-compose build

# Ejecutar el contenedor
docker-compose up -d
```

### 5. Acceder a la aplicación

Abre tu navegador y ve a: `http://localhost:8083`

## 📧 Uso

1. Completa el formulario con:
   - **Destinatario**: Email del destinatario
   - **Asunto**: Asunto del correo
   - **Mensaje**: Contenido del correo

2. Haz clic en "Enviar Correo"

3. El sistema mostrará un mensaje de éxito o error según corresponda.

## 🔧 Configuración Avanzada

### Cambiar el puerto
Edita el archivo `docker-compose.yml`:
```yaml
ports:
  - "3000:80"  # Cambia 3000 por el puerto deseado
```

### Personalizar el remitente
Modifica las variables en el archivo `.env`:
```bash
FROM_EMAIL=tu-email@dominio.com
FROM_NAME=Tu Nombre
```

## 🐛 Solución de Problemas

### Error de API Key
- Verifica que tu API Key de SendGrid sea válida
- Asegúrate de que la cuenta de SendGrid esté verificada

### Error de Docker
```bash
# Reconstruir la imagen
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

### Error de permisos
```bash
# En Linux/Mac
sudo chown -R $USER:$USER .
```

## 📁 Estructura del Proyecto

```
email/
├── index.php          # Archivo principal con formulario y lógica
├── config.php         # Configuración del sistema
├── composer.json      # Dependencias de PHP
├── Dockerfile         # Configuración de Docker
├── docker-compose.yml # Orquestación de contenedores
├── .dockerignore      # Archivos ignorados en Docker
└── README.md          # Este archivo
```

## 🔒 Seguridad

- ✅ Validación de entrada de datos
- ✅ Escape de HTML para prevenir XSS
- ✅ Variables de entorno para configuración sensible
- ✅ Manejo seguro de errores

## 📝 Licencia

Este proyecto está bajo la Licencia MIT.

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Por favor, abre un issue o pull request.

---

**Nota**: Recuerda reemplazar `SG.your-api-key-here` con tu API Key real de SendGrid antes de usar el sistema.
