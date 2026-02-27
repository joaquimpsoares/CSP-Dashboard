/**
 * JS bootstrap for Blade + Breeze components.
 *
 * This repo has legacy Vue/Mix history, but the current auth/dashboard shell
 * relies on Alpine for dropdowns, toggles, etc.
 */

import './bootstrap'

import Alpine from 'alpinejs'

window.Alpine = Alpine
Alpine.start()

console.log('[CSP-Dashboard] Alpine started', !!window.Alpine)
