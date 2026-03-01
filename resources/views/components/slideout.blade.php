@props(['id', 'maxWidth', 'closeOnBackdrop' => true])

@php
$id = $id ?? md5($attributes->wire('model'));
switch ($maxWidth ?? '2xl') {
    case 'sm':
    $maxWidth = 'sm:max-w-sm';
    break;
    case 'md':
    $maxWidth = 'sm:max-w-md';
    break;
    case 'lg':
    $maxWidth = 'sm:max-w-lg';
    break;
    case 'xl':
    $maxWidth = 'sm:max-w-xl';
    break;
    case '2xl':
    default:
    $maxWidth = 'sm:max-w-2xl';
    break;
}
@endphp

<div
    x-data="{
        show: @entangle($attributes->wire('model')),
        closeOnBackdrop: @js($closeOnBackdrop),
        focusables() {
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
            return [...$el.querySelectorAll(selector)].filter(el => !el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1 },
        autofocus() {
            let focusable = $el.querySelector('[autofocus]')
            if (focusable) focusable.focus()
        },
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden')
            setTimeout(autofocus, 50)
        } else {
            document.body.classList.remove('overflow-y-hidden')
        }
    })"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-cloak
    x-show="show"
    id="{{ $id }}"
    class="fixed inset-0 z-50"
>
    <!-- Backdrop -->
    <div x-cloak x-show="show" class="fixed inset-0 bg-black/20" @click="if (closeOnBackdrop) show = false"
        x-transition:enter="transition-opacity ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"></div>

    <!-- Drawer -->
    <div class="fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
        <div
            x-cloak
            x-show="show"
            x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="w-screen max-w-2xl"
        >
            <div class="flex h-full flex-col bg-white shadow-xl">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
