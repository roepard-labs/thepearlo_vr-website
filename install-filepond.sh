!/bin/bash

#######################################################
# FilePond Files Manager - Script de Instalación
# HomeLab AR - Roepard Labs
# Versión: 1.0
#######################################################

set -e  # Salir si hay errores

echo "🚀 Instalando FilePond Files Manager..."
echo "========================================"
echo ""

# Colores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Variables
FRONTEND_DIR="thepearlo_vr-website"
BACKEND_DIR="thepearlo_vr-backend"
DB_NAME="homelab"
DB_USER="root"

# Paso 1: Verificar directorios
echo -e "${BLUE}📂 Verificando directorios...${NC}"
if [ ! -d "$FRONTEND_DIR" ]; then
    echo -e "${RED}❌ Error: No se encuentra el directorio $FRONTEND_DIR${NC}"
    exit 1
fi
if [ ! -d "$BACKEND_DIR" ]; then
    echo -e "${RED}❌ Error: No se encuentra el directorio $BACKEND_DIR${NC}"
    exit 1
fi
echo -e "${GREEN}✅ Directorios encontrados${NC}"
echo ""

# Paso 2: Instalar dependencias NPM
echo -e "${BLUE}📦 Instalando dependencias NPM (FilePond + 15 plugins)...${NC}"
cd "$FRONTEND_DIR"

if ! npm install; then
    echo -e "${RED}❌ Error instalando dependencias NPM${NC}"
    exit 1
fi

echo -e "${GREEN}✅ Dependencias instaladas${NC}"
echo ""

# Paso 3: Regenerar configuración
echo -e "${BLUE}⚙️ Regenerando configuración...${NC}"
npm run build:config
echo -e "${GREEN}✅ Configuración regenerada${NC}"
echo ""

# Paso 4: Crear estructura de storage
echo -e "${BLUE}📁 Creando estructura de storage...${NC}"
cd ../"$BACKEND_DIR"

mkdir -p storage/app/private
chmod 775 storage/app/private

# Crear directorios para usuarios de prueba
for user_id in {1..4}; do
    mkdir -p storage/app/private/user_$user_id
    chmod 775 storage/app/private/user_$user_id
    echo -e "${GREEN}✅ Creado: storage/app/private/user_$user_id${NC}"
done
echo ""

# Paso 5: Base de datos
echo -e "${BLUE}🗄️ Configurando base de datos...${NC}"
cd ..

SQL_FILE=".github/instructions/files_tables.sql"

if [ ! -f "$SQL_FILE" ]; then
    echo -e "${RED}❌ Error: No se encuentra $SQL_FILE${NC}"
    exit 1
fi

echo -e "${YELLOW}⚠️ Ingresa la contraseña de MySQL para crear las tablas:${NC}"
mysql -u "$DB_USER" -p "$DB_NAME" < "$SQL_FILE"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Tablas de archivos creadas correctamente${NC}"
else
    echo -e "${RED}❌ Error creando tablas en la base de datos${NC}"
    exit 1
fi
echo ""

# Paso 6: Verificar PHP limits
echo -e "${BLUE}⚙️ Verificando configuración de PHP...${NC}"

PHP_INI=$(php --ini | grep "Loaded Configuration File" | awk '{print $4}')
echo "📄 Archivo php.ini: $PHP_INI"
echo ""

UPLOAD_MAX=$(php -r "echo ini_get('upload_max_filesize');")
POST_MAX=$(php -r "echo ini_get('post_max_size');")
MAX_UPLOADS=$(php -r "echo ini_get('max_file_uploads');")

echo "upload_max_filesize = $UPLOAD_MAX"
echo "post_max_size = $POST_MAX"
echo "max_file_uploads = $MAX_UPLOADS"
echo ""

if [ "$UPLOAD_MAX" != "50M" ] || [ "$POST_MAX" != "50M" ]; then
    echo -e "${YELLOW}⚠️ RECOMENDACIÓN: Editar php.ini con estos valores:${NC}"
    echo ""
    echo "upload_max_filesize = 50M"
    echo "post_max_size = 50M"
    echo "max_file_uploads = 20"
    echo ""
    echo -e "${YELLOW}Ubicación: $PHP_INI${NC}"
    echo ""
    read -p "¿Quieres que el script lo haga automáticamente? (requiere sudo) [y/N]: " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        echo -e "${BLUE}Actualizando php.ini...${NC}"
        sudo sed -i 's/upload_max_filesize = .*/upload_max_filesize = 50M/' "$PHP_INI"
        sudo sed -i 's/post_max_size = .*/post_max_size = 50M/' "$PHP_INI"
        sudo sed -i 's/max_file_uploads = .*/max_file_uploads = 20/' "$PHP_INI"
        echo -e "${GREEN}✅ php.ini actualizado${NC}"
    fi
fi
echo ""

# Paso 7: Testing de conectividad
echo -e "${BLUE}🧪 Verificando conectividad backend...${NC}"

cd "$BACKEND_DIR"

# Verificar si hay un proceso PHP corriendo en 3000
if lsof -Pi :3000 -sTCP:LISTEN -t >/dev/null ; then
    echo -e "${GREEN}✅ Backend corriendo en puerto 3000${NC}"
else
    echo -e "${YELLOW}⚠️ Backend NO está corriendo${NC}"
    echo -e "${BLUE}Para iniciar el backend ejecuta:${NC}"
    echo "  cd $BACKEND_DIR"
    echo "  php -S localhost:3000"
fi
echo ""

cd ..

# Verificar frontend
cd "$FRONTEND_DIR"

if lsof -Pi :9000 -sTCP:LISTEN -t >/dev/null ; then
    echo -e "${GREEN}✅ Frontend corriendo en puerto 9000${NC}"
else
    echo -e "${YELLOW}⚠️ Frontend NO está corriendo${NC}"
    echo -e "${BLUE}Para iniciar el frontend ejecuta:${NC}"
    echo "  cd $FRONTEND_DIR"
    echo "  php -S localhost:9000 router.php"
fi
echo ""

cd ..

# Paso 8: Resumen final
echo ""
echo "========================================"
echo -e "${GREEN}✅ INSTALACIÓN COMPLETADA${NC}"
echo "========================================"
echo ""
echo -e "${BLUE}📋 Siguiente paso:${NC}"
echo ""
echo "1. Iniciar backend (si no está corriendo):"
echo "   cd $BACKEND_DIR"
echo "   php -S localhost:3000"
echo ""
echo "2. Iniciar frontend (si no está corriendo):"
echo "   cd $FRONTEND_DIR"
echo "   php -S localhost:9000 router.php"
echo ""
echo "3. Acceder a Files Manager:"
echo "   http://localhost:9000/files"
echo ""
echo -e "${YELLOW}⚠️ IMPORTANTE: Debes estar autenticado para acceder${NC}"
echo ""
echo -e "${BLUE}📚 Documentación:${NC}"
echo "   - Guía completa: docs/FILEPOND-INTEGRATION.md"
echo "   - Backend: docs/FILES-BACKEND-FULL-STACK-GUIDE.md"
echo "   - Quick Start: docs/FILES-QUICK-START.md"
echo ""
echo -e "${GREEN}🎉 ¡Listo para subir archivos con FilePond!${NC}"
echo ""

# Paso 9: Testing rápido (opcional)
read -p "¿Quieres ejecutar un test rápido de la API? [y/N]: " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo ""
    echo -e "${BLUE}🧪 Ejecutando test de API...${NC}"
    echo ""
    
    # Test 1: Check session endpoint
    echo "Test 1: Verificar endpoint de sesión..."
    RESPONSE=$(curl -s -w "\n%{http_code}" http://localhost:3000/routes/user/check_session.php)
    HTTP_CODE=$(echo "$RESPONSE" | tail -n1)
    
    if [ "$HTTP_CODE" = "200" ]; then
        echo -e "${GREEN}✅ Endpoint de sesión funciona (HTTP $HTTP_CODE)${NC}"
    else
        echo -e "${YELLOW}⚠️ Endpoint retornó HTTP $HTTP_CODE (esperado si no hay sesión activa)${NC}"
    fi
    echo ""
    
    # Test 2: List files endpoint
    echo "Test 2: Verificar endpoint de listado de archivos..."
    RESPONSE=$(curl -s -w "\n%{http_code}" http://localhost:3000/routes/files/list_files.php)
    HTTP_CODE=$(echo "$RESPONSE" | tail -n1)
    
    if [ "$HTTP_CODE" = "200" ] || [ "$HTTP_CODE" = "401" ]; then
        echo -e "${GREEN}✅ Endpoint de archivos funciona (HTTP $HTTP_CODE)${NC}"
    else
        echo -e "${RED}❌ Error en endpoint de archivos (HTTP $HTTP_CODE)${NC}"
    fi
    echo ""
    
    echo -e "${BLUE}✅ Tests completados${NC}"
    echo ""
fi

echo -e "${GREEN}🚀 ¡Instalación exitosa!${NC}"
echo ""
