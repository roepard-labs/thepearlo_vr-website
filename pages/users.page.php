<?php
/**
 * Página: Gestión de Usuarios
 * Ruta: /dashboard/users
 * Descripción: Gestión completa de usuarios del sistema
 * HomeLab AR - Roepard Labs
 */

// Esta página solo se incluye desde dashboard.view.php
// No debe accederse directamente
?>

<!-- Header de la Página -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">
            <i class="bx bx-user me-2 text-primary"></i>
            Gestión de Usuarios
        </h2>
        <p class="text-muted mb-0">Administra los usuarios del sistema</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bx bx-plus me-1"></i>
        Nuevo Usuario
    </button>
</div>

<!-- Estadísticas Rápidas -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon-wrapper bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bx bx-group fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1 small fw-medium">Total Usuarios</p>
                        <h2 class="mb-0 fw-bold" id="totalUsers">0</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon-wrapper bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bx bx-user-check fs-3 text-success"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1 small fw-medium">Activos</p>
                        <h2 class="mb-0 fw-bold text-success" id="activeUsers">0</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon-wrapper bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bx bx-user-plus fs-3 text-warning"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1 small fw-medium">Pendientes</p>
                        <h2 class="mb-0 fw-bold text-warning" id="pendingUsers">0</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon-wrapper bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="bx bx-user-x fs-3 text-danger"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1 small fw-medium">Inactivos</p>
                        <h2 class="mb-0 fw-bold text-danger" id="inactiveUsers">0</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Usuarios -->
<div class="card border-0 shadow-sm users-table-card">
    <div class="card-header py-3">
        <h5 class="mb-0 fw-semibold">
            <i class="bx bx-list-ul me-2"></i>
            Lista de Usuarios
        </h5>
    </div>
    <div class="card-body">
        <!-- Filtros -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Buscar</label>
                <input type="text" class="form-control" id="searchUser" placeholder="Buscar por nombre, email...">
            </div>
            <div class="col-md-3">
                <label class="form-label">Estado</label>
                <select class="form-select" id="filterStatus">
                    <option value="">Todos</option>
                    <option value="1">Activos</option>
                    <option value="0">Inactivos</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Rol</label>
                <select class="form-select" id="filterRole">
                    <option value="">Todos</option>
                    <option value="1">Usuario</option>
                    <option value="2">Administrador</option>
                    <option value="3">Supervisor</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-outline-secondary w-100" id="clearFilters">
                    <i class="bx bx-x me-1"></i>
                    Limpiar
                </button>
            </div>
        </div>

        <!-- DataTable -->
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="usersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Registro</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Datos de ejemplo - serían cargados dinámicamente -->
                    <tr>
                        <td>1</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 35px; height: 35px;">
                                    <i class="bx bx-user"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Juan Pérez</div>
                                    <small class="text-muted">@juanperez</small>
                                </div>
                            </div>
                        </td>
                        <td>juan.perez@example.com</td>
                        <td><span class="badge bg-primary">Administrador</span></td>
                        <td><span class="badge bg-success">Activo</span></td>
                        <td>2024-01-15</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="bx bx-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                <i class="bx bx-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 35px; height: 35px;">
                                    <i class="bx bx-user"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">María García</div>
                                    <small class="text-muted">@mariagarcia</small>
                                </div>
                            </div>
                        </td>
                        <td>maria.garcia@example.com</td>
                        <td><span class="badge bg-info">Usuario</span></td>
                        <td><span class="badge bg-success">Activo</span></td>
                        <td>2024-02-20</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="bx bx-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                <i class="bx bx-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 35px; height: 35px;">
                                    <i class="bx bx-user"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Carlos López</div>
                                    <small class="text-muted">@carloslopez</small>
                                </div>
                            </div>
                        </td>
                        <td>carlos.lopez@example.com</td>
                        <td><span class="badge bg-secondary">Supervisor</span></td>
                        <td><span class="badge bg-warning">Pendiente</span></td>
                        <td>2024-03-10</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="bx bx-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                <i class="bx bx-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Agregar Usuario -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bx bx-user-plus me-2"></i>
                    Nuevo Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="mb-3">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" placeholder="Ej: Juan Pérez" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="ejemplo@email.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <input type="text" class="form-control" placeholder="@username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <option value="1">Usuario</option>
                            <option value="2">Administrador</option>
                            <option value="3">Supervisor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">
                    <i class="bx bx-save me-1"></i>
                    Guardar Usuario
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        'use strict';

        console.log('👥 Página: Usuarios - Inicializando');

        // ===================================
        // CARGAR ESTADÍSTICAS
        // ===================================
        function loadUserStats() {
            // Ejemplo con datos estáticos - conectar con backend real
            const stats = {
                total: 156,
                active: 142,
                pending: 8,
                inactive: 6
            };

            document.getElementById('totalUsers').textContent = stats.total;
            document.getElementById('activeUsers').textContent = stats.active;
            document.getElementById('pendingUsers').textContent = stats.pending;
            document.getElementById('inactiveUsers').textContent = stats.inactive;
        }

        // ===================================
        // INICIALIZAR DATATABLE
        // ===================================
        let dataTableInitAttempts = 0;
        const MAX_DATATABLE_ATTEMPTS = 20; // 10 segundos máximo

        function initDataTable() {
            dataTableInitAttempts++;

            // Verificar límite de reintentos
            if (dataTableInitAttempts > MAX_DATATABLE_ATTEMPTS) {
                console.error('❌ DataTables no se pudo cargar después de', MAX_DATATABLE_ATTEMPTS, 'intentos');
                console.error('Verifica que las dependencias estén correctamente configuradas en AppLayout.php');
                return;
            }

            // Verificar que jQuery esté disponible primero
            if (typeof $ === 'undefined' || typeof jQuery === 'undefined') {
                console.warn('⏳ jQuery no disponible aún, reintentando... (', dataTableInitAttempts, '/', MAX_DATATABLE_ATTEMPTS, ')');
                setTimeout(initDataTable, 500);
                return;
            }

            // Verificar que DataTables esté disponible
            if (typeof $.fn.dataTable === 'undefined') {
                console.warn('⏳ DataTables no disponible aún, reintentando... (', dataTableInitAttempts, '/', MAX_DATATABLE_ATTEMPTS, ')');
                setTimeout(initDataTable, 500);
                return;
            }

            // Verificar que la tabla exista en el DOM
            if ($('#usersTable').length === 0) {
                console.warn('⏳ Tabla #usersTable no encontrada en DOM, reintentando... (', dataTableInitAttempts, '/', MAX_DATATABLE_ATTEMPTS, ')');
                setTimeout(initDataTable, 500);
                return;
            }

            // Verificar si ya está inicializado
            if ($.fn.dataTable.isDataTable('#usersTable')) {
                console.log('✅ DataTable ya inicializado');
                return;
            }

            console.log('📊 Inicializando DataTable de usuarios (jQuery:', $.fn.jquery, ', DataTables:', $.fn.dataTable.version, ')');

            $('#usersTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                responsive: true,
                pageLength: 10,
                order: [
                    [0, 'desc']
                ],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
                columnDefs: [{
                    targets: -1,
                    orderable: false,
                    className: 'text-center'
                }],
                drawCallback: function () {
                    // Aplicar estilos al DataTable después de cada redibujado
                    applyDataTableDarkMode();
                }
            });

            // Aplicar estilos iniciales
            applyDataTableDarkMode();
        }

        // ===================================
        // APLICAR MODO OSCURO A DATATABLE
        // ===================================
        function applyDataTableDarkMode() {
            const isDarkMode = document.documentElement.getAttribute('data-bs-theme') === 'dark';

            if (isDarkMode) {
                // Agregar clase dark mode a elementos de DataTables
                $('#usersTable_wrapper').addClass('datatable-dark');
                $('#usersTable_filter input').addClass('form-control-dark');
                $('#usersTable_length select').addClass('form-select-dark');
            } else {
                $('#usersTable_wrapper').removeClass('datatable-dark');
                $('#usersTable_filter input').removeClass('form-control-dark');
                $('#usersTable_length select').removeClass('form-select-dark');
            }
        }

        // ===================================
        // DETECTAR CAMBIOS DE TEMA
        // ===================================
        const themeObserver = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.attributeName === 'data-bs-theme') {
                    applyDataTableDarkMode();
                }
            });
        });

        themeObserver.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['data-bs-theme']
        });

        // ===================================
        // FILTROS
        // ===================================
        document.getElementById('clearFilters')?.addEventListener('click', function () {
            document.getElementById('searchUser').value = '';
            document.getElementById('filterStatus').value = '';
            document.getElementById('filterRole').value = '';

            // Recargar tabla
            if ($.fn.dataTable.isDataTable('#usersTable')) {
                $('#usersTable').DataTable().search('').draw();
            }
        });

        // ===================================
        // INICIALIZACIÓN
        // ===================================

        // Función de inicialización que espera a que todo esté listo
        function initialize() {
            // Verificar que el DOM esté listo
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initialize);
                return;
            }

            // Cargar estadísticas (no depende de jQuery)
            loadUserStats();

            // Inicializar DataTable (requiere jQuery y DataTables)
            // Se ejecutará con reintentos hasta que las dependencias estén disponibles
            initDataTable();
        }

        // Ejecutar inicialización
        initialize();

    })();
</script>

<style>
    /* ===================================
   ESTILOS DE ESTADÍSTICAS
=================================== */
    .stats-card {
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
        border-color: var(--bs-primary);
    }

    .stats-icon-wrapper {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
    }

    .stats-card:hover .stats-icon-wrapper {
        transform: scale(1.1);
    }

    /* ===================================
   ESTILOS DE CARD DE USUARIOS
=================================== */
    .users-table-card .card-header {
        background-color: var(--bs-card-bg);
        border-bottom: 1px solid var(--bs-border-color);
    }

    [data-bs-theme="dark"] .users-table-card .card-header {
        background-color: rgba(255, 255, 255, 0.05);
    }

    /* ===================================
   ESTILOS DE DATATABLE - MODO OSCURO
=================================== */
    [data-bs-theme="dark"] #usersTable thead th {
        background-color: rgba(255, 255, 255, 0.05) !important;
        color: var(--bs-body-color) !important;
        border-color: var(--bs-border-color) !important;
    }

    [data-bs-theme="dark"] #usersTable tbody td {
        color: var(--bs-body-color) !important;
        border-color: var(--bs-border-color) !important;
    }

    [data-bs-theme="dark"] #usersTable tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.05) !important;
    }

    /* DataTables wrapper en modo oscuro */
    [data-bs-theme="dark"] .dataTables_wrapper .dataTables_length,
    [data-bs-theme="dark"] .dataTables_wrapper .dataTables_filter,
    [data-bs-theme="dark"] .dataTables_wrapper .dataTables_info,
    [data-bs-theme="dark"] .dataTables_wrapper .dataTables_paginate {
        color: var(--bs-body-color) !important;
    }

    /* Input de búsqueda en modo oscuro */
    [data-bs-theme="dark"] .dataTables_wrapper .dataTables_filter input {
        background-color: rgba(255, 255, 255, 0.05) !important;
        color: var(--bs-body-color) !important;
        border-color: var(--bs-border-color) !important;
    }

    /* Select de registros por página en modo oscuro */
    [data-bs-theme="dark"] .dataTables_wrapper .dataTables_length select {
        background-color: rgba(255, 255, 255, 0.05) !important;
        color: var(--bs-body-color) !important;
        border-color: var(--bs-border-color) !important;
    }

    /* Paginación en modo oscuro */
    [data-bs-theme="dark"] .dataTables_wrapper .dataTables_paginate .paginate_button {
        color: var(--bs-body-color) !important;
    }

    [data-bs-theme="dark"] .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: rgba(255, 255, 255, 0.1) !important;
        color: var(--bs-body-color) !important;
        border-color: var(--bs-border-color) !important;
    }

    [data-bs-theme="dark"] .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--bs-primary) !important;
        color: white !important;
        border-color: var(--bs-primary) !important;
    }

    [data-bs-theme="dark"] .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        color: rgba(255, 255, 255, 0.3) !important;
    }

    /* ===================================
   MODO CLARO (por defecto)
=================================== */
    [data-bs-theme="light"] #usersTable thead th {
        background-color: #f8f9fa !important;
        color: #212529 !important;
    }

    [data-bs-theme="light"] #usersTable tbody tr:hover {
        background-color: #f8f9fa !important;
    }

    /* ===================================
   OTROS ESTILOS
=================================== */
    .avatar-sm {
        font-size: 0.9rem;
    }

    .table-responsive {
        min-height: 400px;
    }

    .card {
        transition: all 0.3s ease;
    }

    /* Ajustar ancho de columnas de DataTable */
    #usersTable thead th:nth-child(1) {
        width: 5%;
    }

    /* ID */
    #usersTable thead th:nth-child(2) {
        width: 20%;
    }

    /* Usuario */
    #usersTable thead th:nth-child(3) {
        width: 25%;
    }

    /* Email */
    #usersTable thead th:nth-child(4) {
        width: 12%;
    }

    /* Rol */
    #usersTable thead th:nth-child(5) {
        width: 12%;
    }

    /* Estado */
    #usersTable thead th:nth-child(6) {
        width: 12%;
    }

    /* Registro */
    #usersTable thead th:nth-child(7) {
        width: 14%;
    }

    /* Acciones */
</style>