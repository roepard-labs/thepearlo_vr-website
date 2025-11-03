<?php
/**
 * Router para servidor PHP integrado
 * Sirve archivos estáticos y rutas dinámicas
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$file = __DIR__ . $uri;

// Si es un archivo estático que existe, servirlo
if ($uri !== '/' && file_exists($file)) {
    // Determinar el tipo MIME
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'eot' => 'application/vnd.ms-fontobject',
        'otf' => 'font/otf'
    ];
    
    $contentType = $mimeTypes[$ext] ?? 'application/octet-stream';
    
    header('Content-Type: ' . $contentType);
    header('Content-Length: ' . filesize($file));
    readfile($file);
    return true;
}

// Si es la raíz o un archivo PHP, incluir index.php
if ($uri === '/' || !file_exists($file)) {
    require __DIR__ . '/index.php';
    return true;
}

// Si llegamos aquí, devolver 404
http_response_code(404);
echo '404 Not Found';
return false;
