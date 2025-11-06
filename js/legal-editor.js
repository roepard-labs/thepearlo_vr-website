/**
 * Legal Content Editor
 * Editor de contenido legal (Privacidad y Términos)
 * HomeLab AR - Roepard Labs
 * 
 * Solo accesible para administradores (role_id = 2)
 */

(function () {
    'use strict';

    console.log('⚖️ Legal Content Editor - Inicializando');

    // ===================================
    // INICIALIZAR NOTYF
    // ===================================
    let notyf;

    function initNotyf() {
        if (typeof Notyf !== 'undefined') {
            notyf = new Notyf({
                duration: 4000,
                position: {
                    x: 'right',
                    y: 'top'
                },
                types: [
                    {
                        type: 'success',
                        background: 'var(--bs-success)',
                        icon: {
                            className: 'bx bx-check-circle',
                            tagName: 'i'
                        }
                    },
                    {
                        type: 'error',
                        background: 'var(--bs-danger)',
                        icon: {
                            className: 'bx bx-x-circle',
                            tagName: 'i'
                        }
                    },
                    {
                        type: 'warning',
                        background: 'var(--bs-warning)',
                        icon: {
                            className: 'bx bx-error',
                            tagName: 'i'
                        }
                    }
                ]
            });
            console.log('✅ Notyf inicializado en legal-editor.js');
            return true;
        } else {
            console.warn('⏳ Notyf no disponible aún, reintentando...');
            return false;
        }
    }

    // Intentar inicializar Notyf con reintentos
    let notyfInitAttempts = 0;
    const MAX_NOTYF_ATTEMPTS = 20; // 10 segundos máximo

    function attemptNotyfInit() {
        notyfInitAttempts++;

        if (initNotyf()) {
            return; // Éxito
        }

        if (notyfInitAttempts < MAX_NOTYF_ATTEMPTS) {
            setTimeout(attemptNotyfInit, 500);
        } else {
            console.error('❌ No se pudo inicializar Notyf después de', MAX_NOTYF_ATTEMPTS, 'intentos');
        }
    }

    // Iniciar intentos de inicialización
    attemptNotyfInit();

    // Estado del editor
    let privacyData = null;
    let termsData = null;
    let currentEditingId = null;
    let currentEditingType = null; // 'privacy' | 'terms'

    /**
     * Helper: Mostrar notificación de forma segura
     */
    function showNotification(type, message) {
        if (notyf) {
            notyf[type](message);
        } else {
            console.warn(`[Notyf no disponible] ${type.toUpperCase()}: ${message}`);
            // Fallback a alert solo en desarrollo
            if (window.location.hostname === 'localhost') {
                alert(`${type.toUpperCase()}: ${message}`);
            }
        }
    }

    /**
     * Cargar contenido de privacidad (admin)
     */
    async function loadPrivacyAdmin() {
        try {
            const response = await window.AppRouter.get('/routes/privacy/list_privacy.php');

            if (response.status === 'success' && response.data) {
                privacyData = response.data;
                renderPrivacyEditor(privacyData);

                // Ocultar loading y mostrar editor
                const loadingDiv = document.getElementById('privacy-loading');
                const editorDiv = document.getElementById('privacy-editor-container');
                if (loadingDiv) loadingDiv.style.display = 'none';
                if (editorDiv) editorDiv.style.display = 'block';

                console.log('✅ Contenido de privacidad cargado (admin):', privacyData.total_paragraphs, 'párrafos');
            } else {
                throw new Error(response.message || 'Error al cargar contenido');
            }
        } catch (error) {
            console.error('❌ Error al cargar privacidad:', error);
            showNotification('error', 'Error al cargar contenido de privacidad');

            // En caso de error también ocultar loading
            const loadingDiv = document.getElementById('privacy-loading');
            if (loadingDiv) loadingDiv.style.display = 'none';
        }
    }

    /**
     * Cargar contenido de términos (admin)
     */
    async function loadTermsAdmin() {
        try {
            const response = await window.AppRouter.get('/routes/legal/list_legal.php');

            if (response.status === 'success' && response.data) {
                termsData = response.data;
                renderTermsEditor(termsData);

                // Ocultar loading y mostrar editor
                const loadingDiv = document.getElementById('terms-loading');
                const editorDiv = document.getElementById('terms-editor-container');
                if (loadingDiv) loadingDiv.style.display = 'none';
                if (editorDiv) editorDiv.style.display = 'block';

                console.log('✅ Contenido de términos cargado (admin):', termsData.total_paragraphs, 'párrafos');
            } else {
                throw new Error(response.message || 'Error al cargar contenido');
            }
        } catch (error) {
            console.error('❌ Error al cargar términos:', error);
            showNotification('error', 'Error al cargar contenido de términos');

            // En caso de error también ocultar loading
            const loadingDiv = document.getElementById('terms-loading');
            if (loadingDiv) loadingDiv.style.display = 'none';
        }
    }

    /**
     * Renderizar editor de privacidad
     */
    function renderPrivacyEditor(data) {
        const container = document.getElementById('privacy-editor-container');
        if (!container) return;

        let html = `
            <!-- Metadata -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bx bx-info-circle me-2"></i>
                        Información del Documento
                    </h5>
                    <span class="badge bg-primary">v${data.metadata.version}</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Versión</label>
                            <input type="text" class="form-control" id="privacy-version" value="${data.metadata.version}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fecha de Vigencia</label>
                            <input type="date" class="form-control" id="privacy-effective-date" 
                                   value="${data.metadata.effective_date}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Última Actualización</label>
                            <input type="text" class="form-control" value="${formatDate(data.metadata.last_updated)}" disabled>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Registro de Cambios</label>
                            <textarea class="form-control" id="privacy-change-log" rows="2">${data.metadata.change_log || ''}</textarea>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary" onclick="updatePrivacyMetadata()">
                            <i class="bx bx-save me-2"></i>
                            Guardar Metadata
                        </button>
                    </div>
                </div>
            </div>

            <!-- Secciones -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bx bx-list-ul me-2"></i>
                        Contenido (${data.total_paragraphs} párrafos)
                    </h5>
                    <button class="btn btn-success btn-sm" onclick="addNewPrivacyParagraph()">
                        <i class="bx bx-plus me-1"></i>
                        Nuevo Párrafo
                    </button>
                </div>
                <div class="card-body">
        `;

        // Renderizar secciones
        data.sections.forEach(section => {
            html += `
                <div class="section-group mb-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bx bx-folder me-2"></i>
                        ${section.section_number}. ${section.section_title}
                    </h6>
                    <div class="list-group">
            `;

            section.paragraphs.forEach(paragraph => {
                const statusBadge = paragraph.is_active == 1
                    ? '<span class="badge bg-success">Activo</span>'
                    : '<span class="badge bg-secondary">Inactivo</span>';

                html += `
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                    <strong class="me-2">Párrafo ${paragraph.paragraph_number}</strong>
                                    ${statusBadge}
                                    <small class="text-muted ms-2">Orden: ${paragraph.display_order}</small>
                                </div>
                                <p class="mb-0 text-muted">${escapeHtml(paragraph.paragraph_content.substring(0, 150))}${paragraph.paragraph_content.length > 150 ? '...' : ''}</p>
                            </div>
                            <div class="btn-group ms-3">
                                <button class="btn btn-sm btn-primary" onclick="editPrivacyParagraph(${paragraph.privacy_id})">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deletePrivacyParagraph(${paragraph.privacy_id})">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });

            html += `
                    </div>
                </div>
            `;
        });

        html += `
                </div>
            </div>
        `;

        container.innerHTML = html;
    }

    /**
     * Renderizar editor de términos (similar a privacidad)
     */
    function renderTermsEditor(data) {
        const container = document.getElementById('terms-editor-container');
        if (!container) return;

        let html = `
            <!-- Metadata -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bx bx-info-circle me-2"></i>
                        Información del Documento
                    </h5>
                    <span class="badge bg-primary">v${data.metadata.version}</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Versión</label>
                            <input type="text" class="form-control" id="terms-version" value="${data.metadata.version}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fecha de Vigencia</label>
                            <input type="date" class="form-control" id="terms-effective-date" 
                                   value="${data.metadata.effective_date}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Última Actualización</label>
                            <input type="text" class="form-control" value="${formatDate(data.metadata.last_updated)}" disabled>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Registro de Cambios</label>
                            <textarea class="form-control" id="terms-change-log" rows="2">${data.metadata.change_log || ''}</textarea>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary" onclick="updateTermsMetadata()">
                            <i class="bx bx-save me-2"></i>
                            Guardar Metadata
                        </button>
                    </div>
                </div>
            </div>

            <!-- Secciones -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bx bx-list-ul me-2"></i>
                        Contenido (${data.total_paragraphs} párrafos)
                    </h5>
                    <button class="btn btn-success btn-sm" onclick="addNewTermsParagraph()">
                        <i class="bx bx-plus me-1"></i>
                        Nuevo Párrafo
                    </button>
                </div>
                <div class="card-body">
        `;

        // Renderizar secciones (similar a privacidad)
        data.sections.forEach(section => {
            html += `
                <div class="section-group mb-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bx bx-folder me-2"></i>
                        ${section.section_number}. ${section.section_title}
                    </h6>
                    <div class="list-group">
            `;

            section.paragraphs.forEach(paragraph => {
                const statusBadge = paragraph.is_active == 1
                    ? '<span class="badge bg-success">Activo</span>'
                    : '<span class="badge bg-secondary">Inactivo</span>';

                html += `
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                    <strong class="me-2">Párrafo ${paragraph.paragraph_number}</strong>
                                    ${statusBadge}
                                    <small class="text-muted ms-2">Orden: ${paragraph.display_order}</small>
                                </div>
                                <p class="mb-0 text-muted">${escapeHtml(paragraph.paragraph_content.substring(0, 150))}${paragraph.paragraph_content.length > 150 ? '...' : ''}</p>
                            </div>
                            <div class="btn-group ms-3">
                                <button class="btn btn-sm btn-primary" onclick="editTermsParagraph(${paragraph.term_id})">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteTermsParagraph(${paragraph.term_id})">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });

            html += `
                    </div>
                </div>
            `;
        });

        html += `
                </div>
            </div>
        `;

        container.innerHTML = html;
    }

    /**
     * Actualizar metadata de privacidad
     */
    async function updatePrivacyMetadata() {
        try {
            const data = {
                operation: 'update_metadata',
                version: document.getElementById('privacy-version').value,
                effective_date: document.getElementById('privacy-effective-date').value,
                change_log: document.getElementById('privacy-change-log').value
            };

            const response = await window.AppRouter.post('/routes/privacy/up_privacy.php', data);

            if (response.status === 'success') {
                showNotification('success', 'Metadata actualizada exitosamente');
                loadPrivacyAdmin(); // Recargar
            } else {
                throw new Error(response.message);
            }
        } catch (error) {
            console.error('❌ Error al actualizar metadata:', error);
            showNotification('error', 'Error al actualizar metadata');
        }
    }

    /**
     * Actualizar metadata de términos
     */
    async function updateTermsMetadata() {
        try {
            const data = {
                operation: 'update_metadata',
                version: document.getElementById('terms-version').value,
                effective_date: document.getElementById('terms-effective-date').value,
                change_log: document.getElementById('terms-change-log').value
            };

            const response = await window.AppRouter.post('/routes/legal/up_legal.php', data);

            if (response.status === 'success') {
                showNotification('success', 'Metadata actualizada exitosamente');
                loadTermsAdmin(); // Recargar
            } else {
                throw new Error(response.message);
            }
        } catch (error) {
            console.error('❌ Error al actualizar metadata:', error);
            showNotification('error', 'Error al actualizar metadata');
        }
    }

    /**
     * Editar párrafo de privacidad
     */
    function editPrivacyParagraph(privacyId) {
        // Encontrar el párrafo
        let paragraph = null;
        for (const section of privacyData.sections) {
            const found = section.paragraphs.find(p => p.privacy_id == privacyId);
            if (found) {
                paragraph = found;
                break;
            }
        }

        if (!paragraph) {
            showNotification('error', 'Párrafo no encontrado');
            return;
        }

        // Mostrar modal de edición
        Swal.fire({
            title: 'Editar Párrafo',
            html: `
                <div class="text-start">
                    <div class="mb-3">
                        <label class="form-label">Número de Sección</label>
                        <input type="number" id="swal-section-number" class="form-control" value="${paragraph.section_number}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Título de Sección</label>
                        <input type="text" id="swal-section-title" class="form-control" value="${escapeHtml(paragraph.section_title)}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número de Párrafo</label>
                        <input type="number" id="swal-paragraph-number" class="form-control" value="${paragraph.paragraph_number}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contenido</label>
                        <textarea id="swal-content" class="form-control" rows="5">${escapeHtml(paragraph.paragraph_content)}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Orden de Visualización</label>
                        <input type="number" id="swal-display-order" class="form-control" value="${paragraph.display_order}">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="swal-is-active" ${paragraph.is_active == 1 ? 'checked' : ''}>
                        <label class="form-check-label" for="swal-is-active">
                            Activo
                        </label>
                    </div>
                </div>
            `,
            width: '600px',
            showCancelButton: true,
            confirmButtonText: 'Guardar Cambios',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                return {
                    operation: 'update',
                    privacy_id: privacyId,
                    section_number: document.getElementById('swal-section-number').value,
                    section_title: document.getElementById('swal-section-title').value,
                    paragraph_number: document.getElementById('swal-paragraph-number').value,
                    paragraph_content: document.getElementById('swal-content').value,
                    display_order: document.getElementById('swal-display-order').value,
                    is_active: document.getElementById('swal-is-active').checked ? 1 : 0
                };
            }
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await window.AppRouter.post('/routes/privacy/up_privacy.php', result.value);

                    if (response.status === 'success') {
                        showNotification('success', 'Párrafo actualizado exitosamente');
                        loadPrivacyAdmin();
                    } else {
                        throw new Error(response.message);
                    }
                } catch (error) {
                    console.error('❌ Error al actualizar párrafo:', error);
                    showNotification('error', 'Error al actualizar párrafo');
                }
            }
        });
    }

    /**
     * Eliminar párrafo de privacidad
     */
    async function deletePrivacyParagraph(privacyId) {
        const result = await Swal.fire({
            title: '¿Eliminar párrafo?',
            text: 'Esta acción marcará el párrafo como inactivo.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#d33'
        });

        if (result.isConfirmed) {
            try {
                const data = {
                    operation: 'delete',
                    privacy_id: privacyId
                };

                const response = await window.AppRouter.post('/routes/privacy/up_privacy.php', data);

                if (response.status === 'success') {
                    showNotification('success', 'Párrafo eliminado exitosamente');
                    loadPrivacyAdmin();
                } else {
                    throw new Error(response.message);
                }
            } catch (error) {
                console.error('❌ Error al eliminar párrafo:', error);
                showNotification('error', 'Error al eliminar párrafo');
            }
        }
    }

    /**
     * Editar párrafo de términos
     */
    function editTermsParagraph(termId) {
        // Encontrar el párrafo
        let paragraph = null;
        for (const section of termsData.sections) {
            const found = section.paragraphs.find(p => p.term_id == termId);
            if (found) {
                paragraph = found;
                break;
            }
        }

        if (!paragraph) {
            showNotification('error', 'Párrafo no encontrado');
            return;
        }

        // Mostrar modal de edición
        Swal.fire({
            title: 'Editar Párrafo de Términos',
            html: `
                <div class="text-start">
                    <div class="mb-3">
                        <label class="form-label">Número de Sección</label>
                        <input type="number" id="swal-section-number" class="form-control" value="${paragraph.section_number}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Título de Sección</label>
                        <input type="text" id="swal-section-title" class="form-control" value="${escapeHtml(paragraph.section_title)}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número de Párrafo</label>
                        <input type="number" id="swal-paragraph-number" class="form-control" value="${paragraph.paragraph_number}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contenido</label>
                        <textarea id="swal-content" class="form-control" rows="5">${escapeHtml(paragraph.paragraph_content)}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Orden de Visualización</label>
                        <input type="number" id="swal-display-order" class="form-control" value="${paragraph.display_order}">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="swal-is-active" ${paragraph.is_active == 1 ? 'checked' : ''}>
                        <label class="form-check-label" for="swal-is-active">
                            Activo
                        </label>
                    </div>
                </div>
            `,
            width: '600px',
            showCancelButton: true,
            confirmButtonText: 'Guardar Cambios',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                return {
                    operation: 'update',
                    term_id: termId,
                    section_number: document.getElementById('swal-section-number').value,
                    section_title: document.getElementById('swal-section-title').value,
                    paragraph_number: document.getElementById('swal-paragraph-number').value,
                    paragraph_content: document.getElementById('swal-content').value,
                    display_order: document.getElementById('swal-display-order').value,
                    is_active: document.getElementById('swal-is-active').checked ? 1 : 0
                };
            }
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await window.AppRouter.post('/routes/legal/up_legal.php', result.value);

                    if (response.status === 'success') {
                        showNotification('success', 'Párrafo actualizado exitosamente');
                        loadTermsAdmin();
                    } else {
                        throw new Error(response.message);
                    }
                } catch (error) {
                    console.error('❌ Error al actualizar párrafo:', error);
                    showNotification('error', 'Error al actualizar párrafo');
                }
            }
        });
    }

    /**
     * Eliminar párrafo de términos (soft delete)
     */
    async function deleteTermsParagraph(termId) {
        const result = await Swal.fire({
            title: '¿Estás seguro?',
            text: 'Este párrafo será marcado como inactivo',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6'
        });

        if (result.isConfirmed) {
            try {
                const data = {
                    operation: 'delete',
                    term_id: termId
                };

                const response = await window.AppRouter.post('/routes/legal/up_legal.php', data);

                if (response.status === 'success') {
                    showNotification('success', 'Párrafo eliminado exitosamente');
                    loadTermsAdmin();
                } else {
                    throw new Error(response.message);
                }
            } catch (error) {
                console.error('❌ Error al eliminar párrafo:', error);
                showNotification('error', 'Error al eliminar párrafo');
            }
        }
    }

    window.editTermsParagraph = editTermsParagraph;
    window.deleteTermsParagraph = deleteTermsParagraph;

    /**
     * Agregar nuevo párrafo de privacidad
     */
    async function addNewPrivacyParagraph() {
        const result = await Swal.fire({
            title: 'Nuevo Párrafo de Privacidad',
            html: `
                <div class="text-start">
                    <div class="mb-3">
                        <label class="form-label">Número de Sección</label>
                        <input type="number" id="swal-section-number" class="form-control" value="1" min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Título de Sección</label>
                        <input type="text" id="swal-section-title" class="form-control" placeholder="Ej: Introducción">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número de Párrafo</label>
                        <input type="number" id="swal-paragraph-number" class="form-control" value="1" min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contenido</label>
                        <textarea id="swal-content" class="form-control" rows="5" placeholder="Escribe el contenido del párrafo..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Orden de Visualización</label>
                        <input type="number" id="swal-display-order" class="form-control" value="1" min="1">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="swal-is-active" checked>
                        <label class="form-check-label" for="swal-is-active">
                            Activo
                        </label>
                    </div>
                </div>
            `,
            width: '600px',
            showCancelButton: true,
            confirmButtonText: 'Crear Párrafo',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                const sectionNumber = document.getElementById('swal-section-number').value;
                const sectionTitle = document.getElementById('swal-section-title').value;
                const paragraphNumber = document.getElementById('swal-paragraph-number').value;
                const content = document.getElementById('swal-content').value;
                const displayOrder = document.getElementById('swal-display-order').value;
                const isActive = document.getElementById('swal-is-active').checked;

                // Validación
                if (!sectionNumber || !sectionTitle || !paragraphNumber || !content) {
                    Swal.showValidationMessage('Todos los campos son requeridos');
                    return false;
                }

                return {
                    operation: 'create',
                    section_number: sectionNumber,
                    section_title: sectionTitle,
                    paragraph_number: paragraphNumber,
                    paragraph_content: content,
                    display_order: displayOrder,
                    is_active: isActive ? 1 : 0
                };
            }
        });

        if (result.isConfirmed) {
            try {
                const response = await window.AppRouter.post('/routes/privacy/up_privacy.php', result.value);

                if (response.status === 'success') {
                    showNotification('success', 'Párrafo creado exitosamente');
                    loadPrivacyAdmin();
                } else {
                    throw new Error(response.message);
                }
            } catch (error) {
                console.error('❌ Error al crear párrafo:', error);
                showNotification('error', 'Error al crear párrafo');
            }
        }
    }

    /**
     * Agregar nuevo párrafo de términos
     */
    async function addNewTermsParagraph() {
        const result = await Swal.fire({
            title: 'Nuevo Párrafo de Términos',
            html: `
                <div class="text-start">
                    <div class="mb-3">
                        <label class="form-label">Número de Sección</label>
                        <input type="number" id="swal-section-number" class="form-control" value="1" min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Título de Sección</label>
                        <input type="text" id="swal-section-title" class="form-control" placeholder="Ej: Aceptación de Términos">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número de Párrafo</label>
                        <input type="number" id="swal-paragraph-number" class="form-control" value="1" min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contenido</label>
                        <textarea id="swal-content" class="form-control" rows="5" placeholder="Escribe el contenido del párrafo..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Orden de Visualización</label>
                        <input type="number" id="swal-display-order" class="form-control" value="1" min="1">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="swal-is-active" checked>
                        <label class="form-check-label" for="swal-is-active">
                            Activo
                        </label>
                    </div>
                </div>
            `,
            width: '600px',
            showCancelButton: true,
            confirmButtonText: 'Crear Párrafo',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                const sectionNumber = document.getElementById('swal-section-number').value;
                const sectionTitle = document.getElementById('swal-section-title').value;
                const paragraphNumber = document.getElementById('swal-paragraph-number').value;
                const content = document.getElementById('swal-content').value;
                const displayOrder = document.getElementById('swal-display-order').value;
                const isActive = document.getElementById('swal-is-active').checked;

                // Validación
                if (!sectionNumber || !sectionTitle || !paragraphNumber || !content) {
                    Swal.showValidationMessage('Todos los campos son requeridos');
                    return false;
                }

                return {
                    operation: 'create',
                    section_number: sectionNumber,
                    section_title: sectionTitle,
                    paragraph_number: paragraphNumber,
                    paragraph_content: content,
                    display_order: displayOrder,
                    is_active: isActive ? 1 : 0
                };
            }
        });

        if (result.isConfirmed) {
            try {
                const response = await window.AppRouter.post('/routes/legal/up_legal.php', result.value);

                if (response.status === 'success') {
                    showNotification('success', 'Párrafo creado exitosamente');
                    loadTermsAdmin();
                } else {
                    throw new Error(response.message);
                }
            } catch (error) {
                console.error('❌ Error al crear párrafo:', error);
                showNotification('error', 'Error al crear párrafo');
            }
        }
    }

    window.addNewPrivacyParagraph = addNewPrivacyParagraph;
    window.addNewTermsParagraph = addNewTermsParagraph;

    /**
     * Utilities
     */
    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    // Exponer funciones globalmente
    window.loadPrivacyAdmin = loadPrivacyAdmin;
    window.loadTermsAdmin = loadTermsAdmin;
    window.updatePrivacyMetadata = updatePrivacyMetadata;
    window.updateTermsMetadata = updateTermsMetadata;
    window.editPrivacyParagraph = editPrivacyParagraph;
    window.deletePrivacyParagraph = deletePrivacyParagraph;

    // Función para esperar a que AppRouter Y Axios estén completamente disponibles
    function waitForAppRouter(callback, maxAttempts = 50) {
        let attempts = 0;

        function checkRouter() {
            attempts++;

            // Verificar que AppRouter existe Y que Axios está inicializado
            if (window.AppRouter &&
                typeof window.AppRouter.get === 'function' &&
                typeof window.AppRouter.isReady === 'function' &&
                window.AppRouter.isReady()) {
                console.log('✅ AppRouter y Axios completamente inicializados, ejecutando callback...');
                callback();
            } else if (attempts < maxAttempts) {
                console.log(`⏳ Esperando AppRouter/Axios... (${attempts}/${maxAttempts})`);
                setTimeout(checkRouter, 200); // Reintentar cada 200ms
            } else {
                console.error('❌ AppRouter/Axios no se cargó después de', maxAttempts, 'intentos');
            }
        }

        checkRouter();
    }

    // Inicializar cuando el tab se active
    document.addEventListener('DOMContentLoaded', function () {
        // Verificar cuál tab está activo al cargar
        const privacyTabPane = document.getElementById('privacy-content');
        const termsTabPane = document.getElementById('terms-content');

        // Si privacy-content tiene clase 'active', esperar AppRouter y cargar
        if (privacyTabPane && privacyTabPane.classList.contains('active')) {
            console.log('🔍 Privacy tab está activo al cargar, esperando AppRouter...');
            waitForAppRouter(function () {
                console.log('📖 Cargando contenido de privacidad...');
                loadPrivacyAdmin();
            });
        }

        // Si terms-content tiene clase 'active', esperar AppRouter y cargar
        if (termsTabPane && termsTabPane.classList.contains('active')) {
            console.log('🔍 Terms tab está activo al cargar, esperando AppRouter...');
            waitForAppRouter(function () {
                console.log('📜 Cargando contenido de términos...');
                loadTermsAdmin();
            });
        }

        // Event listener para tab de privacidad
        const privacyTab = document.getElementById('privacy-tab');
        if (privacyTab) {
            privacyTab.addEventListener('shown.bs.tab', function () {
                if (!privacyData) {
                    console.log('🔄 Privacy tab activado, cargando contenido...');
                    loadPrivacyAdmin();
                }
            });
        }

        // Event listener para tab de términos
        const termsTab = document.getElementById('terms-tab');
        if (termsTab) {
            termsTab.addEventListener('shown.bs.tab', function () {
                if (!termsData) {
                    console.log('🔄 Terms tab activado, cargando contenido...');
                    loadTermsAdmin();
                }
            });
        }
    });

})();
