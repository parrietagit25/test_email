# 🚀 Despliegue en Servidor

## 📋 Estado Actual del Servidor

Según la información proporcionada, el servidor ya tiene los siguientes contenedores corriendo:

- **phpMyAdmin**: Puerto 8080
- **NPS PHP**: Puerto 8082  
- **MySQL**: Puerto 3306

## 🔧 Configuración del Sistema de Correos

### Puerto Asignado
El sistema de correos usará el **puerto 8083** para evitar conflictos.

### Pasos para Desplegar

1. **Subir archivos al servidor:**
   ```bash
   # En tu máquina local
   scp -r email/ ubuntu@tu-servidor:/home/ubuntu/
   ```

2. **Conectarse al servidor:**
   ```bash
   ssh ubuntu@tu-servidor
   cd /home/ubuntu/email
   ```

3. **Ejecutar el script de despliegue:**
   ```bash
   chmod +x deploy-server.sh
   ./deploy-server.sh
   ```

4. **Configurar SendGrid:**
   ```bash
   # Editar el archivo .env
   nano .env
   ```
   
   Reemplaza `SG.your-api-key-here` con tu API Key real de SendGrid.

5. **Reiniciar el contenedor:**
   ```bash
   docker-compose restart
   ```

## 🌐 Acceso a la Aplicación

Una vez desplegado, accede a:
```
http://tu-servidor:8083
```

## 📊 Verificar Estado

```bash
# Ver todos los contenedores
docker ps

# Ver logs del sistema de correos
docker-compose logs -f

# Verificar puertos en uso
netstat -tlnp | grep :808
```

## 🔧 Comandos Útiles

```bash
# Reiniciar el contenedor
docker-compose restart

# Ver logs en tiempo real
docker-compose logs -f

# Detener el contenedor
docker-compose down

# Reconstruir y reiniciar
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

## 🛠️ Solución de Problemas

### Puerto ocupado
Si el puerto 8083 está ocupado, edita `docker-compose.yml`:
```yaml
ports:
  - "8084:80"  # Cambia a otro puerto disponible
```

### Error de permisos
```bash
sudo chown -R ubuntu:ubuntu /home/ubuntu/email
```

### Error de Docker
```bash
sudo systemctl restart docker
```

## 📝 Notas Importantes

- ✅ El sistema usa el puerto **8083** para evitar conflictos
- ✅ Todas las variables de entorno están en el archivo `.env`
- ✅ El contenedor se reinicia automáticamente si se detiene
- ✅ Los logs se pueden ver con `docker-compose logs -f`

## 🔒 Seguridad

- Cambia la API Key de SendGrid en el archivo `.env`
- Considera usar HTTPS en producción
- Revisa los logs regularmente
