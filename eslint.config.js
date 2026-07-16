import js from '@eslint/js';
import globals from 'globals';
import pluginVue from 'eslint-plugin-vue';
import tsParser from '@typescript-eslint/parser';
import tsPlugin from '@typescript-eslint/eslint-plugin';
import prettierConfig from '@vue/eslint-config-prettier';

export default [
    js.configs.recommended,
    ...pluginVue.configs['flat/recommended'],
    {
        files: ['**/*.{js,ts,vue}'],
        languageOptions: {
            ecmaVersion: 'latest',
            sourceType: 'module',
            globals: {
                ...globals.browser,
            },
        },
    },
    {
        files: ['**/*.ts', '**/*.vue'],
        languageOptions: {
            parserOptions: {
                parser: tsParser,
            },
        },
        plugins: {
            '@typescript-eslint': tsPlugin,
        },
        rules: tsPlugin.configs.recommended.rules,
    },
    prettierConfig,
    {
        ignores: ['vendor/**', 'node_modules/**', 'public/build/**'],
    },
];
