/**
 * VersionCheck.js - Servicio para comprobar tags/releases (versiones) en GitHub
 * HomeLab VR - Roepard Labs
 *
 * Proporciona métodos para listar tags, obtener release por tag y obtener el
 * último tag/release. Similar a ChangesService pero centrado en tags/versions.
 */

(function () {
    'use strict';

    class VersionService {
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

            // Si quieres usar autenticación para evitar rate limits, define
            // window.GITHUB_TOKEN o window.ENV_CONFIG.GITHUB_TOKEN
            this.authToken = window.GITHUB_TOKEN || (window.ENV_CONFIG && window.ENV_CONFIG.GITHUB_TOKEN) || null;

            console.log('🔖 VersionService inicializado');
        }

        _headers() {
            const headers = { Accept: 'application/vnd.github.v3+json' };
            if (this.authToken) headers.Authorization = `token ${this.authToken}`;
            return headers;
        }

        _repoFor(type) {
            return this.repos[type] || null;
        }

        /**
         * Obtener lista de tags de un repositorio (Git tags)
         * @param {string} repoType - 'frontend'|'backend'
         * @param {number} perPage
         */
        async getTags(repoType, perPage = 30) {
            const repo = this._repoFor(repoType);
            if (!repo) throw new Error(`Repositorio ${repoType} no encontrado`);

            const url = `${this.baseURL}/repos/${repo.owner}/${repo.name}/tags?per_page=${perPage}`;
            console.log(`📡 Obtener tags de ${repo.displayName}...`);

            const res = await fetch(url, { headers: this._headers() });
            if (!res.ok) throw new Error(`Error HTTP ${res.status}: ${res.statusText}`);
            const tags = await res.json();
            // tags: [{ name, commit: {sha, url}, zipball_url, tarball_url }]
            return tags.map(t => ({
                name: t.name,
                commitSha: t.commit?.sha,
                commitUrl: t.commit?.url,
                zipballUrl: t.zipball_url,
                tarballUrl: t.tarball_url
            }));
        }

        /**
         * Obtener release asociado a un tag (si existe release)
         * Usa el endpoint /releases/tags/{tag}
         */
        async getReleaseByTag(repoType, tag) {
            const repo = this._repoFor(repoType);
            if (!repo) throw new Error(`Repositorio ${repoType} no encontrado`);

            const url = `${this.baseURL}/repos/${repo.owner}/${repo.name}/releases/tags/${encodeURIComponent(tag)}`;
            console.log(`📡 Obtener release ${tag} de ${repo.displayName}...`);

            const res = await fetch(url, { headers: this._headers() });
            if (!res.ok) {
                // Puede no existir una release para ese tag (404)
                throw new Error(`Error HTTP ${res.status}: ${res.statusText}`);
            }
            const r = await res.json();
            return {
                id: r.id,
                tagName: r.tag_name,
                name: r.name || r.tag_name,
                body: r.body || '',
                author: r.author?.login,
                publishedAt: r.published_at,
                url: r.html_url,
                draft: r.draft,
                prerelease: r.prerelease
            };
        }

        /**
         * Obtener último release (releases/latest) o el latest tag si no hay releases
         */
        async getLatestTagOrRelease(repoType) {
            const repo = this._repoFor(repoType);
            if (!repo) throw new Error(`Repositorio ${repoType} no encontrado`);

            const releasesUrl = `${this.baseURL}/repos/${repo.owner}/${repo.name}/releases/latest`;
            try {
                const res = await fetch(releasesUrl, { headers: this._headers() });
                if (res.ok) {
                    const r = await res.json();
                    return { type: 'release', tag: r.tag_name || r.name, url: r.html_url, data: r };
                }
            } catch (e) {
                console.debug('No se pudo obtener latest release:', e);
            }

            // Fallback: obtener tags y tomar el primero (más reciente por paginación)
            const tags = await this.getTags(repoType, 1);
            if (tags && tags.length > 0) {
                return { type: 'tag', tag: tags[0].name, url: tags[0].zipballUrl || '', data: tags[0] };
            }

            return null;
        }

        /**
         * Obtener tags/release de todos los repos (frontend+backend)
         */
        async getAllLatest(perRepo = true) {
            const tasks = Object.keys(this.repos).map(async (k) => {
                try {
                    const latest = await this.getLatestTagOrRelease(k);
                    return { repoType: k, latest };
                } catch (e) {
                    console.warn(`⚠️ No se pudo obtener latest para ${k}:`, e.message || e);
                    return { repoType: k, latest: null };
                }
            });
            return Promise.all(tasks);
        }
    }

    // Instancia global
    window.VersionService = new VersionService();

    console.log('✅ VersionService configurado y listo para usar');
    console.log('📚 Ejemplos:');
    console.log('  - VersionService.getTags("frontend", 10)');
    console.log('  - VersionService.getReleaseByTag("frontend", "v0.0.0")');
    console.log('  - VersionService.getLatestTagOrRelease("frontend")');
    console.log('  - VersionService.getAllLatest()');

})();
