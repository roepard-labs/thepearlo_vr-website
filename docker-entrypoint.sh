#!/bin/bash
set -e

echo "🚀 Iniciando HomeLab Frontend..."

# Generar config.js desde variables de entorno
echo "⚙️  Generando config.js desde variables de entorno..."
cd /var/www/html
npm run build:config

# Verificar que config.js se generó
if [ -f /var/www/html/js/config.js ]; then
    echo "✅ config.js generado correctamente"
    echo "📄 Contenido:"
    cat /var/www/html/js/config.js
else
    echo "❌ ERROR: config.js no se generó"
    exit 1
fi

# Ajustar permisos
chmod 644 /var/www/html/js/config.js
chown www-data:www-data /var/www/html/js/config.js

echo "🎯 Iniciando servicios con supervisord..."

# Ejecutar supervisord (nginx + php-fpm)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
