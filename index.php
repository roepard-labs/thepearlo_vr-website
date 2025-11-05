<?php
/**
 * Index.php - Router Principal
 * HomeLab AR - Roepard Labs
 * 
 * Sistema de routing con URLs limpias:
 * / -> home.view.php
 * /features -> features.view.php
 * /privacy -> privacy.view.php
 * /terms -> terms.view.php
 * /admin/* -> admin.dashboard.view.php
 * /user/* -> user.dashboard.view.php
 */

// Activar reporte de errores para debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión
session_start();

// Incluir el layout principal
require_once __DIR__ . '/layout/AppLayout.php';

// ===================================
// SISTEMA DE ROUTING
// ===================================

// Obtener la URI limpia (sin query string)
$request_uri = $_SERVER['REQUEST_URI'];
$uri = strtok($request_uri, '?'); // Remover query string
$uri = rtrim($uri, '/'); // Remover trailing slash
$uri = $uri ?: '/'; // Si está vacío, es la raíz

// Definir rutas y sus vistas correspondientes
$routes = [
    '/' => 'home.view.php',
    '/home' => 'home.view.php',
    '/features' => 'features.view.php',
    '/privacy' => 'privacy.view.php',
    '/terms' => 'terms.view.php',
    '/dashboard' => 'dashboard.view.php',
    // Dashboard pages - renderizadas dentro de dashboard.view.php
    '/dashboard/users' => 'dashboard.view.php',
    '/dashboard/settings' => 'dashboard.view.php',
    '/dashboard/profile' => 'dashboard.view.php',
    '/dashboard/files' => 'dashboard.view.php'
];

// NOTA: No verificamos autenticación aquí porque frontend PHP no puede leer
// las sesiones del backend (puertos diferentes: 9000 vs 3000)
// La autenticación se verifica con JavaScript en cada vista protegida

// Buscar la ruta exacta
if (isset($routes[$uri])) {
    $view_file = __DIR__ . '/views/' . $routes[$uri];

    // Verificar que el archivo existe
    if (file_exists($view_file)) {
        require_once $view_file;
        exit;
    }
}

// Si no se encuentra la ruta, retornar 404
// Nginx manejará esto y mostrará 40x.php
http_response_code(404);
exit;