#!/bin/bash
###############################################################################
# Status Check Script - HomeLab VR Frontend
# Verifica el estado completo del deployment en producción
# 
# Uso: bash /var/www/html/utils/status.sh
#      O desde dentro del contenedor: cd /var/www/html && bash utils/status.sh
#
# NO se ejecuta automáticamente - Solo uso manual para diagnóstico
###############################################################################

set -e

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color
BOLD='\033[1m'

# Símbolos
CHECK="✅"
CROSS="❌"
WARN="⚠️"
INFO="ℹ️"
ROCKET="🚀"

echo -e "${BOLD}${CYAN}"
echo "╔════════════════════════════════════════════════════════════════╗"
echo "║                                                                ║"
echo "║      HomeLab VR - Frontend Deployment Status Check            ║"
echo "║                                                                ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo -e "${NC}"
echo ""

# Timestamp
echo -e "${BLUE}${INFO} Fecha: $(date '+%Y-%m-%d %H:%M:%S')${NC}"
echo -e "${BLUE}${INFO} Hostname: $(hostname)${NC}"
echo ""

###############################################################################
# 1. VERIFICAR ESTRUCTURA DE DIRECTORIOS
###############################################################################
echo -e "${BOLD}${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BOLD}1. 📁 ESTRUCTURA DE DIRECTORIOS${NC}"
echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

REQUIRED_DIRS=(
    "/var/www/html/composables"
    "/var/www/html/css"
    "/var/www/html/js"
    "/var/www/html/assets"
    "/var/www/html/views"
    "/var/www/html/layout"
    "/var/www/html/layouts"
    "/var/www/html/node_modules"
)

for dir in "${REQUIRED_DIRS[@]}"; do
    if [ -d "$dir" ]; then
        echo -e "${GREEN}${CHECK} $dir${NC}"
    else
        echo -e "${RED}${CROSS} $dir - NO EXISTE${NC}"
    fi
done

echo ""

###############################################################################
# 2. VERIFICAR ARCHIVOS CRÍTICOS
###############################################################################
echo -e "${BOLD}${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BOLD}2. 📄 ARCHIVOS CRÍTICOS${NC}"
echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

REQUIRED_FILES=(
    "/var/www/html/index.php"
    "/var/www/html/.env"
    "/var/www/html/composables/config.js"
    "/var/www/html/composables/npm-loader.js"
    "/var/www/html/composables/router.js"
    "/var/www/html/composables/statusCheck.js"
    "/var/www/html/package.json"
    "/var/www/html/nginx.conf"
    "/var/www/html/docker-entrypoint.sh"
)

for file in "${REQUIRED_FILES[@]}"; do
    if [ -f "$file" ]; then
        size=$(du -h "$file" | cut -f1)
        echo -e "${GREEN}${CHECK} $file ${NC}(${size})"
    else
        echo -e "${RED}${CROSS} $file - NO EXISTE${NC}"
    fi
done

echo ""

###############################################################################
# 3. VERIFICAR PERMISOS
###############################################################################
echo -e "${BOLD}${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BOLD}3. 🔐 PERMISOS DE ARCHIVOS Y DIRECTORIOS${NC}"
echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

# Verificar .env (debe ser 600 o 640)
if [ -f "/var/www/html/.env" ]; then
    ENV_PERMS=$(stat -c '%a' /var/www/html/.env)
    if [ "$ENV_PERMS" = "600" ] || [ "$ENV_PERMS" = "640" ]; then
        echo -e "${GREEN}${CHECK} .env permisos: $ENV_PERMS ${NC}(correcto)"
    else
        echo -e "${YELLOW}${WARN} .env permisos: $ENV_PERMS ${NC}(recomendado: 600)"
    fi
else
    echo -e "${RED}${CROSS} .env no existe${NC}"
fi

# Verificar config.js (debe ser 644)
if [ -f "/var/www/html/composables/config.js" ]; then
    CONFIG_PERMS=$(stat -c '%a' /var/www/html/composables/config.js)
    if [ "$CONFIG_PERMS" = "644" ]; then
        echo -e "${GREEN}${CHECK} config.js permisos: $CONFIG_PERMS ${NC}(correcto)"
    else
        echo -e "${YELLOW}${WARN} config.js permisos: $CONFIG_PERMS ${NC}(recomendado: 644)"
    fi
else
    echo -e "${RED}${CROSS} config.js no existe${NC}"
fi

# Verificar directorios críticos (layout, layouts, utils, scripts)
PROTECTED_DIRS=("/var/www/html/layout" "/var/www/html/layouts" "/var/www/html/utils" "/var/www/html/scripts")
for dir in "${PROTECTED_DIRS[@]}"; do
    if [ -d "$dir" ]; then
        DIR_PERMS=$(stat -c '%a' "$dir")
        if [ "$DIR_PERMS" = "750" ]; then
            echo -e "${GREEN}${CHECK} $(basename $dir)/ permisos: $DIR_PERMS ${NC}(protegido)"
        else
            echo -e "${YELLOW}${WARN} $(basename $dir)/ permisos: $DIR_PERMS ${NC}(recomendado: 750)"
        fi
    fi
done

# Verificar owner
ROOT_OWNER=$(stat -c '%U:%G' /var/www/html)
if [ "$ROOT_OWNER" = "www-data:www-data" ]; then
    echo -e "${GREEN}${CHECK} Owner: $ROOT_OWNER ${NC}(correcto)"
else
    echo -e "${YELLOW}${WARN} Owner: $ROOT_OWNER ${NC}(recomendado: www-data:www-data)"
fi

echo ""

###############################################################################
# 4. VERIFICAR VARIABLES DE ENTORNO
###############################################################################
echo -e "${BOLD}${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BOLD}4. 🔧 VARIABLES DE ENTORNO${NC}"
echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

# Variables críticas
CRITICAL_VARS=("API_URL" "APP_NAME" "APP_ENV")

for var in "${CRITICAL_VARS[@]}"; do
    value="${!var}"
    if [ -n "$value" ]; then
        echo -e "${GREEN}${CHECK} $var=${NC}${value}"
    else
        # Intentar leer de .env
        if [ -f "/var/www/html/.env" ]; then
            env_value=$(grep "^$var=" /var/www/html/.env | cut -d'=' -f2)
            if [ -n "$env_value" ]; then
                echo -e "${YELLOW}${WARN} $var=${NC}${env_value} ${YELLOW}(solo en .env, no en ENV)${NC}"
            else
                echo -e "${RED}${CROSS} $var ${NC}no definida"
            fi
        else
            echo -e "${RED}${CROSS} $var ${NC}no definida"
        fi
    fi
done

echo ""

###############################################################################
# 5. VERIFICAR CONFIG.JS GENERADO
###############################################################################
echo -e "${BOLD}${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BOLD}5. ⚙️  CONFIG.JS GENERADO${NC}"
echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

if [ -f "/var/www/html/composables/config.js" ]; then
    echo -e "${GREEN}${CHECK} config.js existe${NC}"
    echo ""
    echo -e "${BLUE}Contenido:${NC}"
    cat /var/www/html/composables/config.js
    echo ""
    
    # Verificar si tiene variables definidas
    if grep -q "API_URL" /var/www/html/composables/config.js; then
        echo -e "${GREEN}${CHECK} config.js contiene variables${NC}"
    else
        echo -e "${YELLOW}${WARN} config.js está vacío o sin variables${NC}"
    fi
else
    echo -e "${RED}${CROSS} config.js NO EXISTE - Ejecutar: npm run build:config${NC}"
fi

echo ""

###############################################################################
# 6. VERIFICAR SERVICIOS (NGINX, PHP-FPM)
###############################################################################
echo -e "${BOLD}${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BOLD}6. 🚀 SERVICIOS${NC}"
echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

# Verificar Nginx
if pgrep nginx > /dev/null; then
    echo -e "${GREEN}${CHECK} Nginx está corriendo${NC}"
    nginx_version=$(nginx -v 2>&1 | cut -d'/' -f2)
    echo -e "   ${BLUE}Versión: nginx/${nginx_version}${NC}"
else
    echo -e "${RED}${CROSS} Nginx NO está corriendo${NC}"
fi

# Verificar PHP-FPM
if pgrep php-fpm > /dev/null; then
    echo -e "${GREEN}${CHECK} PHP-FPM está corriendo${NC}"
    php_version=$(php -v | head -n1 | cut -d' ' -f2)
    echo -e "   ${BLUE}Versión: PHP ${php_version}${NC}"
else
    echo -e "${RED}${CROSS} PHP-FPM NO está corriendo${NC}"
fi

# Verificar supervisord
if pgrep supervisord > /dev/null; then
    echo -e "${GREEN}${CHECK} Supervisord está corriendo${NC}"
else
    echo -e "${YELLOW}${WARN} Supervisord NO está corriendo (puede ser normal)${NC}"
fi

echo ""

###############################################################################
# 7. VERIFICAR NGINX CONFIGURATION
###############################################################################
echo -e "${BOLD}${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BOLD}7. 🌐 CONFIGURACIÓN DE NGINX${NC}"
echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

# Test de configuración
if nginx -t 2>/dev/null; then
    echo -e "${GREEN}${CHECK} Configuración de Nginx es válida${NC}"
else
    echo -e "${RED}${CROSS} Configuración de Nginx tiene errores${NC}"
    nginx -t
fi

# Verificar puerto escuchando
if netstat -tuln 2>/dev/null | grep -q ":3000"; then
    echo -e "${GREEN}${CHECK} Nginx escuchando en puerto 3000${NC}"
elif ss -tuln 2>/dev/null | grep -q ":3000"; then
    echo -e "${GREEN}${CHECK} Nginx escuchando en puerto 3000${NC}"
else
    echo -e "${YELLOW}${WARN} Puerto 3000 no parece estar escuchando${NC}"
fi

echo ""

###############################################################################
# 8. VERIFICAR DEPENDENCIAS NPM
###############################################################################
echo -e "${BOLD}${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BOLD}8. 📦 DEPENDENCIAS NPM${NC}"
echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

if [ -d "/var/www/html/node_modules" ]; then
    node_modules_count=$(find /var/www/html/node_modules -maxdepth 1 -type d | wc -l)
    echo -e "${GREEN}${CHECK} node_modules existe${NC} ($node_modules_count directorios)"
    
    # Verificar dependencias críticas
    CRITICAL_DEPS=("axios" "bootstrap" "jquery" "aframe" "chart.js")
    for dep in "${CRITICAL_DEPS[@]}"; do
        if [ -d "/var/www/html/node_modules/$dep" ]; then
            echo -e "${GREEN}${CHECK} $dep${NC}"
        else
            echo -e "${RED}${CROSS} $dep - NO INSTALADO${NC}"
        fi
    done
else
    echo -e "${RED}${CROSS} node_modules NO EXISTE - Ejecutar: npm install${NC}"
fi

echo ""

###############################################################################
# 9. VERIFICAR LOGS
###############################################################################
echo -e "${BOLD}${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BOLD}9. 📋 LOGS RECIENTES${NC}"
echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

# Nginx error log
if [ -f "/var/log/nginx/error.log" ]; then
    error_count=$(wc -l < /var/log/nginx/error.log 2>/dev/null || echo "0")
    echo -e "${BLUE}${INFO} Nginx error.log: ${error_count} líneas${NC}"
    if [ "$error_count" -gt 0 ]; then
        echo -e "${YELLOW}Últimas 5 líneas:${NC}"
        tail -5 /var/log/nginx/error.log 2>/dev/null || echo "No se puede leer el log"
    fi
else
    echo -e "${YELLOW}${WARN} /var/log/nginx/error.log no existe${NC}"
fi

echo ""

# Supervisord log
if [ -f "/var/www/html/supervisord.log" ]; then
    log_size=$(du -h /var/www/html/supervisord.log | cut -f1)
    echo -e "${BLUE}${INFO} supervisord.log: ${log_size}${NC}"
    echo -e "${YELLOW}Últimas 10 líneas:${NC}"
    tail -10 /var/www/html/supervisord.log
else
    echo -e "${YELLOW}${WARN} supervisord.log no existe${NC}"
fi

echo ""

###############################################################################
# 10. RESUMEN Y RECOMENDACIONES
###############################################################################
echo -e "${BOLD}${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BOLD}10. 📊 RESUMEN Y RECOMENDACIONES${NC}"
echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

echo ""
echo -e "${BOLD}${GREEN}Estado general del deployment:${NC}"
echo ""

# Contador de checks
total_checks=0
passed_checks=0

# Check 1: Servicios
if pgrep nginx > /dev/null && pgrep php-fpm > /dev/null; then
    echo -e "${GREEN}${CHECK} Servicios críticos funcionando${NC}"
    ((passed_checks++))
else
    echo -e "${RED}${CROSS} Servicios no están corriendo completamente${NC}"
fi
((total_checks++))

# Check 2: Config.js
if [ -f "/var/www/html/composables/config.js" ] && grep -q "API_URL" /var/www/html/composables/config.js; then
    echo -e "${GREEN}${CHECK} config.js generado correctamente${NC}"
    ((passed_checks++))
else
    echo -e "${RED}${CROSS} config.js no está correctamente generado${NC}"
    echo -e "   ${YELLOW}Solución: npm run build:config${NC}"
fi
((total_checks++))

# Check 3: Permisos
if [ -f "/var/www/html/.env" ]; then
    ENV_PERMS=$(stat -c '%a' /var/www/html/.env)
    if [ "$ENV_PERMS" = "600" ] || [ "$ENV_PERMS" = "640" ]; then
        echo -e "${GREEN}${CHECK} Permisos de seguridad correctos${NC}"
        ((passed_checks++))
    else
        echo -e "${YELLOW}${WARN} Permisos necesitan ajuste${NC}"
    fi
else
    echo -e "${RED}${CROSS} .env no existe${NC}"
fi
((total_checks++))

# Check 4: Dependencias
if [ -d "/var/www/html/node_modules/axios" ]; then
    echo -e "${GREEN}${CHECK} Dependencias NPM instaladas${NC}"
    ((passed_checks++))
else
    echo -e "${RED}${CROSS} Dependencias NPM faltantes${NC}"
    echo -e "   ${YELLOW}Solución: npm install${NC}"
fi
((total_checks++))

echo ""
echo -e "${BOLD}Resultado: ${passed_checks}/${total_checks} checks pasados${NC}"

if [ "$passed_checks" -eq "$total_checks" ]; then
    echo -e "${GREEN}${ROCKET} ${BOLD}DEPLOYMENT EN ÓPTIMAS CONDICIONES${NC}"
elif [ "$passed_checks" -ge $((total_checks - 1)) ]; then
    echo -e "${YELLOW}${WARN} ${BOLD}DEPLOYMENT FUNCIONAL CON ADVERTENCIAS MENORES${NC}"
else
    echo -e "${RED}${CROSS} ${BOLD}DEPLOYMENT REQUIERE ATENCIÓN${NC}"
fi

echo ""
echo -e "${BOLD}${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BLUE}${INFO} Fin del diagnóstico - $(date '+%Y-%m-%d %H:%M:%S')${NC}"
echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""
