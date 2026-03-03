/**
 * JS bootstrap for Blade + Breeze components.
 *
 * We need Alpine for Breeze dropdowns/menus (x-dropdown, nav mega menu, etc.).
 * Some setups rely on Livewire bundling Alpine, but that is not guaranteed.
 *
 * So we only start Alpine if it isn't already present.
 */

import './bootstrap'
import Alpine from 'alpinejs'

// Start Alpine only once.
if (!window.Alpine) {
    window.Alpine = Alpine
    Alpine.start()
}
