#!/usr/bin/env node

/**
 * Generate Config - Build Script
 * Lee .env y genera js/config.js para el navegador
 */

const fs = require('fs');
const path = require('path');

// Intentar cargar .env si existe, pero no fallar si no está
try {
    require('dotenv').config();
} catch (error) {
    console.log('ℹ️  .env no encontrado, usando variables de entorno del sistema');
}

// ============================================
// CONFIGURACIÓN
// ============================================

const ENV_VARS_TO_EXPOSE = [
    'API_URL',
    'APP_NAME',
    'APP_ENV',
    'APP_VERSION'
];

const OUTPUT_FILE = path.join(__dirname, '../composables/config.js');

// ============================================
// GENERAR CONFIG.JS
// ============================================

function generateConfig() {
    console.log('🔧 Generando configuración desde variables de entorno...');
    console.log('📍 Entorno:', process.env.APP_ENV || 'development');

    // Leer variables de entorno (del sistema O del archivo .env)
    const config = {};
    let foundVars = 0;

    ENV_VARS_TO_EXPOSE.forEach(varName => {
        const value = process.env[varName];
        if (value !== undefined && value !== '') {
            config[varName] = value;
            console.log(`✅ ${varName}: ${value}`);
            foundVars++;
        } else {
            console.warn(`⚠️  ${varName}: no definida (usando fallback en router.js)`);
        }
    });

    console.log(`\n📊 Variables encontradas: ${foundVars}/${ENV_VARS_TO_EXPOSE.length}`);

    // Generar contenido del archivo
    const fileContent = `/**
 * Config.js - Auto-generado desde .env
 * ⚠️  NO EDITAR MANUALMENTE - Ejecutar: npm run build:config
 * Generado: ${new Date().toISOString()}
 */

// Configuración de la aplicación
window.ENV_CONFIG = ${JSON.stringify(config, null, 4)};

// Log de confirmación
console.log('⚙️  Configuración cargada desde .env');
console.log('📡 API URL:', window.ENV_CONFIG.API_URL);
console.log('🏷️  App Name:', window.ENV_CONFIG.APP_NAME);
console.log(' App version:', window.ENV_CONFIG.APP_VERSION);
`;

    // Escribir archivo
    try {
        fs.writeFileSync(OUTPUT_FILE, fileContent, 'utf8');
        console.log(`✅ Archivo generado: ${OUTPUT_FILE}`);
        console.log('');
        console.log('📝 Incluir en HTML antes de router.js:');
        console.log('   <script src="../composables/npm-loader.js"></script>');
        console.log('   <script src="../composables/config.js"></script>');
        console.log('   <!-- Luego cargar Axios y router.js -->');
    } catch (error) {
        console.error('❌ Error al escribir archivo:', error);
        process.exit(1);
    }
}

// ============================================
// EJECUTAR
// ============================================

generateConfig();
