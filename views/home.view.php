<?php
/**
 * Vista: Home
 * Página principal del sitio con secciones animadas
 * HomeLab AR - Roepard Labs
 */

require_once __DIR__ . '/../layout/AppLayout.php';

// Configuración de la página
$pageConfig = [
    'title' => 'HomeLab AR - Realidad Aumentada para tu HomeLab | Roepard Labs',
    'description' => 'Visualiza y controla tu infraestructura HomeLab en realidad aumentada con tecnología WebXR. Monitoreo en tiempo real, gestión de apps y servicios.',
    'keywords' => 'homelab, realidad aumentada, ar, webxr, infraestructura, dashboard, monitoreo, servidores',
    'css' => [],
    'js' => ['js/main.js', 'js/auth.js', 'js/utils.js']
];

// Capturar todo el contenido de las secciones
ob_start();

// Incluir secciones
include __DIR__ . '/../sections/hero.section.php';
include __DIR__ . '/../sections/features.section.php';
include __DIR__ . '/../sections/stats.section.php';
include __DIR__ . '/../sections/about.section.php';
include __DIR__ . '/../sections/contact.section.php';

$content = ob_get_clean();

// Renderizar con AppLayout
AppLayout::render('home', ['content' => $content], $pageConfig);