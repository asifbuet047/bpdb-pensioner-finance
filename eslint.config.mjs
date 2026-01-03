import js from '@eslint/js';
import react from 'eslint-plugin-react';
import reactHooks from 'eslint-plugin-react-hooks';
import jsxA11y from 'eslint-plugin-jsx-a11y';
import globals from 'globals';

export default [
    // =================================================
    // Base JavaScript rules (safe defaults)
    // =================================================
    {
        ...js.configs.recommended,
        rules: {
            // Do NOT be aggressive globally
            'no-unused-vars': 'warn',
        },
    },

    // =================================================
    // React Components (JSX / TSX)
    // =================================================
    {
        files: ['**/*.{jsx,tsx}'],

        languageOptions: {
            ecmaVersion: 'latest',
            sourceType: 'module',
            parserOptions: {
                ecmaFeatures: {
                    jsx: true,
                },
            },
            globals: {
                ...globals.browser,
            },
        },

        plugins: {
            react,
            'react-hooks': reactHooks,
            'jsx-a11y': jsxA11y,
        },

        settings: {
            react: {
                version: 'detect',
                jsxRuntime: 'automatic', // ✅ React 17+
            },
        },

        rules: {
            // React 17+ (no need to import React)
            'react/react-in-jsx-scope': 'off',

            // 🔥 CRITICAL: marks JSX identifiers as used
            // Fixes Tooltip, MUI icons, JSX-in-object issues
            'react/jsx-uses-vars': 'error',

            // Hooks rules
            'react-hooks/rules-of-hooks': 'error',
            'react-hooks/exhaustive-deps': 'warn',

            // React components often have intentional unused props
            'no-unused-vars': [
                'warn',
                {
                    argsIgnorePattern: '^_',
                    varsIgnorePattern: '^_',
                },
            ],
        },
    },

    // =================================================
    // ENTRY / BOOTSTRAP FILE (IMPORTANT)
    // =================================================
    {
        files: ['resources/js/app.{js,jsx}'],
        rules: {
            // Entry files mount components imperatively
            // ESLint cannot statically analyze usage here
            'no-unused-vars': 'off',
        },
    },
];
