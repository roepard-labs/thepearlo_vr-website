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
                        <h2 class="mb-0 fw-bold" id="totalUsers">
                            <span class="spinner-border spinner-border-sm text-muted" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </span>
                        </h2>
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
                        <h2 class="mb-0 fw-bold text-success" id="activeUsers">
                            <span class="spinner-border spinner-border-sm text-muted" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </span>
                        </h2>
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
                        <div class="stats-icon-wrapper bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bx bx-user-plus fs-3 text-info"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1 small fw-medium">Nuevos (7 días)</p>
                        <h2 class="mb-0 fw-bold text-info" id="pendingUsers">
                            <span class="spinner-border spinner-border-sm text-muted" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </span>
                        </h2>
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
                        <div class="stats-icon-wrapper bg-secondary bg-opacity-10 rounded-circle p-3">
                            <i class="bx bx-user-x fs-3 text-secondary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1 small fw-medium">Inactivos</p>
                        <h2 class="mb-0 fw-bold text-secondary" id="inactiveUsers">
                            <span class="spinner-border spinner-border-sm text-muted" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </span>
                        </h2>
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
                    <option value="active">Activos</option>
                    <option value="inactive">Inactivos</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Rol</label>
                <select class="form-select" id="filterRole">
                    <option value="">Todos</option>
                    <option value="user">Usuario</option>
                    <option value="admin">Administrador</option>
                    <option value="supervisor">Supervisor</option>
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
                    <!-- Los datos se cargarán dinámicamente desde el backend -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script de gestión de usuarios -->
<script src="../js/users.js"></script>

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

/* Spinner de carga en estadísticas */
.stats-card h2 .spinner-border-sm {
    width: 1.5rem;
    height: 1.5rem;
    border-width: 0.2em;
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

/* ===================================
   ESTILOS DE MODALES SWEETALERT2 - MODO OSCURO
=================================== */

/* Modal principal en modo oscuro */
[data-bs-theme="dark"] .swal2-popup {
    background-color: #1a1d29 !important;
    color: #e9ecef !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
}

/* Título del modal */
[data-bs-theme="dark"] .swal2-title {
    color: #ffffff !important;
}

/* Contenido HTML del modal */
[data-bs-theme="dark"] .swal2-html-container {
    color: #e9ecef !important;
}

/* Textos pequeños (labels) */
[data-bs-theme="dark"] .swal2-html-container .text-muted {
    color: #adb5bd !important;
}

/* Textos con peso semibold */
[data-bs-theme="dark"] .swal2-html-container .fw-semibold {
    color: #f8f9fa !important;
}

/* Botones del modal */
[data-bs-theme="dark"] .swal2-confirm,
[data-bs-theme="dark"] .swal2-cancel {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3) !important;
}

/* Botón de confirmar (primary) */
[data-bs-theme="dark"] .swal2-confirm {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
}

[data-bs-theme="dark"] .swal2-confirm:hover {
    background-color: #0b5ed7 !important;
    border-color: #0a58ca !important;
}

/* Botón de cancelar */
[data-bs-theme="dark"] .swal2-cancel {
    background-color: #6c757d !important;
    border-color: #6c757d !important;
    color: #fff !important;
}

[data-bs-theme="dark"] .swal2-cancel:hover {
    background-color: #5c636a !important;
    border-color: #565e64 !important;
}

/* Botón de cerrar (X) */
[data-bs-theme="dark"] .swal2-close {
    color: #adb5bd !important;
}

[data-bs-theme="dark"] .swal2-close:hover {
    color: #ffffff !important;
}

/* Inputs del formulario en modal */
[data-bs-theme="dark"] .swal2-input,
[data-bs-theme="dark"] .swal2-textarea,
[data-bs-theme="dark"] .swal2-select,
[data-bs-theme="dark"] .swal2-html-container input,
[data-bs-theme="dark"] .swal2-html-container textarea,
[data-bs-theme="dark"] .swal2-html-container select {
    background-color: rgba(255, 255, 255, 0.05) !important;
    color: #f8f9fa !important;
    border: 1px solid rgba(255, 255, 255, 0.15) !important;
}

[data-bs-theme="dark"] .swal2-input:focus,
[data-bs-theme="dark"] .swal2-textarea:focus,
[data-bs-theme="dark"] .swal2-select:focus,
[data-bs-theme="dark"] .swal2-html-container input:focus,
[data-bs-theme="dark"] .swal2-html-container textarea:focus,
[data-bs-theme="dark"] .swal2-html-container select:focus {
    border-color: #0d6efd !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
}

/* Labels de formulario */
[data-bs-theme="dark"] .swal2-html-container label,
[data-bs-theme="dark"] .swal2-html-container .form-label {
    color: #adb5bd !important;
}

/* Placeholder de inputs */
[data-bs-theme="dark"] .swal2-input::placeholder,
[data-bs-theme="dark"] .swal2-textarea::placeholder,
[data-bs-theme="dark"] .swal2-html-container input::placeholder,
[data-bs-theme="dark"] .swal2-html-container textarea::placeholder {
    color: #6c757d !important;
}

/* Badges en modal */
[data-bs-theme="dark"] .swal2-html-container .badge {
    font-weight: 500 !important;
}

/* Loader/Loading spinner */
[data-bs-theme="dark"] .swal2-loader {
    border-color: #0d6efd transparent #0d6efd transparent !important;
}

/* Modal de confirmación de loading */
[data-bs-theme="dark"] .swal2-loading .swal2-styled {
    background-color: transparent !important;
    color: #f8f9fa !important;
}

/* Avatar circular del usuario */
[data-bs-theme="dark"] .swal2-html-container .rounded-circle {
    border: 3px solid rgba(255, 255, 255, 0.1) !important;
}

/* Dividers/Separadores */
[data-bs-theme="dark"] .swal2-html-container hr {
    border-color: rgba(255, 255, 255, 0.1) !important;
}

/* Select options en modo oscuro */
[data-bs-theme="dark"] .swal2-select option,
[data-bs-theme="dark"] .swal2-html-container select option {
    background-color: #1a1d29 !important;
    color: #f8f9fa !important;
}

/* Checkbox y radio buttons */
[data-bs-theme="dark"] .swal2-html-container input[type="checkbox"],
[data-bs-theme="dark"] .swal2-html-container input[type="radio"] {
    border-color: rgba(255, 255, 255, 0.15) !important;
}

/* Background del modal overlay */
[data-bs-theme="dark"] .swal2-container.swal2-backdrop-show {
    background: rgba(0, 0, 0, 0.7) !important;
}

/* ===================================
   ESTILOS DE MODALES SWEETALERT2 - MODO CLARO (mejoras)
=================================== */

/* Asegurar buen contraste en modo claro */
[data-bs-theme="light"] .swal2-popup {
    background-color: #ffffff !important;
    color: #212529 !important;
}

[data-bs-theme="light"] .swal2-html-container .text-muted {
    color: #6c757d !important;
}

[data-bs-theme="light"] .swal2-input,
[data-bs-theme="light"] .swal2-textarea,
[data-bs-theme="light"] .swal2-select,
[data-bs-theme="light"] .swal2-html-container input,
[data-bs-theme="light"] .swal2-html-container textarea,
[data-bs-theme="light"] .swal2-html-container select {
    background-color: #ffffff !important;
    color: #212529 !important;
    border: 1px solid #dee2e6 !important;
}

[data-bs-theme="light"] .swal2-input:focus,
[data-bs-theme="light"] .swal2-textarea:focus,
[data-bs-theme="light"] .swal2-select:focus,
[data-bs-theme="light"] .swal2-html-container input:focus,
[data-bs-theme="light"] .swal2-html-container textarea:focus,
[data-bs-theme="light"] .swal2-html-container select:focus {
    border-color: #0d6efd !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
}
</style>