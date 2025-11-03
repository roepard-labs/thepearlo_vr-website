<?php
/**
 * Index.php - Punto de entrada principal
 * HomeLab AR - Roepard Labs
 * 
 * Este archivo usa la arquitectura funcional con AppLayout
 * para renderizar la vista home con todas las secciones.
 */

// Activar reporte de errores para debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión
session_start();

// Incluir el layout principal
require_once __DIR__ . '/layout/AppLayout.php';

// ===================================
// CONFIGURACIÓN DE LA PÁGINA
// ===================================
$pageConfig = [
    'title' => 'HomeLab AR - Realidad Aumentada para tu HomeLab | Roepard Labs',
    'description' => 'Visualiza y controla tu infraestructura HomeLab en realidad aumentada con tecnología WebXR. Monitoreo en tiempo real, gestión de apps y servicios.',
    'keywords' => 'homelab, realidad aumentada, ar, webxr, infraestructura, dashboard, monitoreo, servidores',
    'author' => 'Roepard Labs',
    'og_image' => '/assets/images/og-homelab-ar.jpeg',
    'og_type' => 'website',
    'canonical' => 'https://website.roepard.online/',
    
    // CSS adicionales específicos para home
    'css' => [],
    
    // JavaScript adicionales
    'js' => [
        'js/main.js',      // Inicialización principal (AOS, theme toggle, etc)
        'js/auth.js',      // Sistema de autenticación
        'js/utils.js'      // Funciones utilitarias
    ]
];

// ===================================
// DATOS PARA LA VISTA
// ===================================
$pageData = [
    // Usuario actual (si está autenticado)
    'user' => $_SESSION['user'] ?? null,
    
    // Estadísticas para la sección stats
    'stats' => [
        [
            'icon' => 'bx-server',
            'number' => '12',
            'label' => 'Servidores Activos'
        ],
        [
            'icon' => 'bxl-docker',
            'number' => '87',
            'label' => 'Contenedores'
        ],
        [
            'icon' => 'bx-data',
            'number' => '45',
            'label' => 'Servicios'
        ],
        [
            'icon' => 'bx-trending-up',
            'number' => '99.9%',
            'label' => 'Uptime'
        ]
    ],
    
    // Características para la sección features
    'features' => [
        [
            'icon' => 'bx-cube-alt',
            'title' => 'Visualización AR',
            'description' => 'Visualiza tu infraestructura en realidad aumentada con WebXR'
        ],
        [
            'icon' => 'bx-time-five',
            'title' => 'Tiempo Real',
            'description' => 'Monitoreo en tiempo real de tus servicios y recursos'
        ],
        [
            'icon' => 'bx-shield-alt-2',
            'title' => 'Seguro',
            'description' => 'Autenticación robusta y cifrado de extremo a extremo'
        ],
        [
            'icon' => 'bx-mobile',
            'title' => 'Multiplataforma',
            'description' => 'Funciona en desktop, móvil y dispositivos AR/VR'
        ]
    ]
];

// ===================================
// RENDERIZAR LA VISTA HOME
// ===================================
AppLayout::render('home', $pageData, $pageConfig);