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
        <div class="d-flex justify-content-between align-items-center">
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
                <button class="btn btn-outline-primary" id="refreshChangesBtn">
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
       CHANGES PAGE STYLES
       Usa variables de variables.css
    =================================== */

    /* Tabs personalizados */
    .nav-tabs .nav-link {
        color: var(--bs-body-color);
        border: none;
        border-bottom: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        color: var(--bs-primary);
        border-bottom-color: var(--bs-primary);
    }

    .nav-tabs .nav-link.active {
        color: var(--bs-primary);
        background-color: transparent;
        border-bottom-color: var(--bs-primary);
    }

    /* Badges en tabs */
    .nav-tabs .badge {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
    }

    /* Card header con filtros */
    .card-header .btn-group {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* DataTables customization */
    #commitsTable tbody tr,
    #releasesTable tbody tr {
        transition: all 0.2s ease;
    }

    #commitsTable tbody tr:hover,
    #releasesTable tbody tr:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Prevenir que la tabla se estire horizontalmente */
    .table-responsive {
        max-width: 100%;
        overflow-x: auto;
    }

    #commitsTable,
    #releasesTable {
        width: 100% !important;
        table-layout: fixed;
    }

    /* Asegurar que las celdas no se expandan */
    #commitsTable td,
    #commitsTable th,
    #releasesTable td,
    #releasesTable th {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Commit SHA badge */
    .commit-sha {
        font-family: 'Courier New', monospace;
        font-size: 0.85rem;
        padding: 0.25rem 0.5rem;
        background-color: var(--bs-secondary-bg);
        border-radius: 4px;
        display: inline-block;
    }

    /* Tag badge */
    .release-tag {
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* Repo badge */
    .repo-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }

    /* Action buttons */
    .btn-action {
        padding: 0.25rem 0.5rem;
        font-size: 0.85rem;
    }

    /* Commit message - 3 líneas máximo */
    .commit-message {
        max-width: 400px;
        max-height: 4.5em;
        /* 3 líneas aprox */
        line-height: 1.5em;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        /* Limitar a 3 líneas */
        -webkit-box-orient: vertical;
        white-space: normal;
        word-wrap: break-word;
    }

    /* Release description - 3 líneas máximo */
    .release-description {
        max-width: 350px;
        max-height: 4.5em;
        /* 3 líneas aprox */
        line-height: 1.5em;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        /* Limitar a 3 líneas */
        -webkit-box-orient: vertical;
        white-space: normal;
        word-wrap: break-word;
    }

    /* Loading state */
    .changes-loading {
        text-align: center;
        padding: 3rem;
    }

    .changes-loading i {
        font-size: 3rem;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {

        .commit-message,
        .release-description {
            max-width: 200px;
            max-height: 3em;
            /* 2 líneas en móvil */
            -webkit-line-clamp: 2;
        }

        .btn-group {
            flex-direction: column;
        }

        /* Reducir padding en móvil */
        .card-body {
            padding: 0.75rem;
        }

        /* Hacer la tabla más compacta en móvil */
        #commitsTable,
        #releasesTable {
            font-size: 0.875rem;
        }

        .btn-action {
            padding: 0.25rem 0.4rem;
            font-size: 0.75rem;
        }
    }

    @media (max-width: 576px) {

        .commit-message,
        .release-description {
            max-width: 150px;
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
                                return `<code class="commit-sha">${data}</code>`;
                            }
                        },
                        {
                            data: 'message',
                            width: '400px',
                            render: function (data, type, row) {
                                // Tomar las primeras 3 líneas del mensaje
                                const lines = data.split('\n').slice(0, 3).join('\n');
                                const cleanMessage = lines.trim();
                                return `<span class="commit-message" title="${data.replace(/"/g, '&quot;')}">${cleanMessage}</span>`;
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
                            width: '80px',
                            orderable: false,
                            render: function (data, type, row) {
                                return `
                                    <a href="${row.url}" target="_blank" class="btn btn-sm btn-outline-primary btn-action">
                                        <i class="bx bx-link-external"></i> Ver
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
                                return `<span class="badge bg-${badgeColor} release-tag">${data}</span>`;
                            }
                        },
                        {
                            data: 'name',
                            width: '180px',
                            render: function (data, type, row) {
                                return `<strong>${data}</strong>`;
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
                            width: '80px',
                            orderable: false,
                            render: function (data, type, row) {
                                return `
                                    <a href="${row.url}" target="_blank" class="btn btn-sm btn-outline-success btn-action">
                                        <i class="bx bx-link-external"></i> Ver
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

                console.log('✅ Tabla de releases inicializada correctamente');
            } catch (error) {
                console.error('❌ Error inicializando tabla de releases:', error);
            }
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