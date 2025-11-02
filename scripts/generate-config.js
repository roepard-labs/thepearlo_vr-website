#!/usr/bin/env node

/**
 * Generate Config - Build Script
 * Lee .env y genera js/config.js para el navegador
 */

const fs = require('fs');
const path = require('path');
require('dotenv').config();

// ============================================
// CONFIGURACIÓN
// ============================================

const ENV_VARS_TO_EXPOSE = [
    'API_URL',
    'APP_NAME'
];

const OUTPUT_FILE = path.join(__dirname, '../js/config.js');

// ============================================
// GENERAR CONFIG.JS
// ============================================

function generateConfig() {
    console.log('🔧 Generando configuración desde .env...');

    // Leer variables de entorno
    const config = {};
    ENV_VARS_TO_EXPOSE.forEach(varName => {
        const value = process.env[varName];
        if (value !== undefined) {
            config[varName] = value;
            console.log(`✅ ${varName}: ${value}`);
        } else {
            console.warn(`⚠️  ${varName}: no definida en .env`);
        }
    });

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
`;

    // Escribir archivo
    try {
        fs.writeFileSync(OUTPUT_FILE, fileContent, 'utf8');
        console.log(`✅ Archivo generado: ${OUTPUT_FILE}`);
        console.log('');
        console.log('📝 Recuerda incluir en tu HTML:');
        console.log('   <script src="../js/config.js"></script>');
        console.log('   <script src="../js/router.js"></script>');
    } catch (error) {
        console.error('❌ Error al escribir archivo:', error);
        process.exit(1);
    }
}

// ============================================
// EJECUTAR
// ============================================

generateConfig();
