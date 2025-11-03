#!/bin/bash
set -e

echo "🚀 Iniciando HomeLab Frontend..."

# Generar config.js desde variables de entorno
echo "⚙️  Generando config.js desde variables de entorno..."
cd /var/www/html
npm run build:config

# Verificar que config.js se generó (en composables/)
if [ -f /var/www/html/composables/config.js ]; then
    echo "✅ config.js generado correctamente"
    echo "📄 Contenido:"
    cat /var/www/html/composables/config.js
else
    echo "❌ ERROR: config.js no se generó en composables/"
    # Verificar ruta legacy por si acaso
    if [ -f /var/www/html/js/config.js ]; then
        echo "⚠️  Encontrado en ruta legacy: /var/www/html/js/config.js"
        cat /var/www/html/js/config.js
    else
        exit 1
    fi
fi

# Ajustar permisos (composables/)
if [ -f /var/www/html/composables/config.js ]; then
    chmod 644 /var/www/html/composables/config.js
    chown www-data:www-data /var/www/html/composables/config.js
fi

# Ajustar permisos (legacy path por compatibilidad)
if [ -f /var/www/html/js/config.js ]; then
    chmod 644 /var/www/html/js/config.js
    chown www-data:www-data /var/www/html/js/config.js
fi

echo "🎯 Iniciando servicios con supervisord..."

# Ejecutar supervisord (nginx + php-fpm)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
