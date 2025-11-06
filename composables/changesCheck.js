/**
 * ChangesCheck.js - Servicio para obtener cambios de GitHub
 * HomeLab VR - Roepard Labs
 * 
 * @description Servicio para consultar commits y releases de los repositorios de GitHub
 * @version 1.0.0
 * @requires axios (via AppRouter)
 */

(function () {
    'use strict';

    /**
     * Clase ChangesService - Gestión de cambios de GitHub
     * @class
     */
    class ChangesService {
        constructor() {
            this.repos = {
                frontend: {
                    owner: 'roepard-labs',
                    name: 'thepearlo_vr-website',
                    displayName: 'Frontend (Website)'
                },
                backend: {
                    owner: 'roepard-labs',
                    name: 'thepearlo_vr-backend',
                    displayName: 'Backend (API)'
                }
            };

            this.baseURL = 'https://api.github.com';

            console.log('📝 ChangesService inicializado');
        }

        /**
         * Obtener commits de un repositorio
         * @param {string} repoType - 'frontend' o 'backend'
         * @param {number} perPage - Cantidad de commits a obtener (default: 30)
         * @returns {Promise<Array>} Array de commits
         */
        async getCommits(repoType, perPage = 30) {
            try {
                const repo = this.repos[repoType];
                if (!repo) {
                    throw new Error(`Repositorio ${repoType} no encontrado`);
                }

                const url = `${this.baseURL}/repos/${repo.owner}/${repo.name}/commits`;

                console.log(`📡 Obteniendo commits de ${repo.displayName}...`);

                const response = await fetch(`${url}?per_page=${perPage}`);

                if (!response.ok) {
                    throw new Error(`Error HTTP ${response.status}: ${response.statusText}`);
                }

                const commits = await response.json();

                console.log(`✅ ${commits.length} commits obtenidos de ${repo.displayName}`);

                return commits.map(commit => ({
                    sha: commit.sha.substring(0, 7), // Short SHA
                    fullSha: commit.sha,
                    message: commit.commit.message,
                    author: commit.commit.author.name,
                    authorEmail: commit.commit.author.email,
                    date: commit.commit.author.date,
                    url: commit.html_url,
                    repo: repo.displayName,
                    repoType: repoType
                }));
            } catch (error) {
                console.error(`❌ Error obteniendo commits de ${repoType}:`, error);
                throw error;
            }
        }

        /**
         * Obtener releases de un repositorio
         * @param {string} repoType - 'frontend' o 'backend'
         * @param {number} perPage - Cantidad de releases a obtener (default: 10)
         * @returns {Promise<Array>} Array de releases
         */
        async getReleases(repoType, perPage = 10) {
            try {
                const repo = this.repos[repoType];
                if (!repo) {
                    throw new Error(`Repositorio ${repoType} no encontrado`);
                }

                const url = `${this.baseURL}/repos/${repo.owner}/${repo.name}/releases`;

                console.log(`📡 Obteniendo releases de ${repo.displayName}...`);

                const response = await fetch(`${url}?per_page=${perPage}`);

                if (!response.ok) {
                    throw new Error(`Error HTTP ${response.status}: ${response.statusText}`);
                }

                const releases = await response.json();

                console.log(`✅ ${releases.length} releases obtenidos de ${repo.displayName}`);

                return releases.map(release => ({
                    id: release.id,
                    tagName: release.tag_name,
                    name: release.name || release.tag_name,
                    body: release.body || 'Sin descripción',
                    author: release.author.login,
                    createdAt: release.created_at,
                    publishedAt: release.published_at,
                    url: release.html_url,
                    tarballUrl: release.tarball_url,
                    zipballUrl: release.zipball_url,
                    isDraft: release.draft,
                    isPrerelease: release.prerelease,
                    repo: repo.displayName,
                    repoType: repoType
                }));
            } catch (error) {
                console.error(`❌ Error obteniendo releases de ${repoType}:`, error);
                throw error;
            }
        }

        /**
         * Obtener release específico por tag
         * @param {string} repoType - 'frontend' o 'backend'
         * @param {string} tag - Tag de la release (ej: 'v0.0.0')
         * @returns {Promise<Object>} Release
         */
        async getReleaseByTag(repoType, tag) {
            try {
                const repo = this.repos[repoType];
                if (!repo) {
                    throw new Error(`Repositorio ${repoType} no encontrado`);
                }

                const url = `${this.baseURL}/repos/${repo.owner}/${repo.name}/releases/tags/${tag}`;

                console.log(`📡 Obteniendo release ${tag} de ${repo.displayName}...`);

                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error(`Error HTTP ${response.status}: ${response.statusText}`);
                }

                const release = await response.json();

                console.log(`✅ Release ${tag} obtenido de ${repo.displayName}`);

                return {
                    id: release.id,
                    tagName: release.tag_name,
                    name: release.name || release.tag_name,
                    body: release.body || 'Sin descripción',
                    author: release.author.login,
                    createdAt: release.created_at,
                    publishedAt: release.published_at,
                    url: release.html_url,
                    tarballUrl: release.tarball_url,
                    zipballUrl: release.zipball_url,
                    isDraft: release.draft,
                    isPrerelease: release.prerelease,
                    repo: repo.displayName,
                    repoType: repoType
                };
            } catch (error) {
                console.error(`❌ Error obteniendo release ${tag} de ${repoType}:`, error);
                throw error;
            }
        }

        /**
         * Obtener todos los commits de ambos repositorios
         * @param {number} perPage - Cantidad de commits por repo
         * @returns {Promise<Array>} Array combinado de commits
         */
        async getAllCommits(perPage = 30) {
            try {
                console.log('📡 Obteniendo commits de todos los repositorios...');

                const [frontendCommits, backendCommits] = await Promise.all([
                    this.getCommits('frontend', perPage),
                    this.getCommits('backend', perPage)
                ]);

                const allCommits = [...frontendCommits, ...backendCommits];

                // Ordenar por fecha descendente
                allCommits.sort((a, b) => new Date(b.date) - new Date(a.date));

                console.log(`✅ Total de commits: ${allCommits.length}`);

                return allCommits;
            } catch (error) {
                console.error('❌ Error obteniendo todos los commits:', error);
                throw error;
            }
        }

        /**
         * Obtener todas las releases de ambos repositorios
         * @param {number} perPage - Cantidad de releases por repo
         * @returns {Promise<Array>} Array combinado de releases
         */
        async getAllReleases(perPage = 10) {
            try {
                console.log('📡 Obteniendo releases de todos los repositorios...');

                const [frontendReleases, backendReleases] = await Promise.all([
                    this.getReleases('frontend', perPage),
                    this.getReleases('backend', perPage)
                ]);

                const allReleases = [...frontendReleases, ...backendReleases];

                // Ordenar por fecha de publicación descendente
                allReleases.sort((a, b) => new Date(b.publishedAt) - new Date(a.publishedAt));

                console.log(`✅ Total de releases: ${allReleases.length}`);

                return allReleases;
            } catch (error) {
                console.error('❌ Error obteniendo todas las releases:', error);
                throw error;
            }
        }

        /**
         * Formatear fecha de forma legible
         * @param {string} dateString - Fecha en formato ISO
         * @returns {string} Fecha formateada
         */
        formatDate(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diff = now - date;
            const seconds = Math.floor(diff / 1000);
            const minutes = Math.floor(seconds / 60);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);

            if (days > 30) {
                return date.toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
            } else if (days > 0) {
                return `Hace ${days} día${days > 1 ? 's' : ''}`;
            } else if (hours > 0) {
                return `Hace ${hours} hora${hours > 1 ? 's' : ''}`;
            } else if (minutes > 0) {
                return `Hace ${minutes} minuto${minutes > 1 ? 's' : ''}`;
            } else {
                return 'Hace unos segundos';
            }
        }
    }

    // ============================================
    // INSTANCIA GLOBAL
    // ============================================

    // Crear instancia global del servicio
    window.ChangesService = new ChangesService();

    console.log('✅ ChangesService configurado y listo para usar');
    console.log('📚 Ejemplos de uso:');
    console.log('  - ChangesService.getAllCommits()');
    console.log('  - ChangesService.getAllReleases()');
    console.log('  - ChangesService.getCommits("frontend", 10)');
    console.log('  - ChangesService.getReleases("backend", 5)');

})();
