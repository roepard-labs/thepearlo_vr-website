<?php
/**
 * Reader.php - API para leer aplicaciones del AppStore
 * HomeLab AR - Roepard Labs
 */

// Headers para JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

// ===================================
// FUNCIONES HELPER
// ===================================

/**
 * Lee el archivo apps.json
 */
function getAppsData() {
    $jsonPath = __DIR__ . '/apps.json';
    
    if (!file_exists($jsonPath)) {
        return [
            'success' => false,
            'error' => 'Apps data not found'
        ];
    }
    
    $jsonContent = file_get_contents($jsonPath);
    $data = json_decode($jsonContent, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        return [
            'success' => false,
            'error' => 'Invalid JSON format'
        ];
    }
    
    return [
        'success' => true,
        'data' => $data
    ];
}

/**
 * Filtra apps por criterios
 */
function filterApps($apps, $filters) {
    $filtered = $apps;
    
    // Filtrar por categoría
    if (isset($filters['category']) && $filters['category'] !== '') {
        $filtered = array_filter($filtered, function($app) use ($filters) {
            return $app['category'] === $filters['category'];
        });
    }
    
    // Filtrar por featured
    if (isset($filters['featured']) && $filters['featured'] === 'true') {
        $filtered = array_filter($filtered, function($app) {
            return $app['featured'] === true;
        });
    }
    
    // Filtrar por active
    if (isset($filters['active'])) {
        $active = $filters['active'] === 'true';
        $filtered = array_filter($filtered, function($app) use ($active) {
            return $app['active'] === $active;
        });
    }
    
    // Buscar por query
    if (isset($filters['search']) && $filters['search'] !== '') {
        $search = strtolower($filters['search']);
        $filtered = array_filter($filtered, function($app) use ($search) {
            $searchIn = strtolower($app['name'] . ' ' . $app['description']);
            return strpos($searchIn, $search) !== false;
        });
    }
    
    return array_values($filtered);
}

/**
 * Ordena apps
 */
function sortApps($apps, $sortBy, $order = 'desc') {
    usort($apps, function($a, $b) use ($sortBy, $order) {
        $valA = $a[$sortBy] ?? 0;
        $valB = $b[$sortBy] ?? 0;
        
        if ($order === 'asc') {
            return $valA <=> $valB;
        } else {
            return $valB <=> $valA;
        }
    });
    
    return $apps;
}

/**
 * Pagina resultados
 */
function paginateApps($apps, $page, $perPage) {
    $total = count($apps);
    $totalPages = ceil($total / $perPage);
    $offset = ($page - 1) * $perPage;
    
    $paginated = array_slice($apps, $offset, $perPage);
    
    return [
        'apps' => array_values($paginated),
        'pagination' => [
            'current_page' => $page,
            'per_page' => $perPage,
            'total_items' => $total,
            'total_pages' => $totalPages,
            'has_next' => $page < $totalPages,
            'has_prev' => $page > 1
        ]
    ];
}

// ===================================
// ENDPOINTS
// ===================================

$action = $_GET['action'] ?? 'list';

switch ($action) {
    
    // ===================================
    // LISTAR APPS
    // ===================================
    case 'list':
        $result = getAppsData();
        
        if (!$result['success']) {
            http_response_code(500);
            echo json_encode($result);
            exit;
        }
        
        $apps = $result['data']['apps'];
        
        // Aplicar filtros
        $filters = [
            'category' => $_GET['category'] ?? null,
            'featured' => $_GET['featured'] ?? null,
            'active' => $_GET['active'] ?? 'true',
            'search' => $_GET['search'] ?? null
        ];
        
        $apps = filterApps($apps, $filters);
        
        // Ordenar
        $sortBy = $_GET['sort_by'] ?? 'downloads';
        $order = $_GET['order'] ?? 'desc';
        $apps = sortApps($apps, $sortBy, $order);
        
        // Paginar
        $page = (int)($_GET['page'] ?? 1);
        $perPage = (int)($_GET['per_page'] ?? 12);
        $paginated = paginateApps($apps, $page, $perPage);
        
        echo json_encode([
            'success' => true,
            'apps' => $paginated['apps'],
            'pagination' => $paginated['pagination'],
            'filters' => $filters
        ], JSON_PRETTY_PRINT);
        break;
    
    // ===================================
    // OBTENER APP POR ID
    // ===================================
    case 'get':
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'App ID is required'
            ]);
            exit;
        }
        
        $result = getAppsData();
        
        if (!$result['success']) {
            http_response_code(500);
            echo json_encode($result);
            exit;
        }
        
        $apps = $result['data']['apps'];
        $app = null;
        
        foreach ($apps as $item) {
            if ($item['id'] === $id) {
                $app = $item;
                break;
            }
        }
        
        if (!$app) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'App not found'
            ]);
            exit;
        }
        
        echo json_encode([
            'success' => true,
            'app' => $app
        ], JSON_PRETTY_PRINT);
        break;
    
    // ===================================
    // OBTENER CATEGORÍAS
    // ===================================
    case 'categories':
        $result = getAppsData();
        
        if (!$result['success']) {
            http_response_code(500);
            echo json_encode($result);
            exit;
        }
        
        echo json_encode([
            'success' => true,
            'categories' => $result['data']['categories']
        ], JSON_PRETTY_PRINT);
        break;
    
    // ===================================
    // OBTENER APPS DESTACADAS
    // ===================================
    case 'featured':
        $result = getAppsData();
        
        if (!$result['success']) {
            http_response_code(500);
            echo json_encode($result);
            exit;
        }
        
        $apps = $result['data']['apps'];
        $featured = array_filter($apps, function($app) {
            return $app['featured'] === true && $app['active'] === true;
        });
        
        echo json_encode([
            'success' => true,
            'apps' => array_values($featured)
        ], JSON_PRETTY_PRINT);
        break;
    
    // ===================================
    // OBTENER ESTADÍSTICAS
    // ===================================
    case 'stats':
        $result = getAppsData();
        
        if (!$result['success']) {
            http_response_code(500);
            echo json_encode($result);
            exit;
        }
        
        $apps = $result['data']['apps'];
        $totalDownloads = array_sum(array_column($apps, 'downloads'));
        $avgRating = array_sum(array_column($apps, 'rating')) / count($apps);
        
        echo json_encode([
            'success' => true,
            'stats' => [
                'total_apps' => count($apps),
                'total_downloads' => $totalDownloads,
                'average_rating' => round($avgRating, 2),
                'categories' => count($result['data']['categories'])
            ]
        ], JSON_PRETTY_PRINT);
        break;
    
    // ===================================
    // ACTION NO VÁLIDA
    // ===================================
    default:
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'Invalid action'
        ]);
        break;
}
