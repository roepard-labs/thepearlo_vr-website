#!/bin/bash
# security-check.sh - Script de verificación de seguridad para HomeLab Frontend

# Colores para output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Contador de tests
TOTAL=0
PASSED=0
FAILED=0

# Función para test
test_endpoint() {
    local url=$1
    local expected_code=$2
    local description=$3
    
    TOTAL=$((TOTAL + 1))
    
    # Hacer request
    response=$(curl -s -o /dev/null -w "%{http_code}" "$url")
    
    if [ "$response" -eq "$expected_code" ]; then
        echo -e "${GREEN}✅ PASS${NC} - $description"
        echo -e "   URL: $url"
        echo -e "   Expected: $expected_code, Got: $response"
        PASSED=$((PASSED + 1))
    else
        echo -e "${RED}❌ FAIL${NC} - $description"
        echo -e "   URL: $url"
        echo -e "   Expected: $expected_code, Got: $response"
        FAILED=$((FAILED + 1))
    fi
    echo ""
}

# Banner
echo "═══════════════════════════════════════════════════════════"
echo "  🔒 HomeLab Frontend - Security Verification"
echo "═══════════════════════════════════════════════════════════"
echo ""

# Verificar si se pasó la URL
if [ -z "$1" ]; then
    echo -e "${YELLOW}⚠️  Uso: $0 <base-url>${NC}"
    echo -e "${YELLOW}    Ejemplo: $0 https://homelab.roepard.online${NC}"
    exit 1
fi

BASE_URL=$1
echo "🌐 Testing: $BASE_URL"
echo ""

# ═══════════════════════════════════════════════════════════
# TESTS DE SEGURIDAD
# ═══════════════════════════════════════════════════════════

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  📁 ARCHIVOS SENSIBLES (deben retornar 404)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
test_endpoint "$BASE_URL/.env" 404 "Bloquear .env"
test_endpoint "$BASE_URL/.env.local" 404 "Bloquear .env.local"
test_endpoint "$BASE_URL/.git/config" 404 "Bloquear .git/config"
test_endpoint "$BASE_URL/.gitignore" 404 "Bloquear .gitignore"
test_endpoint "$BASE_URL/.dockerignore" 404 "Bloquear .dockerignore"
test_endpoint "$BASE_URL/.htaccess" 404 "Bloquear .htaccess"

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  🔧 ARCHIVOS DE CONFIGURACIÓN (deben retornar 404)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
test_endpoint "$BASE_URL/js/config.js" 404 "Bloquear config.js"
test_endpoint "$BASE_URL/package.json" 404 "Bloquear package.json"
test_endpoint "$BASE_URL/package-lock.json" 404 "Bloquear package-lock.json"
test_endpoint "$BASE_URL/composer.json" 404 "Bloquear composer.json (si existe)"
test_endpoint "$BASE_URL/Dockerfile" 404 "Bloquear Dockerfile"
test_endpoint "$BASE_URL/docker-compose.yml" 404 "Bloquear docker-compose.yml"

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  📂 DIRECTORIOS PROTEGIDOS (deben retornar 404)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
test_endpoint "$BASE_URL/layout/AppLayout.php" 404 "Bloquear /layout/"
test_endpoint "$BASE_URL/layouts/AdminLayout.php" 404 "Bloquear /layouts/"
test_endpoint "$BASE_URL/utils/helpers.php" 404 "Bloquear /utils/ (si existe)"
test_endpoint "$BASE_URL/scripts/generate-config.js" 404 "Bloquear /scripts/"
test_endpoint "$BASE_URL/pages/index.php" 404 "Bloquear /pages/ (si existe)"
test_endpoint "$BASE_URL/node_modules/jquery/package.json" 404 "Bloquear /node_modules/"

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  🚫 EXTENSIONES PELIGROSAS (deben retornar 404)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
test_endpoint "$BASE_URL/config.ini" 404 "Bloquear *.ini"
test_endpoint "$BASE_URL/error.log" 404 "Bloquear *.log"
test_endpoint "$BASE_URL/database.sql" 404 "Bloquear *.sql"
test_endpoint "$BASE_URL/backup.bak" 404 "Bloquear *.bak"
test_endpoint "$BASE_URL/test.yml" 404 "Bloquear *.yml"
test_endpoint "$BASE_URL/script.sh" 404 "Bloquear *.sh"

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  ✅ ARCHIVOS PÚBLICOS (deben retornar 200)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
test_endpoint "$BASE_URL/" 200 "Home page accesible"
test_endpoint "$BASE_URL/index.php" 200 "index.php accesible"
test_endpoint "$BASE_URL/css/main.css" 200 "CSS accesible (si existe)"
test_endpoint "$BASE_URL/js/main.js" 200 "JS accesible (si existe)"

# ═══════════════════════════════════════════════════════════
# RESUMEN
# ═══════════════════════════════════════════════════════════

echo "═══════════════════════════════════════════════════════════"
echo "  📊 RESUMEN DE TESTS"
echo "═══════════════════════════════════════════════════════════"
echo ""
echo "Total Tests:  $TOTAL"
echo -e "${GREEN}Passed:       $PASSED${NC}"
echo -e "${RED}Failed:       $FAILED${NC}"
echo ""

# Calcular porcentaje
if [ $TOTAL -gt 0 ]; then
    percentage=$((PASSED * 100 / TOTAL))
    echo "Success Rate: $percentage%"
    echo ""
    
    if [ $FAILED -eq 0 ]; then
        echo -e "${GREEN}🎉 ¡Todos los tests de seguridad pasaron!${NC}"
        exit 0
    else
        echo -e "${RED}⚠️  Algunos tests fallaron. Revisa la configuración de seguridad.${NC}"
        exit 1
    fi
else
    echo -e "${YELLOW}⚠️  No se ejecutaron tests${NC}"
    exit 1
fi
