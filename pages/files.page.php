<?php
/**
 * Página: Administrador de Archivos
 * CRUD completo de archivos con permisos por usuario/admin
 * HomeLab AR - Roepard Labs
 */
?>

<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="mb-1">
                    <i class="bx bx-folder-open text-primary me-2"></i>
                    Administrador de Archivos
                </h2>
                <p class="text-muted mb-0">
                    Gestiona tus archivos y documentos de forma segura
                </p>
            </div>
            <div class="d-flex gap-2">
                <!-- Upload File Button -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadFileModal">
                    <i class="bx bx-upload me-2"></i>
                    Subir Archivo
                </button>
                <!-- Create Folder: DESHABILITADO - Carpetas fijas: Documentos, Música, Videos, Imágenes -->
            </div>
        </div>
    </div>
</div>

<!-- Storage Stats -->
<div class="row g-4 mb-4">
    <!-- Total Storage -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 stats-card stats-card-primary">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Almacenamiento Total</p>
                        <h4 class="mb-0 fw-bold" id="totalStorage">10 GB</h4>
                    </div>
                    <div class="stats-icon-wrapper stats-icon-primary rounded-circle p-3">
                        <i class="bx bx-hdd fs-4"></i>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-primary" role="progressbar" id="storageProgress" style="width: 45%">
                    </div>
                </div>
                <small class="text-muted mt-2 d-block">
                    <span id="usedStorage">4.5 GB</span> usado
                </small>
            </div>
        </div>
    </div>

    <!-- Total Files -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 stats-card stats-card-info">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Total de Archivos</p>
                        <h4 class="mb-0 fw-bold" id="totalFiles">156</h4>
                    </div>
                    <div class="stats-icon-wrapper stats-icon-info rounded-circle p-3">
                        <i class="bx bx-file fs-4"></i>
                    </div>
                </div>
                <small class="text-muted mt-3 d-block">
                    <i class="bx bx-time-five me-1"></i>
                    Última subida: Hoy
                </small>
            </div>
        </div>
    </div>

    <!-- Folders -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 stats-card stats-card-warning">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Carpetas</p>
                        <h4 class="mb-0 fw-bold" id="totalFolders">12</h4>
                    </div>
                    <div class="stats-icon-wrapper stats-icon-warning rounded-circle p-3">
                        <i class="bx bx-folder fs-4"></i>
                    </div>
                </div>
                <small class="text-muted mt-3 d-block">
                    <i class="bx bx-check-circle me-1"></i>
                    Organizados
                </small>
            </div>
        </div>
    </div>

    <!-- Shared Files (solo admin) -->
    <div class="col-12 col-sm-6 col-lg-3 d-none" id="sharedFilesCard">
        <div class="card border-0 shadow-sm h-100 stats-card stats-card-success">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Archivos Compartidos</p>
                        <h4 class="mb-0 fw-bold" id="sharedFiles">28</h4>
                    </div>
                    <div class="stats-icon-wrapper stats-icon-success rounded-circle p-3">
                        <i class="bx bx-share-alt fs-4"></i>
                    </div>
                </div>
                <small class="text-muted mt-3 d-block">
                    <i class="bx bx-group me-1"></i>
                    Con todos los usuarios
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Files Display Area -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <!-- Breadcrumb Navigation -->
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb mb-0" id="folderBreadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-decoration-none" data-folder-id="root">
                                <i class="bx bx-home-alt me-1"></i>
                                Mis Archivos
                            </a>
                        </li>
                    </ol>
                </nav>

                <!-- List View (Única vista disponible) -->
                <div id="listView">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="filesTable">
                            <thead>
                                <tr>
                                    <th width="45%">Nombre</th>
                                    <th width="15%">Tamaño</th>
                                    <th width="15%">Tipo</th>
                                    <th width="15%">Fecha</th>
                                    <th width="10%" class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="filesTableBody">
                                <!-- Loading state inicial -->
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                        <p class="text-muted mt-3 mb-0">Cargando archivos...</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Empty State -->
                <div id="emptyState" class="text-center py-5 d-none">
                    <i class="bx bx-folder-open display-1 text-muted"></i>
                    <h5 class="mt-3 text-muted" id="emptyStateTitle">No hay archivos</h5>
                    <p class="text-muted" id="emptyStateText">Sube tu primer archivo para comenzar</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadFileModal"
                        id="emptyStateUploadBtn">
                        <i class="bx bx-upload me-2"></i>
                        Subir Archivo
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload File Modal -->
<div class="modal fade" id="uploadFileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bx bx-upload me-2"></i>
                    Subir Archivo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="uploadFileForm">
                    <!-- File Input -->
                    <div class="mb-3">
                        <label class="form-label">Seleccionar Archivo</label>
                        <input type="file" class="form-control" id="fileInput" required multiple
                            accept=".jpg,.jpeg,.png,.gif,.svg,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.md,.zip,.rar,.7z,.mp3,.mp4,.avi,.mov,.gltf,.glb,.obj">
                        <div class="form-text">
                            Máximo 50MB por archivo. Formatos: JPG, JPEG, PNG, SVG, PDF, DOC, XLS, TXT, MD, ZIP, MP3,
                            MP4, GLTF
                        </div>
                    </div>

                    <!-- Folder Selection -->
                    <div class="mb-3">
                        <label class="form-label">Carpeta de Destino <span class="text-danger">*</span></label>
                        <select class="form-select" id="uploadFolder" required>
                            <option value="" disabled selected>Selecciona una carpeta...</option>
                            <!-- Carpetas disponibles se cargarán dinámicamente con dueño -->
                        </select>
                        <div class="form-text">
                            Los archivos solo se pueden subir dentro de carpetas, no en la raíz.
                        </div>
                    </div>

                    <!-- File Description -->
                    <div class="mb-3">
                        <label class="form-label">Descripción (Opcional)</label>
                        <textarea class="form-control" id="fileDescription" rows="3"
                            placeholder="Agrega una descripción para este archivo..."></textarea>
                    </div>

                    <!-- Share Options (solo admin) -->
                    <div class="mb-3 d-none" id="shareOptionsDiv">
                        <label class="form-label">Opciones de Compartir</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="shareWithAll">
                            <label class="form-check-label" for="shareWithAll">
                                Compartir con todos los usuarios
                            </label>
                        </div>
                    </div>

                    <!-- Upload Progress -->
                    <div class="mb-3 d-none" id="uploadProgressDiv">
                        <label class="form-label">Progreso de Subida</label>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" id="uploadProgressBar"
                                role="progressbar" style="width: 0%">
                                0%
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="uploadFileBtn">
                    <i class="bx bx-upload me-2"></i>
                    Subir Archivo
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Create Folder Modal -->
<div class="modal fade" id="createFolderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bx bx-folder-plus me-2"></i>
                    Nueva Carpeta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createFolderForm">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Carpeta</label>
                        <input type="text" class="form-control" id="folderName" placeholder="Ej: Documentos 2025"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Carpeta Padre</label>
                        <select class="form-select" id="parentFolder">
                            <option value="root">Raíz / Mis Archivos</option>
                            <!-- Folders will be loaded dynamically -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción (Opcional)</label>
                        <textarea class="form-control" id="folderDescription" rows="2"
                            placeholder="Descripción de la carpeta..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="createFolderBtn2">
                    <i class="bx bx-folder-plus me-2"></i>
                    Crear Carpeta
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit File Modal -->
<div class="modal fade" id="editFileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bx bx-edit me-2"></i>
                    Editar Archivo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editFileForm">
                    <input type="hidden" id="editFileId">

                    <div class="mb-3">
                        <label class="form-label">Nombre del Archivo</label>
                        <input type="text" class="form-control" id="editFileName" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" id="editFileDescription" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mover a Carpeta</label>
                        <select class="form-select" id="editFileFolder">
                            <option value="root">Raíz / Mis Archivos</option>
                            <!-- Folders will be loaded dynamically -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveFileChangesBtn">
                    <i class="bx bx-save me-2"></i>
                    Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<!-- File Preview Modal -->
<div class="modal fade" id="filePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewFileName">
                    <i class="bx bx-file me-2"></i>
                    Vista Previa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center" id="filePreviewContent" style="min-height: 400px;">
                <!-- Preview will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="downloadPreviewBtn">
                    <i class="bx bx-download me-2"></i>
                    Descargar
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* ===================================
   FILES PAGE STYLES (SOLO VISTA DE LISTA)
   =================================== */

    .breadcrumb-item+.breadcrumb-item::before {
        content: "›";
    }

    /* File type colors */
    .file-type-image {
        color: var(--bs-info);
    }

    .file-type-document {
        color: var(--bs-primary);
    }

    .file-type-video {
        color: var(--bs-danger);
    }

    .file-type-audio {
        color: var(--bs-success);
    }

    .file-type-archive {
        color: var(--bs-warning);
    }

    .file-type-model {
        color: #6f42c1;
    }

    .file-type-other {
        color: var(--bs-secondary);
    }

    /* Table row hover effect */
    #filesTable tbody tr {
        transition: background-color 0.2s ease;
    }

    #filesTable tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    /* ===================================
   ESTILOS DE ESTADÍSTICAS - COLORIDOS
=================================== */
    .stats-card {
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
    }

    /* Hover específico por color */
    .stats-card-primary:hover {
        border-color: rgba(13, 110, 253, 0.3);
    }

    .stats-card-info:hover {
        border-color: rgba(13, 202, 240, 0.3);
    }

    .stats-card-warning:hover {
        border-color: rgba(255, 193, 7, 0.3);
    }

    .stats-card-success:hover {
        border-color: rgba(25, 135, 84, 0.3);
    }

    .stats-icon-wrapper {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .stats-card:hover .stats-icon-wrapper {
        transform: scale(1.1) rotate(5deg);
    }

    /* ===================================
   ICONOS COLORIDOS CON OPACIDAD
=================================== */

    /* Primary - Azul vibrante (Storage) */
    .stats-icon-primary {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.25), rgba(13, 110, 253, 0.15));
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }

    .stats-icon-primary i {
        color: #0d6efd;
        filter: drop-shadow(0 2px 4px rgba(13, 110, 253, 0.3));
    }

    [data-bs-theme="dark"] .stats-icon-primary {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.35), rgba(13, 110, 253, 0.25));
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    [data-bs-theme="dark"] .stats-icon-primary i {
        color: #5a9cff;
    }

    .stats-card-primary:hover .stats-icon-primary {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.4), rgba(13, 110, 253, 0.25));
        box-shadow: 0 6px 16px rgba(13, 110, 253, 0.35);
    }

    /* Info - Cyan vibrante (Files) */
    .stats-icon-info {
        background: linear-gradient(135deg, rgba(13, 202, 240, 0.25), rgba(13, 202, 240, 0.15));
        box-shadow: 0 4px 12px rgba(13, 202, 240, 0.2);
    }

    .stats-icon-info i {
        color: #0dcaf0;
        filter: drop-shadow(0 2px 4px rgba(13, 202, 240, 0.3));
    }

    [data-bs-theme="dark"] .stats-icon-info {
        background: linear-gradient(135deg, rgba(13, 202, 240, 0.35), rgba(13, 202, 240, 0.25));
        box-shadow: 0 4px 12px rgba(13, 202, 240, 0.3);
    }

    [data-bs-theme="dark"] .stats-icon-info i {
        color: #31d2f2;
    }

    .stats-card-info:hover .stats-icon-info {
        background: linear-gradient(135deg, rgba(13, 202, 240, 0.4), rgba(13, 202, 240, 0.25));
        box-shadow: 0 6px 16px rgba(13, 202, 240, 0.35);
    }

    /* Warning - Amarillo vibrante (Folders) */
    .stats-icon-warning {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.25), rgba(255, 193, 7, 0.15));
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);
    }

    .stats-icon-warning i {
        color: #ffc107;
        filter: drop-shadow(0 2px 4px rgba(255, 193, 7, 0.3));
    }

    [data-bs-theme="dark"] .stats-icon-warning {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.35), rgba(255, 193, 7, 0.25));
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
    }

    [data-bs-theme="dark"] .stats-icon-warning i {
        color: #ffd54f;
    }

    .stats-card-warning:hover .stats-icon-warning {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.4), rgba(255, 193, 7, 0.25));
        box-shadow: 0 6px 16px rgba(255, 193, 7, 0.35);
    }

    /* Success - Verde vibrante (Shared) */
    .stats-icon-success {
        background: linear-gradient(135deg, rgba(25, 135, 84, 0.25), rgba(25, 135, 84, 0.15));
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.2);
    }

    .stats-icon-success i {
        color: #198754;
        filter: drop-shadow(0 2px 4px rgba(25, 135, 84, 0.3));
    }

    [data-bs-theme="dark"] .stats-icon-success {
        background: linear-gradient(135deg, rgba(25, 135, 84, 0.35), rgba(25, 135, 84, 0.25));
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
    }

    [data-bs-theme="dark"] .stats-icon-success i {
        color: #4caf50;
    }

    .stats-card-success:hover .stats-icon-success {
        background: linear-gradient(135deg, rgba(25, 135, 84, 0.4), rgba(25, 135, 84, 0.25));
        box-shadow: 0 6px 16px rgba(25, 135, 84, 0.35);
    }
</style>

<script>
    (function () {
        'use strict';

        console.log('📁 Files Manager with FilePond: Inicializando...');

        // ===================================
        // ESTADO GLOBAL
        // ===================================
        let isAdmin = false;
        let currentUserId = null;
        let currentFolder = 'root';
        let folderPath = []; // Ruta de carpetas para breadcrumb
        let filesData = []; // Array de archivos cargados
        let allFilesData = []; // Todos los archivos (para navegación de carpetas)
        let allFoldersData = []; // NUEVO: Todas las carpetas del usuario (nunca se sobrescribe)
        let folderCache = {}; // Caché de carpetas para breadcrumb (id => {id, name, folderId})
        let pond = null; // Instancia de FilePond

        // ===================================
        // VERIFICAR DEPENDENCIAS
        // ===================================
        function waitForDependencies() {
            return new Promise((resolve) => {
                let attempts = 0;
                const maxAttempts = 50;

                const check = setInterval(() => {
                    attempts++;

                    if (window.AppRouter && window.RoleService && window.SessionService) {
                        clearInterval(check);
                        console.log('✅ Todas las dependencias disponibles');
                        resolve();
                    } else
                        if (attempts >= maxAttempts) {
                            clearInterval(check);

                            resolve(); // Continuar de todas formas
                        } else {
                            console.log(`⏳ Esperando dependencias... (${attempts}/${maxAttempts})`);
                        }
                }, 200);
            });
        }

        // ===================================
        // VERIFICAR ROL Y PERMISOS
        // ===================================
        async function checkUserRole() {
            try {
                const roleStatus = await window.RoleService.check();
                const sessionStatus = await window.SessionService.check();

                isAdmin = roleStatus.isAdmin;
                currentUserId = sessionStatus.userData?.user_id || 1;

                console.log('👔 Files Manager: Es admin?', isAdmin, '| User ID:', currentUserId);

                // Mostrar elementos solo para admin
                if (isAdmin) {
                    // Crear carpeta: DESHABILITADO - Carpetas fijas por usuario
                    // document.getElementById('createFolderBtn')?.classList.remove('d-none');
                    document.getElementById('sharedFilesCard')?.classList.remove('d-none');
                    document.getElementById('shareOptionsDiv')?.classList.remove('d-none');
                }

                // CRÍTICO: Cargar todas las carpetas primero (para selectores)
                await loadAllFolders();

                // Luego cargar archivos desde el backend
                await loadFilesFromBackend();

                // Calcular tamaños de carpetas (después de cargar archivos)
                await calculateFolderSizes();

                // Cargar estadísticas reales desde backend
                await loadStatsFromBackend();
            } catch (error) {
                console.error('❌ Error al verificar rol:', error);

                // En caso de error, mostrar error y vacío
                if (window.Notyf) {
                    new Notyf().error('Error al verificar permisos de usuario');
                }

                allFilesData = [];
                filesData = [];
                renderFiles([]);
            }
        }


        // ===================================
        // CARGAR TODAS LAS CARPETAS (UNA SOLA VEZ)
        // ===================================
        async function loadAllFolders() {
            console.log('📂 Cargando todas las carpetas del usuario...');

            try {
                const response = await window.AppRouter.get('/routes/files/list_files.php', {
                    params: {
                        folder_id: 'root',
                        user_id: currentUserId
                    }
                });

                if (response.status === 'success' && Array.isArray(response.files)) {
                    // Extraer solo las carpetas
                    allFoldersData = response.files
                        .filter(item => item.type === 'folder')
                        .map(item => ({
                            id: item.id || item.folder_id,
                            name: item.name || item.folder_name,
                            type: 'folder',
                            extension: null,
                            size: '-',
                            sizeBytes: 0,
                            date: item.date || item.created_at || new Date().toISOString(),
                            folderId: item.folderId || 'root',
                            owner: `${item.first_name || ''} ${item.last_name || ''}`.trim() || item
                                .username || 'Usuario',
                            ownerId: item.user_id,
                            description: item.description || '',
                            itemsCount: 0
                        }));

                    // Poblar caché con todas las carpetas
                    allFoldersData.forEach(folder => {
                        folderCache[folder.id] = {
                            id: folder.id,
                            name: folder.name,
                            folderId: folder.folderId,
                            owner: folder.owner
                        };
                    });

                    console.log('✅ Carpetas cargadas:', allFoldersData.length);
                    console.log('🗂️ Carpetas disponibles:', allFoldersData.map(f => f.name));

                    // Poblar selectores inmediatamente
                    populateFolderSelectors();
                }
            } catch (error) {
                console.error('❌ Error al cargar carpetas:', error);
                allFoldersData = [];
            }
        }


        // ===================================
        // CARGAR ARCHIVOS DESDE BACKEND
        // ===================================
        async function loadFilesFromBackend(folderId = 'root') {
            currentFolder = folderId;

            console.log('📂 Cargando archivos desde backend...');
            console.log('📁 Carpeta actual:', folderId);
            console.log('👤 Usuario:', currentUserId);

            try {
                // Mostrar loading
                showLoading();

                // Llamada al backend real
                const response = await window.AppRouter.get('/routes/files/list_files.php', {
                    params: {
                        folder_id: folderId === 'root' ? null : folderId,
                        user_id: currentUserId
                    }
                });

                console.log('✅ Archivos recibidos del backend:', response);

                // DEBUG: Ver estructura de los items
                if (response.files && response.files.length > 0) {
                    console.log('🔍 Estructura del primer item:', response.files[0]);
                }

                if (response.status === 'success' && Array.isArray(response.files)) {
                    // Procesar archivos recibidos del backend
                    const processedFiles = response.files.map(item => {
                        // CRÍTICO: Detectar si es carpeta o archivo
                        // Backend envía: folder_id/folder_name para carpetas, file_id/file_name para archivos
                        const isFolder = item.folder_name !== undefined || (item.type === 'folder');
                        const isFile = item.file_id !== undefined || item.file_name !== undefined;

                        console.log('🔍 Procesando item:', {
                            folder_name: item.folder_name,
                            file_name: item.file_name,
                            file_id: item.file_id,
                            isFolder: isFolder,
                            isFile: isFile
                        });

                        if (isFolder && !isFile) {
                            // Es una carpeta
                            return {
                                id: item.folder_id || item.id,
                                name: item.folder_name || item.name,
                                type: 'folder',
                                extension: null,
                                size: '-',
                                sizeBytes: 0,
                                date: item.created_at || item.date,
                                folder: 'root',
                                folderId: 'root',
                                owner: `${item.first_name || ''} ${item.last_name || ''}`.trim() || item
                                    .username || 'Usuario',
                                ownerId: item.user_id,
                                shared: false,
                                description: item.description || '',
                                itemsCount: 0
                            };
                        } else {
                            // Es un archivo
                            const fileName = item.original_name || item.file_name || 'archivo_sin_nombre';
                            const fileExtension = item.file_extension || (fileName.includes('.') ? fileName
                                .split('.').pop() : 'unknown');

                            return {
                                id: item.file_id,
                                name: fileName,
                                type: getFileTypeFromMime(item.file_type,
                                    fileExtension), // ✅ Pasar extensión para mejor detección
                                extension: fileExtension,
                                size: formatFileSize(item.file_size),
                                sizeBytes: item.file_size,
                                date: item.created_at,
                                folder: item.folder_id ? `folder_${item.folder_id}` : 'root',
                                folderId: item.folder_id || 'root',
                                owner: `${item.first_name || ''} ${item.last_name || ''}`.trim() || item
                                    .username || 'Usuario',
                                ownerId: item.user_id,
                                shared: item.is_shared || false,
                                description: item.description || '',
                                path: item.file_path
                            };
                        }
                    });

                    // CRÍTICO: Comportamiento diferente según si estamos en root o en carpeta
                    if (folderId === 'root') {
                        // En root: Sobrescribir allFilesData (contiene carpetas y archivos de root)
                        allFilesData = processedFiles;
                        console.log('✅ Root: allFilesData actualizado con', allFilesData.length, 'items');
                    } else {
                        // En carpeta: NO sobrescribir allFilesData


                        // 1. Remover archivos viejos de esta carpeta de allFilesData
                        allFilesData = allFilesData.filter(item => item.folderId != folderId);
                        // 2. Agregar los nuevos archivos de esta carpeta
                        allFilesData = [...allFilesData, ...processedFiles];

                        console.log('✅ Carpeta', folderId,
                            ': allFilesData actualizado con archivos de carpeta');
                        console.log('📊 Total items en sistema:', allFilesData.length);
                    }

                    console.log('� Total archivos procesados:', processedFiles.length);
                    console.log(
                        '�🗂️ Caché de carpetas actual:', Object.keys(folderCache).length, 'carpetas');

                    // DEBUG: Ver estructura mapeada (solo si hay items)
                    if (processedFiles.length > 0) {
                        console.log('🔍 Estructura mapeada del primer item:', processedFiles[0]);
                        console.log('🔍 folderId del primer item:', processedFiles[0].folderId);
                        console.log('🔍 currentFolder:', currentFolder);
                    } else {
                        console.log('� No hay archivos en esta carpeta');
                        console.log('�🔍 currentFolder:', currentFolder);
                    }

                    filterFilesByFolder(currentFolder);
                    updateBreadcrumb();
                } else {
                    // CRÍTICO: Si la carpeta está vacía, NO sobrescribir allFilesData
                    if (folderId !== 'root') {
                        console.log('📂 Carpeta vacía, manteniendo allFilesData intacto');
                        // Solo renderizar vacío para esta carpeta
                        filesData = [];
                        renderFiles([]);
                    } else {
                        // Solo en root podemos vaciar todo
                        allFilesData = [];
                        filesData = [];
                        renderFiles([]);
                        updateStats();
                    }
                }

                hideLoading();

            } catch (error) {
                console.error('❌ Error al cargar archivos:', error);
                hideLoading();

                // Mostrar notificación de error
                if (window.Notyf) {
                    new Notyf().error('Error al cargar archivos: ' + (error.message || 'Error desconocido'));
                }

                // CRÍTICO: Si hay error en una carpeta, NO vaciar allFilesData
                if (folderId === 'root') {
                    // Solo en root podemos vaciar todo si hay error
                    allFilesData = [];
                    filesData = [];
                    renderFiles([]);
                    updateStats();
                } else {
                    // En carpeta: mostrar empty state pero mantener datos del sistema
                    console.log('⚠️ Error en carpeta, manteniendo allFilesData intacto');
                    filesData = [];
                    renderFiles([]);
                    // NO llamar updateStats() para no sobrescribir con datos incorrectos
                }
            }
        }

        // ===================================
        // CARGAR ESTADÍSTICAS DESDE BACKEND
        // ===================================
        async function loadStatsFromBackend() {
            try {
                const response = await window.AppRouter.get('/routes/files/get_stats.php', {
                    params: {
                        user_id: isAdmin ? null : currentUserId // null = todas las stats (admin)
                    }
                });

                console.log('📊 Estadísticas recibidas del backend:', response);

                if (response.status === 'success' && response.stats) {
                    const stats = response.stats;

                    // Actualizar stats cards con datos del backend
                    document.getElementById('totalFiles').textContent = stats.total_files || 0;
                    document.getElementById('totalFolders').textContent = stats.total_folders || 0;

                    // Calcular storage usado
                    const totalBytes = stats.total_size || 0;
                    const usedGB = (totalBytes / (1024 * 1024 * 1024)).toFixed(2);
                    const maxGB = 10; // 10 GB máximo por usuario
                    const usedPercent = Math.min(((usedGB / maxGB) * 100), 100).toFixed(0);

                    document.getElementById('usedStorage').textContent = `${usedGB} GB`;
                    document.getElementById('storageProgress').style.width = `${usedPercent}%`;

                    // Actualizar progreso visual según porcentaje
                    const progressBar = document.getElementById('storageProgress');
                    progressBar.classList.remove('bg-success', 'bg-warning', 'bg-danger');
                    if (usedPercent < 50) {
                        progressBar.classList.add('bg-success');
                    } else if (usedPercent < 80) {
                        progressBar.classList.add('bg-warning');
                    } else {
                        progressBar.classList.add('bg-danger');
                    }

                    // Solo admin ve archivos compartidos
                    if (isAdmin) {
                        document.getElementById('sharedFiles').textContent = stats.shared_files || 0;
                    }

                    console.log('✅ Estadísticas actualizadas desde backend');
                } else {
                    console.warn('⚠️ Respuesta de stats sin datos, usando cálculo local');
                    updateStats();
                }
            } catch (error) {
                console.error('❌ Error al cargar estadísticas del backend:', error);
                // Fallback: Calcular stats localmente con datos disponibles
                updateStats();
            }
        }

        // ===================================
        // MOSTRAR LOADING
        // ===================================
        function showLoading() {
            const tbody = document.getElementById('filesTableBody');
            if (tbody) {
                tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-3 text-muted">Cargando archivos...</p>
                    </td>
                </tr>
            `;
            }
            console.log('⏳ Loading: Mostrando spinner en tabla');
        }

        // ===================================
        // OCULTAR LOADING
        // ===================================
        function hideLoading() {
            // El loading se elimina al renderizar archivos
            console.log('✅ Loading: Ocultado (será reemplazado por datos)');
        }

        // ===================================
        // OBTENER TIPO DE ARCHIVO DESDE MIME O EXTENSIÓN
        // ===================================
        function getFileTypeFromMime(mimeType, extension = '') {
            if (!mimeType && !extension) return 'other';

            // Normalizar extensión
            const ext = extension.toLowerCase().replace('.', '');

            // Imágenes
            if (mimeType.startsWith('image/')) return 'image';
            if (['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'bmp', 'ico'].includes(ext)) return 'image';

            // Videos
            if (mimeType.startsWith('video/')) return 'video';
            if (['mp4', 'avi', 'mov', 'webm', 'mkv', 'flv', 'wmv'].includes(ext)) return 'video';

            // Audio
            if (mimeType.startsWith('audio/')) return 'audio';
            if (['mp3', 'wav', 'ogg', 'aac', 'flac', 'm4a'].includes(ext)) return 'audio';

            // Documentos de texto
            if (mimeType.includes('pdf') || ext === 'pdf') return 'document';
            if (mimeType.includes('text') || ['txt', 'md', 'json', 'log', 'csv'].includes(ext)) return 'document';
            if (mimeType.includes('document') || mimeType.includes('word')) return 'document';
            if (mimeType.includes('spreadsheet') || mimeType.includes('excel')) return 'document';
            if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'odt', 'ods', 'odp'].includes(ext)) return 'document';

            // Archivos comprimidos
            if (mimeType.includes('zip') || mimeType.includes('rar') || mimeType.includes('7z')) return 'archive';
            if (['zip', 'rar', '7z', 'tar', 'gz', 'bz2'].includes(ext)) return 'archive';

            // Modelos 3D
            if (mimeType.includes('gltf') || mimeType.includes('glb') || mimeType.includes('obj')) return 'model';
            if (['gltf', 'glb', 'obj', 'fbx', 'dae', 'stl'].includes(ext)) return 'model';

            return 'other';
        }

        // ===================================
        // FORMATEAR TAMAÑO DE ARCHIVO
        // ===================================
        function formatFileSize(bytes) {
            if (!bytes || bytes === 0) return '0 B';

            const units = ['B', 'KB', 'MB', 'GB'];
            let size = bytes;
            let unitIndex = 0;

            while (size >= 1024 && unitIndex < units.length - 1) {
                size /= 1024;
                unitIndex++;
            }

            return `${size.toFixed(unitIndex > 0 ? 2 : 0)} ${units[unitIndex]}`;
        }

        // ===================================
        // DATOS DE DEMOSTRACIÓN (DESHABILITADO)
        // ===================================
        /* FUNCIÓN ELIMINADA: Ya no se usan datos de demostración
                function loadDemoFiles(role) {
                    const demoFiles = [
                        // =    ==== ROOT FOLDER =====
                        {    
                                id: 1,
                                name: 'Presentación HomeLab.pdf',
                                type: 'document',
                                extension: 'pdf',
                                size: '2.5 MB',
                                sizeBytes: 2621440,
                                date: '2025-11-04',
                                folder: 'root',
                              folderId: 'root',
                                 owner: 'Juan Pérez',
                                 ownerId: 1,
                                shared: false,
                                description: 'Presentación del proyecto HomeLab AR'
                        },    
                        {    
                                id: 2,
                                name: 'Logo HomeLab.png',
                                type: 'image',
                                extension: 'png',
                                size: '450 KB',
                              sizeBytes: 460800,
                                  date: '2025-11-03',
                                folder: 'root',
                                folderId: 'root',
                                owner: 'Juan Pérez',
                                ownerId: 1,
                                shared: false,
                                preview: 'https://via.placeholder.com/400x300/00ff88/ffffff?text=HomeLab+Logo'
                        },    
                        {    
                                id: 3,
                                name: 'Video Demo VR.mp4',
                                type: 'video',
                                extension: 'mp4',
                            size: '15.3 MB',
                                  sizeBytes: 16041779,
                                  date: '2025-11-02',
                                folder: 'root',
                                folderId: 'root',
                                owner: 'Juan Pérez',
                                ownerId: 1,
                                shared: true,
                                preview: 'https://storage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4'
                        },    
                        {    
                                id: 4,
                                name: 'Documentos',
                                type: 'folder',
                                size: '8 archivos',
                            date: '2025-11-01',
                                 folder: 'root',
                                   folderId: 'root',
                                owner: 'Juan Pérez',
                                ownerId: 1,
                                itemsCount: 8
                        },    
                        {    
                                id: 5,
                                name: 'Base de datos backup.sql',
                                type: 'archive',
                                extension: 'sql',
                            size: '8.2 MB',
                                 sizeBytes: 8601190,
                                   date: '2025-10-30',
                                folder: 'root',
                                folderId: 'root',
                                owner: 'Juan Pérez',
                                ownerId: 1,
                                shared: false
                        },    
                        {    
                                id: 6,
                                name: 'Música Ambiente.mp3',
                            type: 'audio',
                 
                                   size: '3.8 MB',
                                sizeBytes: 3984691,
                                date: '2025-10-28',
                                folder: 'root',
                                folderId: 'root',
                                owner: 'Juan Pérez',
                                ownerId: 1,
                                shared: false,
                                preview: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3'
                        },    
                        {    
                                id: 9,
                                name: 'Modelos 3D',
                                type: 'folder',
                             size: '5 archivos',
                                 date: '2025-10-27',
                                  folder: 'root',
                                folderId: 'root',
                                owner: 'Juan Pérez',
                                ownerId: 1,
                                itemsCount: 5
                        },    
                        {    
                                id: 10,
                                name: 'Multimedia',
                                type: 'folder',
                                size: '12 archivos',
                                date: '2025-10-26',
                                folder: 'root',
                            folderId: 'root',
                                    owner: 'Juan Pérez',
                                ownerId: 1,
                                itemsCount: 12
                        },    
                
                        // =    ==== DOCUMENTOS FOLDER (id: 4) =====
                        {    
                                id: 41,
                                name: 'Manual Usuario.pdf',
                                type: 'document',
                                extension: 'pdf',
                                size: '3.2 MB',
                             sizeBytes: 3355443,
                                  date: '2025-11-01',
                                 folder: 'Documentos',
                                folderId: 4,
                                owner: 'Juan Pérez',
                                ownerId: 1,
                                shared: false
                        },    
                        {    
                                id: 42,
                                name: 'Especificaciones.docx',
                                type: 'document',
                              extension: 'docx',
                                 size: '1.5 MB',
                                 sizeBytes: 1572864,
                                date: '2025-10-30',
                                folder: 'Documentos',
                                folderId: 4,
                                owner: 'Juan Pérez',
                                ownerId: 1,
                                shared: false
                        },    
                        {    
                                id: 43,
                              name: 'Presupuesto.xlsx',
                  
                                extension: 'xlsx',
                             size: '890 KB',
                                   sizeBytes: 911974,
                                date: '2025-10-29',
                                folder: 'Documentos',
                                folderId: 4,
                                owner: 'Juan Pérez',
                                ownerId: 1,
                                shared: false
                        },    
                        {    
                                id: 44,
                                name: 'Contratos',
                                type: 'folder',
                               size: '4 archivos',
                                 date: '2025-10-28',
                                folder: 'Documentos',
                                folderId: 4,
                                owner: 'Juan Pérez',
                                ownerId: 1,
                                itemsCount: 4
                        },    
                        {    
                                id: 45,
                                name: 'Facturas',
                                type: 'folder',
                                size: '15 archivos',
                                date: '2025-10-27',
                            folder: 'Documentos',
                  
                                  owner: 'Juan Pérez',
                              ownerId: 1,
                                  itemsCount: 15
                        },    
                
                        // =    ==== DOCUMENTOS/CONTRATOS FOLDER (id: 44) =====
                        {    
                                id: 441,
                                name: 'Contrato Proyecto A.pdf',
                                type: 'document',
                                extension: 'pdf',
                                size: '2.1 MB',
                                sizeBytes: 2202010,
                                date: '2025-10-28',
                                folder: 'Contratos',
                               folderId: 44,
                                 owner: 'Juan Pérez',
                                ownerId: 1,
                                shared: false
                        },    
                        {    
                                id: 442,
                                name: 'Contrato Proveedor.pdf',
                                type: 'document',
                                extension: 'pdf',
                                size: '1.8 MB',
                                sizeBytes: 1887437,
                                date: '2025-10-27',
                                folder: 'Contratos',
                            folderId: 44,
                                 owner: 'Juan Pérez',
                                   ownerId: 1,
                                shared: false
                        },    
                
                        // =    ==== MODELOS 3D FOLDER (id: 9) =====
                        {    
                                id: 91,
                                name: 'Servidor HomeLab.gltf',
                                type: 'model',
                                extension: 'gltf',
                                size: '5.4 MB',
                                sizeBytes: 5662310,
                               date: '2025-10-27',
                               folder: 'Modelos 3D',
                                  folderId: 9,
                                owner: 'Juan Pérez',
                                ownerId: 1,
                                shared: true,
                                preview: 'https://threejs.org/examples/models/gltf/DamagedHelmet/glTF/DamagedHelmet.gltf'
                        },    
                        {    
                                id: 92,
                                name: 'Router Virtualizado.glb',
                                type: 'model',
                                extension: 'glb',
                            size: '3.2 MB',
                                    sizeBytes: 3355443,
                               date: '2025-10-26',
                                 folder: 'Modelos 3D',
                                folderId: 9,
                                owner: 'Juan Pérez',
                                ownerId: 1,
                                shared: true
                        },    
                        {    
                                id: 93,
                                name: 'Edificio Campus.obj',
                                type: 'model',
                                extension: 'obj',
                                size: '8.7 MB',
                                sizeBytes: 9126805,
                            date: '2025-10-25',
                                 folder: 'Modelos 3D',
                                   folderId: 9,
                                owner: 'Juan Pérez',
                                ownerId: 1,
                                shared: false
                        },    
                        {    
                                id: 94,
                                name: 'Assets VR',
                                type: 'folder',
                                size: '8 archivos',
                                date: '2025-10-24',
                                folder: 'Modelos 3D',
                                folderId: 9,
                              owner: 'Juan Pérez',
                               ownerId: 1,
                                   itemsCount: 8
                        },    
                
                        // =    ==== MULTIMEDIA FOLDER (id: 10) =====
                        {    
                                id: 101,
                                name: 'Tutorial AR.mp4',
                                type: 'video',
                                extension: 'mp4',
                                size: '45.2 MB',
                            sizeBytes: 47399014,
                                 date: '2025-10-26',
                                   folder: 'Multimedia',
                                folderId: 10,
                                owner: 'Juan Pérez',
                                ownerId: 1,
                                shared: true,
                                preview: 'https://storage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4'
                        },    
                        {    
                                id: 102,
                                name: 'Música de Fondo.mp3',
                            type: 'audio',
                                  extension: 'mp3',
                                  size: '4.5 MB',
                                sizeBytes: 4718592,
                                date: '2025-10-25',
                                folder: 'Multimedia',
                                folderId: 10,
                                owner: 'Juan Pérez',
                                ownerId: 1,
                                shared: false,
                                preview: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3'
                        },    
                            {
                              id: 103,
                 
                                 type: 'folder',
                            s    ize: '20 archivos',
                                date: '2025-10-24',
                                folder: 'Multimedia',
                                folderId: 10,
                                owner: 'Juan Pérez',
                                ownerId: 1,
                                itemsCount: 20
                        },    
                        {    
                                id: 104,
                                name: 'Videos Tutoriales',
                                type: 'folder',
                                size: '6 archivos',
                                date: '2025-10-23',
                                folder: 'Multimedia',
                                folderId: 10,
                                owner: 'Juan Pérez',
                                ownerId: 1,
                                itemsCount: 6
                        },    
                        {    
                                id: 105,
                                name: 'Capturas Pantalla',
                                type: 'folder',
                                size: '30 archivos',
                                date: '2025-10-22',
                                folder: 'Multimedia',
                            folderId: 10,
                                  owner: 'Juan Pérez',
                 
                                 itemsCount: 30
                            }
                        ];
                
                    // Si es admin, agregar archivos de otros usuarios
                            if (role === 'admin') {
           
                                 id: 7,
                                name: 'Reporte Usuario 2.xlsx',
                                type: 'document',
                                extension: 'xlsx',
                                size: '890 KB',
                                sizeBytes: 911974,
         
                                   folder: 'root',
                                folderId: 'root',
                                owner: 'María García',
                                ownerId: 2,
           
                             }, {
                                id: 8,
                                name: 'Proyecto Cliente.zip',
                                type: 'archive',
                                extension: 'zip',
                                size: '25.6 MB',
                                
                                date: '2025-10-29',
                                folder: 'root',
                                folderId: 'root',
                              owner: 'Carlos López',
              
                                shared: false
                            });
                    }    
                
                        allFilesData = demoFiles;
                        filterFilesByFolder(currentFolder);
                        updateBreadcrumb();
                        updateStats();
                    }
                */

        // ===================================
        // FILTRAR ARCHIVOS POR CARPETA
        // ===================================
        function filterFilesByFolder(folderId) {
            console.log('🔍 Filtrando archivos para carpeta:', folderId);
            console.log('📊 Total de archivos en sistema:', allFilesData.length);

            // CRÍTICO: Si estamos en root, también mostrar las carpetas de allFoldersData
            if (folderId === 'root') {
                // Combinar carpetas + archivos de root
                const rootFiles = allFilesData.filter(file => file.folderId == folderId && file.type !== 'folder');

                // FILTRAR CARPETAS SEGÚN ROL
                let visibleFolders = [];
                if (isAdmin) {
                    // Admin: Mostrar todas las carpetas
                    visibleFolders = allFoldersData;
                    console.log('👔 Admin: Mostrando todas las carpetas en root');
                } else {
                    // Usuario normal: Solo carpetas propias
                    visibleFolders = allFoldersData.filter(f => f.ownerId == currentUserId);
                    console.log('👤 Usuario: Mostrando solo carpetas propias en root');
                }

                filesData = [...visibleFolders, ...rootFiles];
                console.log(
                    `📂 Root: ${visibleFolders.length} carpetas + ${rootFiles.length} archivos = ${filesData.length} items`
                );
            } else {
                // En carpetas, solo mostrar archivos (no subcarpetas por ahora)
                filesData = allFilesData.filter(file => file.folderId == folderId);
                console.log(`📂 Carpeta ${folderId}: ${filesData.length} archivos`);
            }

            console.log('📋 Lista de archivos:', filesData.map(f => `${f.name} (${f.type})`));

            renderFiles(filesData);
        }

        // ===================================
        // RENDERIZAR ARCHIVOS (SOLO VISTA DE LISTA)
        // ===================================
        function renderFiles(files) {
            // Usar vista de lista
            renderListView(files);

            // Ocultar loading
            hideLoading();

            // Mostrar empty state si no hay archivos
            if (files.length === 0) {
                // Actualizar texto según si estamos en root o en carpeta
                if (currentFolder === 'root') {
                    document.getElementById('emptyStateTitle').textContent = 'No hay carpetas';
                    document.getElementById('emptyStateText').textContent =
                        'Crea tu primera carpeta para organizar tus archivos';
                    document.getElementById('emptyStateUploadBtn').classList.add('d-none');
                } else {
                    // Obtener nombre de carpeta actual
                    const currentFolderData = allFilesData.find(f => f.id == currentFolder && f.type === 'folder') ||
                        folderCache[currentFolder];
                    const folderName = currentFolderData ? currentFolderData.name : 'esta carpeta';

                    // MEJORA: Calcular total de archivos en esta carpeta
                    const totalFilesInFolder = allFilesData.filter(f => f.folderId == currentFolder && f.type !==
                        'folder').length;

                    if (totalFilesInFolder > 0) {
                        // Si ya hay archivos pero no se muestran por filtros
                        document.getElementById('emptyStateTitle').textContent =
                            `Carpeta "${folderName}" con ${totalFilesInFolder} archivo${totalFilesInFolder !== 1 ? 's' : ''}`;
                    } else {
                        // Carpeta realmente vacía
                        document.getElementById('emptyStateTitle').textContent = `Carpeta "${folderName}" vacía`;
                    }

                    document.getElementById('emptyStateText').textContent =
                        'Sube archivos aquí para comenzar a organizar tu contenido';
                    document.getElementById('emptyStateUploadBtn').classList.remove('d-none');
                }

                document.getElementById('emptyState')?.classList.remove('d-none');
            } else {
                document.getElementById('emptyState')?.classList.add('d-none');
            }
        }

        // ===================================
        // VISTA DE LISTA (ÚNICA VISTA DISPONIBLE)
        // ===================================
        function renderListView(files) {
            console.log('📋 renderListView: Iniciando con', files.length, 'archivos');

            const tbody = document.getElementById('filesTableBody');
            if (!tbody) {
                console.error('❌ renderListView: No se encontró #filesTableBody en el DOM');
                return;
            }

            console.log('✅ renderListView: tbody encontrado, generando HTML...');
            let html = '';

            files.forEach(file => {
                const icon = getFileIcon(file);
                const typeClass = `file-type-${file.type}`;
                const ownerBadge = isAdmin && file.ownerId !== currentUserId ?
                    `<span class="badge bg-secondary ms-2" style="font-size: 0.7rem;">${file.owner}</span>` :
                    '';

                // 🐛 DEBUG: Ver qué ID se asigna a cada archivo
                console.log(`📝 Renderizando fila: ID=${file.id}, Nombre="${file.name}", Tipo=${file.type}`);

                html += `
                <tr data-file-id="${file.id}" ${file.type === 'folder' ? `ondblclick="navigateToFolder(${file.id})" style="cursor: pointer;"` : `ondblclick="previewFile(${file.id})" style="cursor: pointer;"`}>
                    <td>
                        <div class="d-flex align-items-center">
                            <i class="bx ${icon} fs-4 ${typeClass} me-2"></i>
                            <div>
                                <div class="fw-semibold">${file.name}${ownerBadge}</div>
                                ${file.description ? `<small class="text-muted">${file.description}</small>` : ''}
                            </div>
                        </div>
                    </td>
                    <td>${file.size}</td>
                    <td><span class="badge bg-${getTypeBadgeColor(file.type)}">${getTypeLabel(file.type)}</span></td>
                    <td>${formatDate(file.date)}</td>
                    <td class="text-end">
                        <div class="btn-group btn-group-sm" onclick="event.stopPropagation();">
                            ${file.type === 'folder' ? `
                                <button class="btn btn-outline-primary" onclick="navigateToFolder(${file.id})" title="Abrir carpeta">
                                    <i class="bx bx-folder-open"></i>
                                </button>
                                <!-- Carpetas fijas: No se pueden editar ni eliminar -->
                            ` : `
                                <button class="btn btn-outline-primary" onclick="console.log('🔍 Click Ver - ID: ${file.id}, Nombre: ${file.name}, Tipo: ${file.type}'); previewFile(${file.id})" title="Vista previa">
                                    <i class="bx bx-show"></i>
                                </button>
                                <button class="btn btn-outline-secondary" onclick="editFile(${file.id})" title="Editar">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <button class="btn btn-outline-success" onclick="downloadFile(${file.id})" title="Descargar">
                                    <i class="bx bx-download"></i>
                                </button>
                                <button class="btn btn-outline-danger" onclick="deleteFile(${file.id})" title="Eliminar">
                                    <i class="bx bx-trash"></i>
                                </button>
                            `}
                        </div>
                    </td>
                </tr>
            `;
            });

            // Actualizar el DOM con todo el HTML generado
            tbody.innerHTML = html;
            console.log('✅ renderListView: Tabla actualizada con', files.length, 'filas');
        }

        // ===================================
        // FUNCIONES AUXILIARES
        // ===================================
        function getFileIcon(file) {
            const icons = {
                folder: 'bx-folder',
                image: 'bx-image',
                document: 'bx-file-blank',
                video: 'bx-video',
                audio: 'bx-music',
                archive: 'bx-archive',
                model: 'bx-cube-alt',
                other: 'bx-file'
            };
            return icons[file.type] || icons.other;
        }

        function getTypeBadgeColor(type) {
            const colors = {
                folder: 'warning',
                image: 'info',
                document: 'primary',
                video: 'danger',
                audio: 'success',
                archive: 'warning',
                model: 'purple',
                other: 'secondary'
            };
            return colors[type] || colors.other;
        }

        function getTypeLabel(type) {
            const labels = {
                folder: 'Carpeta',
                image: 'Imagen',
                document: 'Documento',
                video: 'Video',
                audio: 'Audio',
                archive: 'Archivo',
                model: 'Modelo 3D',
                other: 'Otro'
            };
            return labels[type] || labels.other;
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const today = new Date();
            const yesterday = new Date(today);
            yesterday.setDate(yesterday.getDate() - 1);

            if (date.toDateString() === today.toDateString()) {
                return 'Hoy';
            } else if (date.toDateString() === yesterday.toDateString()) {
                return 'Ayer';
            } else {
                return date.toLocaleDateString('es-ES', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            }
        }

        // ===================================
        // POBLAR SELECTORES DE CARPETAS
        // ===================================
        function populateFolderSelectors() {
            const uploadSelector = document.getElementById('uploadFolder');
            const editSelector = document.getElementById('editFileFolder');

            if (!uploadSelector || !editSelector) {
                console.warn('⚠️ Selectores de carpetas no encontrados en el DOM');
                return;
            }

            // CRÍTICO: Usar allFoldersData en lugar de allFilesData
            // allFoldersData se carga una sola vez y contiene todas las carpetas
            let availableFolders = [];

            if (isAdmin) {
                // Admin: Todas las carpetas de todos los usuarios
                availableFolders = allFoldersData;
                console.log('👔 Admin: Mostrando todas las carpetas de todos los usuarios');
            } else {
                // Usuario normal: Solo sus propias carpetas
                availableFolders = allFoldersData.filter(f => f.ownerId == currentUserId);
                console.log('👤 Usuario: Mostrando solo carpetas propias');
            }

            // Generar opciones HTML con nombre del dueño
            let uploadOptionsHTML = '<option value="" disabled selected>Selecciona una carpeta...</option>';
            let editOptionsHTML = '<option value="" disabled selected>Selecciona una carpeta...</option>';

            availableFolders.forEach(folder => {
                const ownerBadge = isAdmin && folder.ownerId !== currentUserId ?
                    ` (${folder.owner})` :
                    '';

                uploadOptionsHTML +=
                    `<option value="${folder.id}">📁 ${folder.name}${ownerBadge}</option>`;
                editOptionsHTML +=
                    `<option value="${folder.id}">📁 ${folder.name}${ownerBadge}</option>`;
            });

            uploadSelector.innerHTML = uploadOptionsHTML;
            editSelector.innerHTML = editOptionsHTML;

            console.log('📂 Selectores actualizados:', availableFolders.length, 'carpetas disponibles');
        }

        function updateStats() {
            // Calcular estadísticas con TODOS los archivos
            const totalFiles = allFilesData.filter(f => f.type !== 'folder').length;
            const totalFolders = allFilesData.filter(f => f.type === 'folder').length;
            const sharedFiles = allFilesData.filter(f => f.shared).length;

            // Calcular tamaño total
            const totalBytes = allFilesData.reduce((sum, f) => sum + (f.sizeBytes || 0), 0);
            const usedGB = (totalBytes / (1024 * 1024 * 1024)).toFixed(2);
            const maxGB = 10; // 10 GB máximo
            const usedPercent = ((usedGB / maxGB) * 100).toFixed(0);

            document.getElementById('totalFiles').textContent = totalFiles;
            document.getElementById('totalFolders').textContent = totalFolders;
            document.getElementById('usedStorage').textContent = `${usedGB} GB`;
            document.getElementById('storageProgress').style.width = `${usedPercent}%`;

            if (isAdmin) {
                document.getElementById('sharedFiles').textContent = sharedFiles;
            }
        }

        // ===================================
        // ACTUALIZAR BREADCRUMB
        // ===================================
        function updateBreadcrumb() {
            console.log('🍞 Actualizando breadcrumb para carpeta:', currentFolder);

            const breadcrumb = document.getElementById('folderBreadcrumb');
            if (!breadcrumb) {
                console.warn('⚠️ Elemento breadcrumb no encontrado');
                return;
            }

            // "Mis Archivos" siempre recarga la página para volver al inicio
            let html = `
            <li class="breadcrumb-item">
                <a href="/dashboard/files" class="text-decoration-none">
                    <i class="bx bx-home-alt me-1"></i>
                    Mis Archivos
                </a>
            </li>
        `;

            // Si estamos dentro de una carpeta, mostrar: nombre + dueño
            if (currentFolder !== 'root') {
                // Buscar info de la carpeta actual
                let currentFolderData = folderCache[currentFolder];

                // Si no está en caché, buscar en allFoldersData
                if (!currentFolderData) {
                    const folderInData = allFoldersData.find(f => f.id == currentFolder);
                    if (folderInData) {
                        currentFolderData = {
                            id: folderInData.id,
                            name: folderInData.name,
                            folderId: folderInData.folderId,
                            owner: folderInData.owner || 'Sin dueño'
                        };
                        // Actualizar caché
                        folderCache[currentFolder] = currentFolderData;
                    }
                }

                // Si aún no se encuentra, buscar en allFilesData
                if (!currentFolderData) {
                    const folderInFiles = allFilesData.find(f => f.id == currentFolder && f.type ===
                        'folder');
                    if (folderInFiles) {
                        currentFolderData = {
                            id: folderInFiles.id,
                            name: folderInFiles.name,
                            folderId: folderInFiles.folderId,
                            owner: folderInFiles.owner || 'Sin dueño'
                        };
                        folderCache[currentFolder] = currentFolderData;
                    }
                }

                if (currentFolderData) {
                    html += `
                    <li class="breadcrumb-item active" aria-current="page">
                        <i class="bx bx-folder me-1"></i>
                        ${currentFolderData.name}
                        <small class="text-muted ms-2">
                            <i class="bx bx-user-circle"></i>
                            ${currentFolderData.owner}
                        </small>
                    </li>
                `;
                    console.log('✅ Breadcrumb muestra carpeta:', currentFolderData.name, 'Dueño:',
                        currentFolderData.owner);
                } else {
                    // Fallback: mostrar el ID si no se encuentra el nombre
                    html += `
                    <li class="breadcrumb-item active" aria-current="page">
                        <i class="bx bx-folder me-1"></i>
                        Carpeta ${currentFolder}
                    </li>
                `;
                    console.warn('⚠️ Breadcrumb: No se encontró info de la carpeta', currentFolder);
                }
            }

            breadcrumb.innerHTML = html;
            console.log('✅ Breadcrumb actualizado');
        }

        // ===================================
        // CONSTRUIR RUTA DE CARPETAS - ELIMINADA
        // ===================================
        // Función eliminada porque ahora usamos un breadcrumb simplificado
        // que solo muestra: "Mis Archivos" > "Carpeta Actual"
        // Esto evita problemas de caché y es más confiable

        // ===================================
        // CALCULAR TAMAÑO DE CARPETAS
        // ===================================
        async function calculateFolderSizes() {
            console.log('📊 Calculando tamaños de carpetas...');

            // CRÍTICO: Actualizar tanto allFilesData como allFoldersData
            // porque filterFilesByFolder() usa allFoldersData en root

            // 1. Recorrer allFilesData por índice
            for (let i = 0; i < allFilesData.length; i++) {
                const item = allFilesData[i];

                // Solo procesar carpetas
                if (item.type !== 'folder') continue;

                try {
                    // Obtener todos los archivos de esta carpeta desde backend
                    const response = await window.AppRouter.get('/routes/files/list_files.php', {
                        params: {
                            folder_id: item.id,
                            user_id: currentUserId
                        }
                    });

                    if (response.status === 'success' && Array.isArray(response.files)) {
                        // Calcular tamaño total de archivos en la carpeta
                        const totalSize = response.files.reduce((sum, file) => {
                            return sum + (file.file_size || 0);
                        }, 0);

                        // ✅ CRÍTICO: Actualizar el objeto directamente en allFilesData por índice
                        allFilesData[i].sizeBytes = totalSize;
                        allFilesData[i].size = formatFileSize(totalSize);
                        allFilesData[i].itemsCount = response.files.length;

                        // ✅ CRÍTICO 2: También actualizar en allFoldersData (referencia al mismo objeto)
                        const folderIndex = allFoldersData.findIndex(f => f.id === item.id);
                        if (folderIndex !== -1) {
                            allFoldersData[folderIndex].sizeBytes = totalSize;
                            allFoldersData[folderIndex].size = formatFileSize(totalSize);
                            allFoldersData[folderIndex].itemsCount = response.files.length;
                        }

                        console.log(
                            `✅ Carpeta "${item.name}": ${allFilesData[i].size} (${allFilesData[i].itemsCount} archivos)`
                        );
                    } else {
                        // Sin archivos o error en respuesta
                        allFilesData[i].sizeBytes = 0;
                        allFilesData[i].size = '0 B';
                        allFilesData[i].itemsCount = 0;

                        // También actualizar allFoldersData
                        const folderIndex = allFoldersData.findIndex(f => f.id === item.id);
                        if (folderIndex !== -1) {
                            allFoldersData[folderIndex].sizeBytes = 0;
                            allFoldersData[folderIndex].size = '0 B';
                            allFoldersData[folderIndex].itemsCount = 0;
                        }
                    }
                } catch (error) {
                    console.error(`❌ Error al calcular tamaño de carpeta ${item.name}:`, error);
                    allFilesData[i].sizeBytes = 0;
                    allFilesData[i].size = '0 B';
                    allFilesData[i].itemsCount = 0;

                    // También actualizar allFoldersData en caso de error
                    const folderIndex = allFoldersData.findIndex(f => f.id === item.id);
                    if (folderIndex !== -1) {
                        allFoldersData[folderIndex].sizeBytes = 0;
                        allFoldersData[folderIndex].size = '0 B';
                        allFoldersData[folderIndex].itemsCount = 0;
                    }
                }
            }

            console.log('✅ Tamaños de carpetas calculados y actualizados en ambos arrays');
            console.log('🔍 DEBUG allFilesData:',
                allFilesData.filter(f => f.type === 'folder').map(f => ({
                    id: f.id,
                    name: f.name,
                    size: f.size
                }))
            );
            console.log('🔍 DEBUG allFoldersData:',
                allFoldersData.map(f => ({
                    id: f.id,
                    name: f.name,
                    size: f.size
                }))
            );

            // Re-renderizar si estamos en root para mostrar los tamaños actualizados
            if (currentFolder === 'root') {
                filterFilesByFolder('root');
            }
        }

        // ===================================
        // NAVEGAR A CARPETA
        // ===================================
        window.navigateToFolder = async function (folderId) {
            console.log('📂 Navegando a carpeta:', folderId);

            // CRÍTICO: Cargar archivos desde backend cuando navegamos a carpeta
            // No podemos solo filtrar los datos en memoria porque no tenemos
            // los archivos de dentro de las carpetas hasta que las abramos
            await loadFilesFromBackend(folderId);

            updateBreadcrumb();

            // Scroll to top
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // ===================================
        // FUNCIONES CRUD (PREPARADAS PARA BACKEND)
        // ===================================
        window.uploadFile = async function () {
            const fileInput = document.getElementById('fileInput');
            const files = fileInput.files;

            if (files.length === 0) {
                if (window.Notyf) {
                    new Notyf().error('Por favor selecciona al menos un archivo');
                } else {
                    alert('Por favor selecciona al menos un archivo');
                }
                return;
            }

            // ✅ VALIDACIÓN: Tamaño máximo de archivo (50 MB)
            const maxSizeBytes = 50 * 1024 * 1024;
            const fileSize = files[0].size;
            const fileSizeMB = (fileSize / (1024 * 1024)).toFixed(2);

            if (fileSize > maxSizeBytes) {
                const maxSizeMB = (maxSizeBytes / (1024 * 1024)).toFixed(0);

                if (window.Notyf) {
                    new Notyf().error(
                        `Archivo demasiado grande (${fileSizeMB} MB). ` +
                        `Tamaño máximo permitido: ${maxSizeMB} MB`
                    );
                } else {
                    alert(
                        `Archivo demasiado grande (${fileSizeMB} MB). ` +
                        `Tamaño máximo permitido: ${maxSizeMB} MB`
                    );
                }
                return;
            }

            const formData = new FormData();
            const folderId = document.getElementById('uploadFolder').value;

            // CRÍTICO: Validar que se haya seleccionado una carpeta
            // No se permite subir archivos en root
            if (!folderId || folderId === '' || folderId === 'root') {
                if (window.Notyf) {
                    new Notyf().error(
                        'Debes seleccionar una carpeta de destino. No se pueden subir archivos en la raíz.'
                    );
                } else {
                    alert('Debes seleccionar una carpeta de destino.');
                }
                return;
            }

            // Backend espera 'file' en singular (solo el primer archivo por ahora)
            formData.append('file', files[0]);
            formData.append('folder_id', folderId);
            formData.append('user_id', currentUserId);

            // ✅ AGREGAR DESCRIPCIÓN del archivo si existe
            // CRÍTICO: El ID correcto es 'fileDescription' (del modal)
            const description = document.getElementById('fileDescription')?.value?.trim() || '';
            if (description) {
                formData.append('description', description);
            }

            if (isAdmin && document.getElementById('shareWithAll')) {
                formData.append('is_shared', document.getElementById('shareWithAll').checked ? '1' :
                    '0');
            }

            console.log('📤 Subiendo archivo:', files[0].name);
            console.log('📁 Carpeta destino:', folderId || 'root (sin carpeta)');
            console.log('👤 Usuario:', currentUserId);
            console.log('📝 Descripción:', description || '(sin descripción)');

            // DEBUG: Ver contenido de FormData
            console.log('📦 FormData contenido:');
            for (let [key, value] of formData.entries()) {
                if (key === 'file') {
                    console.log(`  ${key}:`, value.name, `(${value.size} bytes)`);
                } else {
                    console.log(`  ${key}:`, value);
                }
            }

            // Mostrar progreso
            document.getElementById('uploadProgressDiv').classList.remove('d-none');

            try {
                // Llamada al backend real con seguimiento de progreso
                const response = await window.AppRouter.upload('/routes/files/upload_file.php',
                    formData, {
                    onUploadProgress: (percent) => {
                        document.getElementById('uploadProgressBar').style.width = percent +
                            '%';
                        document.getElementById('uploadProgressBar').textContent = percent +
                            '%';
                    }
                });

                console.log('✅ Archivo subido:', response);

                // Cerrar modal y resetear formulario
                bootstrap.Modal.getInstance(document.getElementById('uploadFileModal')).hide();
                document.getElementById('uploadFileForm').reset();
                document.getElementById('uploadProgressDiv').classList.add('d-none');

                // Mostrar notificación
                if (window.Notyf) {
                    new Notyf().success('Archivo subido exitosamente');
                }

                // Recargar archivos
                await loadFilesFromBackend(currentFolder);

            } catch (error) {
                console.error('❌ Error al subir archivo:', error);

                // Ocultar progreso
                document.getElementById('uploadProgressDiv').classList.add('d-none');

                // Mostrar error
                if (window.Notyf) {
                    new Notyf().error(error.message || 'Error al subir archivo');
                }
            }
        };

        window.createFolder = async function () {
            const folderName = document.getElementById('folderName').value.trim();

            if (!folderName) {
                if (window.Notyf) {
                    new Notyf().error('El nombre de la carpeta es requerido');
                }
                return;
            }

            const data = {
                name: folderName,
                parent_folder: document.getElementById('parentFolder').value,
                description: document.getElementById('folderDescription').value,
                user_id: currentUserId
            };

            try {

                const response = await window.AppRouter.post('/routes/files/create_folder.php', data);

                console.log('✅ Carpeta creada:', response);

                bootstrap.Modal.getInstance(document.getElementById('createFolderModal')).hide();
                document.getElementById('createFolderForm').reset();

                if (window.Notyf) {
                    new Notyf().success('Carpeta creada exitosamente');
                }

                await loadFilesFromBackend(currentFolder);

            } catch (error) {
                console.error('Error al crear carpeta:', error);
                if (window.Notyf) {
                    new Notyf().error('Error al crear carpeta');
                }
            }
        };

        window.editFile = function (fileId) {
            const file = filesData.find(f => f.id === fileId);
            if (!file) return;

            // Verificar permisos
            if (!isAdmin && file.ownerId !== currentUserId) {
                if (window.Notyf) {
                    new Notyf().error('No tienes permisos para editar este archivo');
                }
                return;
            }

            document.getElementById('editFileId').value = file.id;
            document.getElementById('editFileName').value = file.name;
            document.getElementById('editFileDescription').value = file.description || '';
            document.getElementById('editFileFolder').value = file.folder;

            const modal = new bootstrap.Modal(document.getElementById('editFileModal'));
            modal.show();
        };

        window.saveFileChanges = async function () {
            const fileId = document.getElementById('editFileId').value;
            const data = {
                file_id: fileId,
                filename: document.getElementById('editFileName').value,
                description: document.getElementById('editFileDescription').value,
                folder_id: document.getElementById('editFileFolder').value === 'root' ? null : document
                    .getElementById('editFileFolder').value,
                user_id: currentUserId
            };

            try {
                const response = await window.AppRouter.put('/routes/files/update_file.php', data);

                console.log('✅ Archivo actualizado:', response);

                bootstrap.Modal.getInstance(document.getElementById('editFileModal')).hide();

                if (window.Notyf) {
                    new Notyf().success(response.message || 'Archivo actualizado exitosamente');
                }

                // Recargar archivos
                await loadFilesFromBackend(currentFolder);

            } catch (error) {
                console.error('Error al actualizar archivo:', error);
                if (window.Notyf) {
                    new Notyf().error(error.message || 'Error al actualizar archivo');
                }
            }
        };

        window.deleteFile = async function (fileId) {
            // ✅ FIX: Buscar en filesData en lugar de allFilesData
            const file = filesData.find(f => f.id === fileId);
            if (!file) {
                console.error('❌ Archivo no encontrado para eliminar:', fileId);
                return;
            }

            // Verificar permisos
            if (!isAdmin && file.ownerId !== currentUserId) {
                if (window.Notyf) {
                    new Notyf().error('No tienes permisos para eliminar este archivo');
                }
                return;
            }

            const isFolder = file.type === 'folder';
            const confirmed = await Swal.fire({
                title: `¿Eliminar ${isFolder ? 'carpeta' : 'archivo'}?`,
                text: isFolder ? 'Se eliminarán todos los archivos dentro de la carpeta' :
                    'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#dc3545'
            });

            if (!confirmed.isConfirmed) return;

            try {
                // Llamada al backend real
                // CRÍTICO: Enviar type para que el backend sepa si es carpeta o archivo
                const response = await window.AppRouter.delete('/routes/files/delete_file.php', {
                    params: {
                        file_id: fileId,
                        user_id: currentUserId,
                        type: file.type // 'folder' o 'file', 'image', etc.
                    }
                });

                console.log('✅ Archivo eliminado:', response);

                if (window.Notyf) {
                    new Notyf().success(response.message ||
                        `${isFolder ? 'Carpeta' : 'Archivo'} eliminado exitosamente`);
                }

                // Recargar archivos desde backend
                await loadFilesFromBackend(currentFolder);

            } catch (error) {
                console.error('❌ Error al eliminar archivo:', error);
                if (window.Notyf) {
                    new Notyf().error(error.message || 'Error al eliminar archivo');
                }
            }
        };

        window.downloadFile = function (fileId) {
            // ✅ FIX: Buscar en filesData en lugar de allFilesData
            const file = filesData.find(f => f.id === fileId && f.type !== 'folder');
            if (!file) {
                console.error('❌ Archivo no encontrado para descargar:', fileId);
                return;
            }

            console.log('📥 Descargando archivo:', file.name);

            // Descarga real desde backend
            const downloadUrl =
                `${window.ENV_CONFIG.BACKEND_URL}/routes/files/download_file.php?file_id=${fileId}&user_id=${currentUserId}`;

            // Abrir en nueva pestaña para iniciar descarga
            window.open(downloadUrl, '_blank');

            if (window.Notyf) {
                new Notyf().success(`Descargando ${file.name}...`);
            }
        };

        window.previewFile = function (fileId) {
            console.log('🔍 previewFile llamado con ID:', fileId);
            console.log('📊 Total en allFilesData:', allFilesData.length);
            console.log('📊 Total en filesData (solo vista actual):', filesData.length);

            // ✅ FIX: Buscar SOLO en filesData (archivos del folder actual) en lugar de allFilesData (que incluye carpetas)
            const file = filesData.find(f => f.id == fileId && f.type !== 'folder');

            if (!file) {
                console.error('❌ Archivo no encontrado con ID:', fileId);
                console.log('📋 IDs en filesData:', filesData.map(f => ({
                    id: f.id,
                    name: f.name,
                    type: f.type
                })));
                if (window.Notyf) {
                    new Notyf().error('Archivo no encontrado');
                }
                return;
            }

            // 🐛 DEBUG: Ver estructura completa del archivo
            console.log('✅ Archivo encontrado en filesData:', file);
            console.log('🔍 DEBUG: file.type =', file.type);
            console.log('🔍 DEBUG: file.extension =', file.extension);
            console.log('🔍 DEBUG: file.name =', file.name);

            if (file.type === 'folder') {
                console.warn('⚠️ No se puede previsualizar una carpeta');
                console.warn('🔍 DEBUG: Este es el objeto que se detectó como carpeta:', file);
                return;
            }

            console.log('✅ Archivo encontrado:', file.name, 'Tipo:', file.type, 'Extensión:', file.extension);

            const modal = new bootstrap.Modal(document.getElementById('filePreviewModal'));
            const content = document.getElementById('filePreviewContent');
            const title = document.getElementById('previewFileName');

            title.innerHTML = `<i class="bx ${getFileIcon(file)} me-2"></i>${file.name}`;

            // CRÍTICO: Construir URL real del archivo desde backend
            const fileUrl =
                `${window.ENV_CONFIG.BACKEND_URL}/routes/files/download_file.php?file_id=${file.id}&user_id=${currentUserId}&inline=1`;

            console.log('🖼️ Preview URL:', fileUrl);
            console.log('📄 Tipo de archivo:', file.type);
            console.log('📝 Extensión:', file.extension);

            // Generar vista previa según tipo
            if (file.type === 'image') {
                // Soporte para: JPG, JPEG, PNG, GIF, SVG, WebP
                content.innerHTML = `
                <div class="text-center position-relative" id="imagePreviewContainer">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Cargando imagen...</span>
                    </div>
                    <p class="text-muted">Cargando imagen ${file.extension.toUpperCase()}...</p>
                    <img src="${fileUrl}" 
                         class="img-fluid rounded shadow d-none" 
                         alt="${file.name}"
                         id="previewImage"
                         style="max-height: 70vh; object-fit: contain;">
                </div>
            `;

                // Manejar carga exitosa o error con diseño elegante
                const img = document.getElementById('previewImage');
                const container = document.getElementById('imagePreviewContainer');

                img.onload = function () {
                    container.innerHTML = '';
                    container.appendChild(img);
                    img.classList.remove('d-none');
                    console.log('✅ Imagen cargada:', file.name);
                };

                img.onerror = function () {
                    console.error('❌ Error al cargar imagen:', file.name);
                    container.innerHTML = `
                    <div class="py-5">
                        <div class="mb-4">
                            <i class="bx bx-error-circle display-1 text-warning"></i>
                        </div>
                        <h5 class="text-muted mb-3">No se pudo cargar la imagen</h5>
                        <div class="alert alert-warning d-inline-block">
                            <i class="bx bx-info-circle me-2"></i>
                            El archivo existe pero no se puede visualizar en este momento
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-primary" onclick="downloadFile(${file.id})">
                                <i class="bx bx-download me-2"></i>
                                Descargar Archivo
                            </button>
                            <button class="btn btn-outline-secondary ms-2" onclick="location.reload()">
                                <i class="bx bx-refresh me-2"></i>
                                Reintentar
                            </button>
                        </div>
                        <small class="text-muted d-block mt-3">
                            Archivo: ${file.name} (${file.size})
                        </small>
                    </div>
                `;
                };
            } else if (file.type === 'video') {
                // Soporte para: MP4, AVI, MOV, WebM
                const videoType = file.extension === 'mp4' ? 'video/mp4' :
                    file.extension === 'webm' ? 'video/webm' :
                        file.extension === 'avi' ? 'video/x-msvideo' :
                            file.extension === 'mov' ? 'video/quicktime' : 'video/mp4';

                content.innerHTML = `
                <div class="d-flex flex-column align-items-center justify-content-center py-4">
                    <video controls class="w-100 rounded shadow" style="max-height: 70vh;" preload="metadata">
                        <source src="${fileUrl}" type="${videoType}">
                        Tu navegador no soporta la reproducción de video ${file.extension.toUpperCase()}.
                    </video>
                    <div class="mt-3 text-muted">
                        <i class="bx bx-video me-2"></i>
                        ${file.name} • ${file.size}
                    </div>
                </div>
            `;
                console.log('🎬 Video cargado:', file.name, 'Tipo:', videoType);
            } else if (file.type === 'audio') {
                // Soporte para: MP3, WAV, OGG, AAC
                const audioType = file.extension === 'mp3' ? 'audio/mpeg' :
                    file.extension === 'wav' ? 'audio/wav' :
                        file.extension === 'ogg' ? 'audio/ogg' :
                            file.extension === 'aac' ? 'audio/aac' : 'audio/mpeg';

                content.innerHTML = `
                <div class="d-flex flex-column align-items-center justify-content-center py-5">
                    <i class="bx bx-music display-1 text-primary mb-4" style="font-size: 6rem;"></i>
                    <h4>${file.name}</h4>
                    <p class="text-muted mb-4">${file.size} • ${formatDate(file.date)}</p>
                    <audio controls class="w-75" preload="metadata" style="width: 100%; max-width: 500px;">
                        <source src="${fileUrl}" type="${audioType}">
                        Tu navegador no soporta la reproducción de audio ${file.extension.toUpperCase()}.
                    </audio>
                    <div class="mt-3">
                        <span class="badge bg-success">
                            <i class="bx bx-play-circle me-1"></i>
                            ${file.extension.toUpperCase()}
                        </span>
                    </div>
                </div>
            `;
                console.log('🎵 Audio cargado:', file.name, 'Tipo:', audioType);
            } else if (file.type === 'document' && ['txt', 'md', 'json', 'log', 'csv'].includes(file.extension)) {
                // ✅ Soporte para archivos de texto: TXT, MD, JSON, LOG, CSV
                console.log('📝 Cargando archivo de texto:', file.extension);

                content.innerHTML = `
                <div class="text-start p-4" id="textPreviewContainer">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando texto...</span>
                        </div>
                        <p class="text-muted mt-2">Cargando contenido del archivo...</p>
                    </div>
                </div>
            `;

                // Función auxiliar para escapar HTML
                function escapeHtml(text) {
                    const div = document.createElement('div');
                    div.textContent = text;
                    return div.innerHTML;
                }

                // Cargar contenido del archivo de texto
                fetch(fileUrl, {
                    credentials: 'include', // ✅ CRÍTICO: Enviar cookies de sesión para autenticación
                    method: 'GET'
                })
                    .then(response => {
                        console.log('📡 Fetch status:', response.status, response.statusText);
                        if (!response.ok) {
                            throw new Error(`Error ${response.status}: ${response.statusText}`);
                        }
                        return response.text();
                    })
                    .then(text => {
                        const container = document.getElementById('textPreviewContainer');
                        console.log('✅ Contenido cargado:', text.length, 'caracteres');

                        if (file.extension === 'json') {
                            // JSON: Formatear y validar
                            try {
                                const jsonObj = JSON.parse(text);
                                const formattedJson = JSON.stringify(jsonObj, null, 2);
                                container.innerHTML = `
                                <div class="card">
                                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bx bx-code-curly me-2"></i>
                                            ${file.name}
                                        </div>
                                        <span class="badge bg-light text-dark">JSON Válido</span>
                                    </div>
                                    <div class="card-body" style="max-height: 60vh; overflow-y: auto; background-color: var(--bs-secondary-bg); color: var(--bs-body-color);">
                                        <pre class="mb-0" style="white-space: pre; font-family: 'Courier New', monospace; font-size: 0.85rem; color: var(--bs-body-color);">${escapeHtml(formattedJson)}</pre>
                                    </div>
                                    <div class="card-footer text-muted">
                                        <small>
                                            <i class="bx bx-check-circle me-1 text-success"></i>
                                            JSON válido • ${Object.keys(jsonObj).length} propiedades • ${file.size}
                                        </small>
                                    </div>
                                </div>
                            `;
                            } catch (e) {
                                console.warn('⚠️ JSON inválido:', e);
                                container.innerHTML = `
                                <div class="card">
                                    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bx bx-code-curly me-2"></i>
                                            ${file.name}
                                        </div>
                                        <span class="badge bg-danger">JSON Inválido</span>
                                    </div>
                                    <div class="card-body" style="max-height: 60vh; overflow-y: auto; background-color: var(--bs-secondary-bg); color: var(--bs-body-color);">
                                        <div class="alert alert-warning mb-3">
                                            <i class="bx bx-error-circle me-2"></i>
                                            <strong>Error de sintaxis:</strong> ${e.message}
                                        </div>
                                        <pre class="mb-0" style="white-space: pre-wrap; word-wrap: break-word; font-family: 'Courier New', monospace; font-size: 0.85rem; color: var(--bs-body-color);">${escapeHtml(text)}</pre>
                                    </div>
                                </div>
                            `;
                            }
                        } else if (file.extension === 'md') {
                            // Markdown: Mostrar con formato básico
                            container.innerHTML = `
                            <div class="card">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bx bxl-markdown me-2"></i>
                                        ${file.name}
                                    </div>
                                    <span class="badge bg-light text-dark">Markdown</span>
                                </div>
                                <div class="card-body" style="max-height: 60vh; overflow-y: auto; background-color: var(--bs-secondary-bg); color: var(--bs-body-color);">
                                    <pre class="mb-0" style="white-space: pre-wrap; word-wrap: break-word; font-family: 'Courier New', monospace; font-size: 0.9rem; color: var(--bs-body-color);">${escapeHtml(text)}</pre>
                                </div>
                                <div class="card-footer text-muted">
                                    <small>
                                        <i class="bx bx-info-circle me-1"></i>
                                        ${text.split('\n').length} líneas • ${file.size}
                                    </small>
                                </div>
                            </div>
                        `;
                        } else {
                            // TXT, LOG, CSV: Mostrar como texto plano
                            const headerColors = {
                                'txt': 'bg-secondary',
                                'log': 'bg-info',
                                'csv': 'bg-success'
                            };
                            const icons = {
                                'txt': 'bx-file',
                                'log': 'bx-list-ul',
                                'csv': 'bx-spreadsheet'
                            };
                            const headerColor = headerColors[file.extension] || 'bg-secondary';
                            const icon = icons[file.extension] || 'bx-file';

                            container.innerHTML = `
                            <div class="card">
                                <div class="card-header ${headerColor} text-white d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bx ${icon} me-2"></i>
                                        ${file.name}
                                    </div>
                                    <span class="badge bg-light text-dark">${file.extension.toUpperCase()}</span>
                                </div>
                                <div class="card-body" style="max-height: 60vh; overflow-y: auto; background-color: var(--bs-secondary-bg); color: var(--bs-body-color);">
                                    <pre class="mb-0" style="white-space: pre-wrap; word-wrap: break-word; font-family: 'Courier New', monospace; font-size: 0.9rem; color: var(--bs-body-color);">${escapeHtml(text)}</pre>
                                </div>
                                <div class="card-footer text-muted">
                                    <small>
                                        <i class="bx bx-info-circle me-1"></i>
                                        ${text.split('\n').length} líneas • ${file.size}
                                    </small>
                                </div>
                            </div>
                        `;
                        }
                        console.log('✅ Texto renderizado:', file.name);
                    })
                    .catch(error => {
                        console.error('❌ Error al cargar texto:', error);
                        document.getElementById('textPreviewContainer').innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bx bx-error-circle me-2"></i>
                            <strong>Error:</strong> No se pudo cargar el contenido del archivo.
                        </div>
                        <button class="btn btn-primary" onclick="downloadFile(${file.id})">
                            <i class="bx bx-download me-2"></i>
                            Descargar Archivo
                        </button>
                    `;
                    });
            } else if (file.type === 'model') {
                content.innerHTML = `
                <div class="d-flex flex-column align-items-center justify-content-center py-5">
                    <i class="bx bx-cube-alt display-1 text-info mb-4" style="font-size: 8rem;"></i>
                    <h4>${file.name}</h4>
                    <p class="text-muted mb-3">${file.size} • Modelo 3D ${file.extension.toUpperCase()}</p>
                    <div class="alert alert-info">
                        <i class="bx bx-info-circle me-2"></i>
                        <strong>Vista previa 3D:</strong> Descarga el archivo para visualizarlo en un visor compatible
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary me-2" onclick="downloadFile(${file.id})">
                            <i class="bx bx-download me-2"></i>
                            Descargar Modelo
                        </button>
                        <button class="btn btn-outline-secondary" onclick="window.open('https://threejs.org/editor/', '_blank')">
                            <i class="bx bx-link-external me-2"></i>
                            Abrir en Three.js Editor
                        </button>
                    </div>
                </div>
            `;
            } else if (file.type === 'document' && file.extension === 'pdf') {
                // ✅ Vista previa de PDF con iframe mejorada
                console.log('📄 Cargando PDF:', file.name);
                content.innerHTML = `
                <div class="pdf-preview-container">
                    <div class="d-flex justify-content-between align-items-center mb-3 px-3">
                        <h5 class="mb-0">
                            <i class="bx bxs-file-pdf me-2 text-danger"></i>
                            ${file.name}
                        </h5>
                        <div>
                            <button class="btn btn-sm btn-outline-primary me-2" onclick="window.open('${fileUrl}', '_blank')" title="Abrir en nueva pestaña">
                                <i class="bx bx-link-external me-1"></i>
                                Abrir
                            </button>
                            <span class="badge bg-danger">${file.extension.toUpperCase()}</span>
                        </div>
                    </div>
                    <iframe src="${fileUrl}" 
                            width="100%" 
                            height="600px" 
                            frameborder="0"
                            class="rounded shadow"
                            style="border: 1px solid #dee2e6;">
                    </iframe>
                    <div class="text-muted text-center py-2">
                        <small>
                            <i class="bx bx-info-circle me-1"></i>
                            ${file.size} • ${formatDate(file.date)}
                        </small>
                    </div>
                </div>
            `;
                console.log('✅ PDF cargado en iframe');
            } else {
                // Archivos sin vista previa
                console.log('⚠️ Sin vista previa para:', file.type, file.extension);
                content.innerHTML = `
                <div class="py-5 text-center">
                    <i class="bx ${getFileIcon(file)} display-1 text-muted mb-3" style="font-size: 5rem;"></i>
                    <h5 class="mt-3">Vista previa no disponible</h5>
                    <p class="text-muted mb-4">
                        Este tipo de archivo <span class="badge bg-secondary">${file.extension ? file.extension.toUpperCase() : 'DESCONOCIDO'}</span> 
                        no puede ser visualizado en el navegador
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button class="btn btn-primary" onclick="downloadFile(${file.id})">
                            <i class="bx bx-download me-2"></i>
                            Descargar Archivo
                        </button>
                        <button class="btn btn-outline-secondary" onclick="editFile(${file.id})">
                            <i class="bx bx-edit me-2"></i>
                            Editar Info
                        </button>
                    </div>
                    <div class="mt-4 text-muted">
                        <small>
                            <i class="bx bx-info-circle me-1"></i>
                            ${file.size} • ${formatDate(file.date)}
                        </small>
                    </div>
                </div>
            `;
            }

            document.getElementById('downloadPreviewBtn').onclick = () => downloadFile(fileId);

            console.log('🎬 Abriendo modal de vista previa...');
            modal.show();
        };

        // ===================================
        // EVENT LISTENERS
        // ===================================

        // Upload file button
        document.getElementById('uploadFileBtn')?.addEventListener('click', uploadFile);

        // Create folder button
        document.getElementById('createFolderBtn2')?.addEventListener('click', createFolder);

        // Save file changes button
        document.getElementById('saveFileChangesBtn')?.addEventListener('click', saveFileChanges);

        // ===================================
        // PRE-SELECCIONAR CARPETA AL ABRIR MODAL DE SUBIR
        // ===================================
        document.getElementById('uploadFileModal')?.addEventListener('show.bs.modal', function () {
            const uploadFolderSelect = document.getElementById('uploadFolder');

            if (uploadFolderSelect && currentFolder !== 'root') {
                // Pre-seleccionar la carpeta actual si no estamos en root
                uploadFolderSelect.value = currentFolder;
                console.log('📂 Modal subir: Carpeta pre-seleccionada:', currentFolder);
            } else if (uploadFolderSelect) {
                // Si estamos en root, dejar el selector en el estado por defecto
                uploadFolderSelect.value = '';
                console.log('📂 En root, selector sin pre-selección');
            }
        });

        // ===================================
        // INICIALIZACIÓN
        // ===================================
        document.addEventListener('DOMContentLoaded', async function () {
            console.log('🚀 Files Manager with FilePond: DOM cargado');
            console.log('⏳ Esperando a que todas las dependencias estén disponibles...');

            // Esperar a que AppRouter, RoleService y SessionService estén disponibles
            await waitForDependencies();

            console.log('✅ Dependencias listas, iniciando Files Manager');

            // Inicializar el gestor de archivos
            await checkUserRole();
        });

    })();
</script>