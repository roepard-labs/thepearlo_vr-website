<?php
/**
 * Página: Registro de Cambios (Changes)
 * Sistema de visualización de commits y releases de GitHub
 * HomeLab AR - Roepard Labs
 */

// NOTA: Esta página se carga dentro de dashboard.view.php
// No necesita verificación de autenticación porque dashboard.view.php ya la hace
?>

<!-- Header de la página -->
<div class="row mb-4">
    <div class="col-12">
        <div class="changes-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-2">
                    <i class="bx bx-git-branch me-2"></i>
                    Registro de Cambios
                </h1>
                <p class="text-muted mb-0">
                    Historial de commits y releases de los repositorios de HomeLab AR
                </p>
            </div>
            <div>
                <button class="btn" id="refreshChangesBtn">
                    <i class="bx bx-refresh me-1"></i>
                    Actualizar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Tabs de navegación: Commits / Releases -->
<div class="row mb-4">
    <div class="col-12">
        <ul class="nav nav-tabs" id="changesTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="commits-tab" data-bs-toggle="tab" data-bs-target="#commits-content"
                    type="button" role="tab" aria-controls="commits-content" aria-selected="true">
                    <i class="bx bx-git-commit me-1"></i>
                    Commits
                    <span class="badge bg-primary ms-2" id="commits-count">0</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="releases-tab" data-bs-toggle="tab" data-bs-target="#releases-content"
                    type="button" role="tab" aria-controls="releases-content" aria-selected="false">
                    <i class="bx bx-purchase-tag me-1"></i>
                    Releases
                    <span class="badge bg-success ms-2" id="releases-count">0</span>
                </button>
            </li>
        </ul>
    </div>
</div>

<!-- Contenido de los tabs -->
<div class="tab-content" id="changesTabContent">

    <!-- Tab: Commits -->
    <div class="tab-pane fade show active" id="commits-content" role="tabpanel" aria-labelledby="commits-tab">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bx bx-git-commit me-2"></i>
                        Historial de Commits
                    </h5>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="repoFilterCommits" id="filterAllCommits" value="all"
                            autocomplete="off" checked>
                        <label class="btn btn-outline-primary btn-sm" for="filterAllCommits">Todos</label>

                        <input type="radio" class="btn-check" name="repoFilterCommits" id="filterFrontendCommits"
                            value="frontend" autocomplete="off">
                        <label class="btn btn-outline-primary btn-sm" for="filterFrontendCommits">Frontend</label>

                        <input type="radio" class="btn-check" name="repoFilterCommits" id="filterBackendCommits"
                            value="backend" autocomplete="off">
                        <label class="btn btn-outline-primary btn-sm" for="filterBackendCommits">Backend</label>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="commitsTable" class="table table-hover table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>Commit</th>
                                <th>Mensaje</th>
                                <th>Autor</th>
                                <th>Repositorio</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTables llenará esta tabla -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab: Releases -->
    <div class="tab-pane fade" id="releases-content" role="tabpanel" aria-labelledby="releases-tab">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bx bx-purchase-tag me-2"></i>
                        Historial de Releases
                    </h5>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="repoFilterReleases" id="filterAllReleases"
                            value="all" autocomplete="off" checked>
                        <label class="btn btn-outline-success btn-sm" for="filterAllReleases">Todos</label>

                        <input type="radio" class="btn-check" name="repoFilterReleases" id="filterFrontendReleases"
                            value="frontend" autocomplete="off">
                        <label class="btn btn-outline-success btn-sm" for="filterFrontendReleases">Frontend</label>

                        <input type="radio" class="btn-check" name="repoFilterReleases" id="filterBackendReleases"
                            value="backend" autocomplete="off">
                        <label class="btn btn-outline-success btn-sm" for="filterBackendReleases">Backend</label>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="releasesTable" class="table table-hover table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tag</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Autor</th>
                                <th>Repositorio</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTables llenará esta tabla -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    /* ===================================
       CHANGES PAGE STYLES - MODERNIZADO
       Usa variables de variables.css
    =================================== */

    /* Header mejorado con gradiente sutil */
    .changes-header {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.05) 0%, rgba(102, 16, 242, 0.05) 100%);
        border-radius: var(--radius-lg);
        padding: var(--spacing-xl);
        margin-bottom: var(--spacing-xl);
        border: 1px solid rgba(13, 110, 253, 0.1);
    }

    .changes-header h1 {
        background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
    }

    /* Botón de actualizar mejorado */
    #refreshChangesBtn {
        background: linear-gradient(135deg, var(--bs-primary) 0%, #6610f2 100%);
        border: none;
        color: white;
        padding: var(--spacing-sm) var(--spacing-lg);
        border-radius: var(--radius-md);
        font-weight: 600;
        transition: all var(--transition-base);
        box-shadow: var(--shadow-md);
    }

    #refreshChangesBtn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* Tabs modernos con efectos mejorados */
    .nav-tabs {
        border-bottom: 2px solid var(--bs-border-color);
        margin-bottom: var(--spacing-xl);
    }

    .nav-tabs .nav-link {
        color: var(--bs-body-color);
        border: none;
        border-bottom: 3px solid transparent;
        padding: var(--spacing-md) var(--spacing-xl);
        font-weight: 600;
        transition: all var(--transition-base);
        position: relative;
        overflow: hidden;
    }

    .nav-tabs .nav-link::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 3px;
        background: linear-gradient(135deg, var(--bs-primary) 0%, #6610f2 100%);
        transition: width var(--transition-base);
    }

    .nav-tabs .nav-link:hover {
        color: var(--bs-primary);
        background: rgba(13, 110, 253, 0.05);
    }

    .nav-tabs .nav-link:hover::before {
        width: 100%;
    }

    .nav-tabs .nav-link.active {
        color: var(--bs-primary);
        background: rgba(13, 110, 253, 0.05);
        border-bottom-color: var(--bs-primary);
    }

    .nav-tabs .nav-link.active::before {
        width: 100%;
    }

    /* Badges mejorados con animación */
    .nav-tabs .badge {
        font-size: 0.7rem;
        padding: 0.3rem 0.6rem;
        border-radius: var(--radius-full);
        font-weight: 700;
        box-shadow: var(--shadow-sm);
        transition: all var(--transition-fast);
    }

    .nav-tabs .nav-link:hover .badge {
        transform: scale(1.1);
    }

    /* Cards mejoradas con sombra moderna */
    #commits-content .card,
    #releases-content .card {
        border: none;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        transition: all var(--transition-base);
        overflow: hidden;
    }

    #commits-content .card:hover,
    #releases-content .card:hover {
        box-shadow: var(--shadow-xl);
        transform: translateY(-2px);
    }

    /* Card header con gradiente */
    .card-header {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.08) 0%, rgba(102, 16, 242, 0.08) 100%);
        border-bottom: 2px solid rgba(13, 110, 253, 0.2);
        padding: var(--spacing-lg);
    }

    .card-header h5 {
        font-weight: 700;
        margin: 0;
    }

    /* Botones de filtro mejorados */
    .card-header .btn-group {
        box-shadow: var(--shadow-sm);
        border-radius: var(--radius-md);
        overflow: hidden;
    }

    .card-header .btn-group label {
        transition: all var(--transition-base);
        font-weight: 600;
    }

    .card-header .btn-group label:hover {
        transform: translateY(-1px);
    }

    .card-header .btn-group .btn-check:checked + label {
        box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    }

    /* DataTables con mejores efectos hover */
    #commitsTable tbody tr,
    #releasesTable tbody tr {
        transition: all var(--transition-base);
        border-left: 3px solid transparent;
    }

    #commitsTable tbody tr:hover,
    #releasesTable tbody tr:hover {
        transform: translateX(8px);
        box-shadow: var(--shadow-md);
        border-left-color: var(--bs-primary);
        background: rgba(13, 110, 253, 0.03);
    }

    /* Tabla responsive mejorada */
    .table-responsive {
        max-width: 100%;
        overflow-x: auto;
        border-radius: var(--radius-md);
    }

    #commitsTable,
    #releasesTable {
        width: 100% !important;
        table-layout: fixed;
        margin: 0;
    }

    #commitsTable thead th,
    #releasesTable thead th {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.05) 0%, rgba(102, 16, 242, 0.05) 100%);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: var(--spacing-md);
        border: none;
    }

    #commitsTable td,
    #commitsTable th,
    #releasesTable td,
    #releasesTable th {
        overflow: hidden;
        text-overflow: ellipsis;
        vertical-align: middle;
    }

    /* Commit SHA badge mejorado */
    .commit-sha {
        font-family: 'Courier New', monospace;
        font-size: 0.85rem;
        padding: 0.4rem 0.7rem;
        background: linear-gradient(135deg, rgba(108, 117, 125, 0.1) 0%, rgba(108, 117, 125, 0.2) 100%);
        border: 1px solid rgba(108, 117, 125, 0.2);
        border-radius: var(--radius-md);
        display: inline-block;
        font-weight: 600;
        transition: all var(--transition-fast);
    }

    .commit-sha:hover {
        background: linear-gradient(135deg, rgba(108, 117, 125, 0.2) 0%, rgba(108, 117, 125, 0.3) 100%);
        transform: scale(1.05);
    }

    /* Tag badge mejorado */
    .release-tag {
        font-weight: 700;
        font-size: 0.9rem;
        padding: 0.4rem 0.8rem;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        transition: all var(--transition-fast);
    }

    .release-tag:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }

    /* Repo badge mejorado */
    .repo-badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.65rem;
        border-radius: var(--radius-md);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: var(--shadow-sm);
        transition: all var(--transition-fast);
    }

    .repo-badge:hover {
        transform: scale(1.08);
        box-shadow: var(--shadow-md);
    }

    /* Action buttons mejorados */
    .btn-action {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        transition: all var(--transition-base);
        box-shadow: var(--shadow-sm);
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Commit message mejorado */
    .commit-message {
        max-width: 400px;
        max-height: 4.5em;
        line-height: 1.5em;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        white-space: normal;
        word-wrap: break-word;
        color: var(--bs-body-color);
        font-size: 0.9rem;
    }

    /* Release description mejorada */
    .release-description {
        max-width: 350px;
        max-height: 4.5em;
        line-height: 1.5em;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        white-space: normal;
        word-wrap: break-word;
        color: var(--bs-body-color);
        font-size: 0.9rem;
    }

    /* Loading state mejorado */
    .changes-loading {
        text-align: center;
        padding: 4rem;
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.05) 0%, rgba(102, 16, 242, 0.05) 100%);
        border-radius: var(--radius-lg);
    }

    .changes-loading i {
        font-size: 3.5rem;
        background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: spin 1.5s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    /* Efecto de pulso para badges de conteo */
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .badge.animate-pulse {
        animation: pulse 2s ease-in-out infinite;
    }

    /* Estilos para el card-body */
    .card-body {
        padding: var(--spacing-lg);
    }

    /* Paginación mejorada de DataTables */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: var(--radius-md) !important;
        margin: 0 0.25rem;
        transition: all var(--transition-fast);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: linear-gradient(135deg, var(--bs-primary) 0%, #6610f2 100%) !important;
        color: white !important;
        border: none !important;
        transform: translateY(-2px);
    }

    /* Responsive adjustments mejorados */
    @media (max-width: 768px) {
        .changes-header {
            padding: var(--spacing-md);
        }

        .changes-header h1 {
            font-size: var(--font-size-2xl);
        }

        .commit-message,
        .release-description {
            max-width: 200px;
            max-height: 3em;
            -webkit-line-clamp: 2;
        }

        .btn-group {
            flex-direction: column;
        }

        .card-body {
            padding: var(--spacing-md);
        }

        #commitsTable,
        #releasesTable {
            font-size: 0.875rem;
        }

        .btn-action {
            padding: 0.3rem 0.5rem;
            font-size: 0.75rem;
        }

        #commitsTable tbody tr:hover,
        #releasesTable tbody tr:hover {
            transform: translateX(4px);
        }

        .nav-tabs .nav-link {
            padding: var(--spacing-sm) var(--spacing-md);
        }
    }

    @media (max-width: 576px) {
        .commit-message,
        .release-description {
            max-width: 150px;
        }

        .changes-header {
            padding: var(--spacing-sm);
        }
    }

    /* Animación de entrada para las cards */
    .tab-pane.active .card {
        animation: slideInUp 0.5s ease-out;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Estilos para elementos clickeables */
    .clickable {
        cursor: pointer;
        transition: all var(--transition-fast);
    }

    .clickable:hover {
        opacity: 0.8;
    }

    .commit-sha.clickable:hover,
    .release-tag.clickable:hover,
    strong.clickable:hover {
        transform: scale(1.05);
    }

    /* ===================================
       ESTILOS PARA MODALES DE DETALLES
    =================================== */

    /* Commit Modal Styles */
    .commit-details-modal,
    .release-details-modal {
        text-align: left;
    }

    .detail-section {
        margin-bottom: var(--spacing-lg);
        padding-bottom: var(--spacing-lg);
        border-bottom: 1px solid var(--bs-border-color);
    }

    .detail-section:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .detail-header {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        flex-wrap: wrap;
    }

    .commit-sha-large {
        font-family: 'Courier New', monospace;
        font-size: 0.9rem;
        padding: 0.4rem 0.8rem;
        background: linear-gradient(135deg, rgba(108, 117, 125, 0.1) 0%, rgba(108, 117, 125, 0.2) 100%);
        border: 1px solid rgba(108, 117, 125, 0.2);
        border-radius: var(--radius-md);
        font-weight: 600;
    }

    .detail-section h5 {
        font-weight: 700;
        color: var(--bs-heading-color);
        margin-bottom: var(--spacing-md);
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .detail-section h5 i {
        font-size: 1.2rem;
        color: var(--bs-primary);
    }

    .commit-title,
    .release-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--bs-heading-color);
        margin-bottom: var(--spacing-md);
        line-height: 1.4;
    }

    .release-title {
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .commit-description,
    .release-body {
        color: var(--bs-body-color);
        line-height: 1.6;
        padding: var(--spacing-md);
        background: rgba(var(--color-primary-rgb), 0.03);
        border-radius: var(--radius-md);
        border-left: 3px solid var(--bs-primary);
    }

    .release-body {
        max-height: 400px;
        overflow-y: auto;
    }

    .release-body h3,
    .release-body h4,
    .release-body h5 {
        margin-top: var(--spacing-md);
        margin-bottom: var(--spacing-sm);
        color: var(--bs-heading-color);
    }

    .release-body ul {
        margin: var(--spacing-sm) 0;
        padding-left: var(--spacing-xl);
    }

    .release-body li {
        margin-bottom: var(--spacing-xs);
    }

    .detail-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: var(--spacing-lg);
    }

    .detail-item {
        display: flex;
        align-items: flex-start;
        gap: var(--spacing-md);
    }

    .detail-item i {
        font-size: 1.5rem;
        color: var(--bs-primary);
        margin-top: 0.2rem;
    }

    .detail-item .text-muted {
        display: block;
        font-size: 0.85rem;
        margin-bottom: 0.25rem;
    }

    .detail-value {
        font-weight: 600;
        color: var(--bs-heading-color);
    }

    /* Estilos específicos para el modal de SweetAlert2 */
    .commit-modal-popup,
    .release-modal-popup {
        border-radius: var(--radius-lg) !important;
        padding: var(--spacing-xl) !important;
    }

    .swal2-title {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--spacing-sm);
        color: var(--bs-heading-color) !important;
        font-weight: 700 !important;
    }

    .swal2-title i {
        font-size: 1.8rem;
        color: var(--bs-primary);
    }

    .swal2-html-container {
        margin: 0 !important;
        padding: 0 !important;
    }

    /* Scrollbar personalizado para el contenido del release */
    .release-body::-webkit-scrollbar {
        width: 8px;
    }

    .release-body::-webkit-scrollbar-track {
        background: var(--bs-secondary-bg);
        border-radius: var(--radius-md);
    }

    .release-body::-webkit-scrollbar-thumb {
        background: var(--bs-primary);
        border-radius: var(--radius-md);
    }

    .release-body::-webkit-scrollbar-thumb:hover {
        background: var(--color-primary-dark);
    }

    /* Responsive para modales */
    @media (max-width: 768px) {
        .commit-modal-popup,
        .release-modal-popup {
            padding: var(--spacing-md) !important;
        }

        .detail-row {
            grid-template-columns: 1fr;
            gap: var(--spacing-md);
        }

        .commit-sha-large {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
        }

        .release-title {
            font-size: 1.1rem;
        }
    }
</style>

<script>
    (function () {
        'use strict';

        console.log('📝 Changes Page: Inicializando...');

        // ===================================
        // VARIABLES GLOBALES
        // ===================================

        let commitsTable = null;
        let releasesTable = null;
        let allCommitsData = [];
        let allReleasesData = [];

        // ===================================
        // INICIALIZACIÓN
        // ===================================

        let initAttempts = 0;
        const MAX_INIT_ATTEMPTS = 20; // 10 segundos máximo

        function initialize() {
            initAttempts++;

            console.log('🚀 Changes Page: Verificando dependencias... (Intento', initAttempts, '/', MAX_INIT_ATTEMPTS, ')');

            // Límite de reintentos
            if (initAttempts > MAX_INIT_ATTEMPTS) {
                console.error('❌ No se pudo inicializar la página después de', MAX_INIT_ATTEMPTS, 'intentos');
                showError('Error al cargar la página de cambios. Por favor, recarga la página.');
                return;
            }

            // Verificar que ChangesService esté disponible
            if (typeof window.ChangesService === 'undefined') {
                console.warn('⏳ ChangesService no disponible, reintentando...');
                setTimeout(initialize, 500);
                return;
            }

            // Verificar que jQuery esté disponible
            if (typeof $ === 'undefined' || typeof jQuery === 'undefined') {
                console.warn('⏳ jQuery no disponible, reintentando...');
                setTimeout(initialize, 500);
                return;
            }

            // Verificar que DataTables esté disponible
            if (typeof $.fn.DataTable === 'undefined') {
                console.warn('⏳ DataTables no disponible, reintentando...');
                setTimeout(initialize, 500);
                return;
            }

            // Verificar que las tablas existan en el DOM
            if ($('#commitsTable').length === 0 || $('#releasesTable').length === 0) {
                console.warn('⏳ Tablas no encontradas en DOM, reintentando...');
                setTimeout(initialize, 500);
                return;
            }

            console.log('✅ Dependencias verificadas');
            console.log('✅ Tablas encontradas en DOM');

            // Configurar event listeners
            setupEventListeners();

            // Cargar datos
            loadAllData();
        }

        // ===================================
        // CARGA DE DATOS
        // ===================================

        async function loadAllData() {
            try {
                console.log('📡 Iniciando carga de datos de GitHub...');

                // Mostrar indicadores de carga
                $('#commits-count').html('<i class="bx bx-loader-alt bx-spin"></i>');
                $('#releases-count').html('<i class="bx bx-loader-alt bx-spin"></i>');

                // Cargar commits y releases en paralelo
                const [commits, releases] = await Promise.all([
                    window.ChangesService.getAllCommits(50),
                    window.ChangesService.getAllReleases(20)
                ]);

                allCommitsData = commits;
                allReleasesData = releases;

                console.log('📊 Commits recibidos:', commits.length);
                console.log('📊 Releases recibidos:', releases.length);

                // Actualizar contadores
                updateCounts();

                // Inicializar DataTables
                initCommitsTable();
                initReleasesTable();

                console.log('✅ Datos cargados correctamente');

            } catch (error) {
                console.error('❌ Error cargando datos:', error);
                $('#commits-count').text('Error');
                $('#releases-count').text('Error');
                showError('Error al cargar los datos de GitHub. Intenta de nuevo más tarde.');
            }
        }

        // ===================================
        // DATATABLES - COMMITS
        // ===================================

        function initCommitsTable() {
            console.log('📊 Inicializando tabla de commits...');
            console.log('📊 Cantidad de commits:', allCommitsData.length);
            console.log('📊 Tabla existe:', $('#commitsTable').length > 0);

            // Destruir tabla existente si existe
            if (commitsTable) {
                console.log('🗑️ Destruyendo tabla de commits existente');
                commitsTable.destroy();
            }

            try {
                commitsTable = $('#commitsTable').DataTable({
                    data: allCommitsData,
                    columns: [
                        {
                            data: 'sha',
                            width: '80px',
                            render: function (data, type, row) {
                                return `<code class="commit-sha clickable" data-commit-sha="${data}">${data}</code>`;
                            }
                        },
                        {
                            data: 'message',
                            width: '400px',
                            render: function (data, type, row) {
                                // Tomar las primeras 3 líneas del mensaje
                                const lines = data.split('\n').slice(0, 3).join('\n');
                                const cleanMessage = lines.trim();
                                return `<span class="commit-message clickable" data-commit-sha="${row.sha}" title="${data.replace(/"/g, '&quot;')}">${cleanMessage}</span>`;
                            }
                        },
                        {
                            data: 'author',
                            width: '150px',
                            render: function (data, type, row) {
                                return `<div><strong>${data}</strong></div>`;
                            }
                        },
                        {
                            data: 'repo',
                            width: '120px',
                            render: function (data, type, row) {
                                const color = row.repoType === 'frontend' ? 'primary' : 'info';
                                return `<span class="badge bg-${color} repo-badge">${data}</span>`;
                            }
                        },
                        {
                            data: 'date',
                            width: '130px',
                            render: function (data, type, row) {
                                const formatted = window.ChangesService.formatDate(data);
                                const fullDate = new Date(data).toLocaleString('es-ES');
                                return `<small title="${fullDate}">${formatted}</small>`;
                            }
                        },
                        {
                            data: null,
                            width: '120px',
                            orderable: false,
                            render: function (data, type, row) {
                                return `
                                    <button class="btn btn-sm btn-outline-info btn-action view-commit-details" data-commit-sha="${row.sha}">
                                        <i class="bx bx-info-circle"></i> Info
                                    </button>
                                    <a href="${row.url}" target="_blank" class="btn btn-sm btn-outline-primary btn-action">
                                        <i class="bx bx-link-external"></i>
                                    </a>
                                `;
                            }
                        }
                    ],
                    order: [[4, 'desc']], // Ordenar por fecha descendente
                    pageLength: 25,
                    responsive: true,
                    autoWidth: false,
                    scrollX: false,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                    }
                });

                // Event listener para mostrar detalles de commit
                $('#commitsTable tbody').on('click', '.view-commit-details, .commit-sha.clickable, .commit-message.clickable', function (e) {
                    e.preventDefault();
                    const sha = $(this).data('commit-sha');
                    showCommitDetails(sha);
                });

                console.log('✅ Tabla de commits inicializada correctamente');
            } catch (error) {
                console.error('❌ Error inicializando tabla de commits:', error);
            }
        }

        // ===================================
        // DATATABLES - RELEASES
        // ===================================

        function initReleasesTable() {
            console.log('📊 Inicializando tabla de releases...');
            console.log('📊 Cantidad de releases:', allReleasesData.length);
            console.log('📊 Tabla existe:', $('#releasesTable').length > 0);

            // Destruir tabla existente si existe
            if (releasesTable) {
                console.log('🗑️ Destruyendo tabla de releases existente');
                releasesTable.destroy();
            }

            try {
                releasesTable = $('#releasesTable').DataTable({
                    data: allReleasesData,
                    columns: [
                        {
                            data: 'tagName',
                            width: '100px',
                            render: function (data, type, row) {
                                const badgeColor = row.isPrerelease ? 'warning' : 'success';
                                return `<span class="badge bg-${badgeColor} release-tag clickable" data-release-id="${row.id}">${data}</span>`;
                            }
                        },
                        {
                            data: 'name',
                            width: '180px',
                            render: function (data, type, row) {
                                return `<strong class="clickable" data-release-id="${row.id}">${data}</strong>`;
                            }
                        },
                        {
                            data: 'body',
                            width: '350px',
                            render: function (data, type, row) {
                                // Limpiar markdown y tomar las primeras 3 líneas
                                const cleanBody = data.replace(/[#*\-\[\]]/g, '').trim();
                                const lines = cleanBody.split('\n').filter(line => line.trim() !== '').slice(0, 3).join('\n');
                                const displayText = lines || 'Sin descripción';
                                return `<span class="release-description" title="${cleanBody.replace(/"/g, '&quot;')}">${displayText}</span>`;
                            }
                        },
                        {
                            data: 'author',
                            width: '120px',
                            render: function (data, type, row) {
                                return `<div><strong>${data}</strong></div>`;
                            }
                        },
                        {
                            data: 'repo',
                            width: '120px',
                            render: function (data, type, row) {
                                const color = row.repoType === 'frontend' ? 'primary' : 'info';
                                return `<span class="badge bg-${color} repo-badge">${data}</span>`;
                            }
                        },
                        {
                            data: 'publishedAt',
                            width: '130px',
                            render: function (data, type, row) {
                                const formatted = window.ChangesService.formatDate(data);
                                const fullDate = new Date(data).toLocaleString('es-ES');
                                return `<small title="${fullDate}">${formatted}</small>`;
                            }
                        },
                        {
                            data: null,
                            width: '120px',
                            orderable: false,
                            render: function (data, type, row) {
                                return `
                                    <button class="btn btn-sm btn-outline-info btn-action view-release-details" data-release-id="${row.id}">
                                        <i class="bx bx-info-circle"></i> Info
                                    </button>
                                    <a href="${row.url}" target="_blank" class="btn btn-sm btn-outline-success btn-action">
                                        <i class="bx bx-link-external"></i>
                                    </a>
                                `;
                            }
                        }
                    ],
                    order: [[5, 'desc']], // Ordenar por fecha descendente
                    pageLength: 10,
                    responsive: true,
                    autoWidth: false,
                    scrollX: false,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                    }
                });

                // Event listener para mostrar detalles de release
                $('#releasesTable tbody').on('click', '.view-release-details, .release-tag.clickable, strong.clickable', function (e) {
                    e.preventDefault();
                    const releaseId = $(this).data('release-id');
                    showReleaseDetails(releaseId);
                });

                console.log('✅ Tabla de releases inicializada correctamente');
            } catch (error) {
                console.error('❌ Error inicializando tabla de releases:', error);
            }
        }

        // ===================================
        // MOSTRAR DETALLES - MODAL
        // ===================================

        function showCommitDetails(sha) {
            console.log('📝 Mostrando detalles del commit:', sha);
            
            // Buscar el commit en los datos
            const commit = allCommitsData.find(c => c.sha === sha);
            
            if (!commit) {
                console.error('❌ Commit no encontrado:', sha);
                return;
            }

            // Formatear el mensaje del commit
            const messageLines = commit.message.split('\n');
            const title = messageLines[0];
            const description = messageLines.slice(1).join('\n').trim();

            // Crear HTML para el modal
            const modalContent = `
                <div class="commit-details-modal">
                    <div class="detail-section">
                        <div class="detail-header">
                            <span class="badge bg-${commit.repoType === 'frontend' ? 'primary' : 'info'}">${commit.repo}</span>
                            <code class="commit-sha-large">${commit.sha}</code>
                        </div>
                    </div>
                    
                    <div class="detail-section">
                        <h5><i class="bx bx-message-square-detail"></i> Mensaje del Commit</h5>
                        <div class="commit-title">${title}</div>
                        ${description ? `<div class="commit-description">${description.replace(/\n/g, '<br>')}</div>` : ''}
                    </div>

                    <div class="detail-section">
                        <div class="detail-row">
                            <div class="detail-item">
                                <i class="bx bx-user"></i>
                                <div>
                                    <small class="text-muted">Autor</small>
                                    <div class="detail-value">${commit.author}</div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="bx bx-calendar"></i>
                                <div>
                                    <small class="text-muted">Fecha</small>
                                    <div class="detail-value">${new Date(commit.date).toLocaleString('es-ES', { 
                                        year: 'numeric', 
                                        month: 'long', 
                                        day: 'numeric', 
                                        hour: '2-digit', 
                                        minute: '2-digit' 
                                    })}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <a href="${commit.url}" target="_blank" class="btn btn-primary w-100">
                            <i class="bx bx-link-external me-2"></i>
                            Ver en GitHub
                        </a>
                    </div>
                </div>
            `;

            // Mostrar modal con SweetAlert2
            Swal.fire({
                title: '<i class="bx bx-git-commit"></i> Detalles del Commit',
                html: modalContent,
                width: '700px',
                showCloseButton: true,
                showConfirmButton: false,
                customClass: {
                    container: 'commit-modal-container',
                    popup: 'commit-modal-popup'
                }
            });
        }

        function showReleaseDetails(releaseId) {
            console.log('🏷️ Mostrando detalles del release:', releaseId);
            
            // Buscar el release en los datos
            const release = allReleasesData.find(r => r.id === releaseId);
            
            if (!release) {
                console.error('❌ Release no encontrado:', releaseId);
                return;
            }

            // Formatear el cuerpo del release (markdown a HTML básico)
            let bodyHtml = release.body
                .replace(/### (.*?)$/gm, '<h5>$1</h5>')
                .replace(/## (.*?)$/gm, '<h4>$1</h4>')
                .replace(/# (.*?)$/gm, '<h3>$1</h3>')
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\*(.*?)\*/g, '<em>$1</em>')
                .replace(/- (.*?)$/gm, '<li>$1</li>')
                .replace(/(<li>.*<\/li>)/s, '<ul>$1</ul>')
                .replace(/\n/g, '<br>');

            // Crear HTML para el modal
            const modalContent = `
                <div class="release-details-modal">
                    <div class="detail-section">
                        <div class="detail-header">
                            <span class="badge bg-${release.repoType === 'frontend' ? 'primary' : 'info'}">${release.repo}</span>
                            <span class="badge bg-${release.isPrerelease ? 'warning' : 'success'} ms-2">
                                ${release.isPrerelease ? 'Pre-release' : 'Release Estable'}
                            </span>
                        </div>
                        <h3 class="release-title mt-3">
                            <i class="bx bx-purchase-tag"></i> ${release.tagName} - ${release.name}
                        </h3>
                    </div>
                    
                    <div class="detail-section">
                        <h5><i class="bx bx-file-blank"></i> Notas de la Versión</h5>
                        <div class="release-body">${bodyHtml || '<p class="text-muted">Sin descripción</p>'}</div>
                    </div>

                    <div class="detail-section">
                        <div class="detail-row">
                            <div class="detail-item">
                                <i class="bx bx-user"></i>
                                <div>
                                    <small class="text-muted">Publicado por</small>
                                    <div class="detail-value">${release.author}</div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="bx bx-calendar"></i>
                                <div>
                                    <small class="text-muted">Fecha de publicación</small>
                                    <div class="detail-value">${new Date(release.publishedAt).toLocaleString('es-ES', { 
                                        year: 'numeric', 
                                        month: 'long', 
                                        day: 'numeric', 
                                        hour: '2-digit', 
                                        minute: '2-digit' 
                                    })}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <a href="${release.url}" target="_blank" class="btn btn-success w-100">
                            <i class="bx bx-link-external me-2"></i>
                            Ver en GitHub
                        </a>
                    </div>
                </div>
            `;

            // Mostrar modal con SweetAlert2
            Swal.fire({
                title: '<i class="bx bx-purchase-tag"></i> Detalles del Release',
                html: modalContent,
                width: '800px',
                showCloseButton: true,
                showConfirmButton: false,
                customClass: {
                    container: 'release-modal-container',
                    popup: 'release-modal-popup'
                }
            });
        }

        // ===================================
        // FILTROS
        // ===================================

        function filterCommits(repoType) {
            console.log('🔍 Filtrando commits:', repoType);

            if (repoType === 'all') {
                commitsTable.clear().rows.add(allCommitsData).draw();
            } else {
                const filtered = allCommitsData.filter(commit => commit.repoType === repoType);
                commitsTable.clear().rows.add(filtered).draw();
            }
        }

        function filterReleases(repoType) {
            console.log('🔍 Filtrando releases:', repoType);

            if (repoType === 'all') {
                releasesTable.clear().rows.add(allReleasesData).draw();
            } else {
                const filtered = allReleasesData.filter(release => release.repoType === repoType);
                releasesTable.clear().rows.add(filtered).draw();
            }
        }

        // ===================================
        // EVENT LISTENERS
        // ===================================

        function setupEventListeners() {
            // Botón de actualizar
            $('#refreshChangesBtn').on('click', function () {
                console.log('🔄 Actualizando datos...');
                $(this).prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin me-1"></i> Actualizando...');

                loadAllData().then(() => {
                    $(this).prop('disabled', false).html('<i class="bx bx-refresh me-1"></i> Actualizar');

                    // Notificación
                    if (typeof Notyf !== 'undefined') {
                        const notyf = new Notyf();
                        notyf.success('Datos actualizados correctamente');
                    }
                });
            });

            // Filtros de commits
            $('input[name="repoFilterCommits"]').on('change', function () {
                const value = $(this).val();
                filterCommits(value);
            });

            // Filtros de releases
            $('input[name="repoFilterReleases"]').on('change', function () {
                const value = $(this).val();
                filterReleases(value);
            });
        }

        // ===================================
        // UTILIDADES
        // ===================================

        function updateCounts() {
            $('#commits-count').text(allCommitsData.length);
            $('#releases-count').text(allReleasesData.length);
            console.log('📊 Contadores actualizados:', allCommitsData.length, 'commits,', allReleasesData.length, 'releases');
        }

        function showError(message) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message,
                    confirmButtonText: 'Cerrar'
                });
            } else {
                alert(message);
            }
        }

        // ===================================
        // EJECUTAR AL CARGAR
        // ===================================

        // Esperar a que el DOM esté completamente listo
        // Usar un delay para asegurar que dashboard.view.php haya renderizado el contenido
        if (document.readyState === 'loading') {
            console.log('⏳ DOM cargando, esperando DOMContentLoaded...');
            document.addEventListener('DOMContentLoaded', function () {
                console.log('✅ DOMContentLoaded disparado');
                setTimeout(initialize, 1000); // Delay de 1 segundo para asegurar renderizado
            });
        } else {
            console.log('✅ DOM ya está listo');
            setTimeout(initialize, 1000); // Delay de 1 segundo para asegurar renderizado
        }

    })();
</script>