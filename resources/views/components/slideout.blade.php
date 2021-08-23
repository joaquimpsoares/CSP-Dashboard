@props(['id', 'maxWidth'])

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
    focusables() {
        // All focusable element types...
        let selector = 'a, button, input, textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
        return [...$el.querySelectorAll(selector)]
        // All non-disabled elements...
        .filter(el => ! el.hasAttribute('disabled'))
    },
    firstFocusable() { return this.focusables()[0] },
    lastFocusable() { return this.focusables().slice(-1)[0] },
    nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
    prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
    nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
    prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) -1 },
    autofocus() { let focusable = $el.querySelector('[autofocus]'); if (focusable) focusable.focus() },
}"
x-init="$watch('show', value => value && setTimeout(autofocus, 50))"
x-on:close.stop="show = false"
x-on:keydown.escape.window="show = false"
x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
x-show="show"
id="{{ $id }}"
class="fixed inset-x-0 top-0 z-50 px-4 pt-6 sm:px-0 sm:flex sm:items-top sm:justify-center"
style="display: none;"
>
<div x-cloak :class="open ? 'translate-x-0 ease-out' : 'translate-x-full ease-in'" class="fixed top-0 right-0 w-screen h-full max-w-2xl px-6 py-4 transition duration-300 transform bg-white border-l-2 border-gray-300">
    <div class="absolute inset-0 overflow-hidden">
        <div class="fixed inset-y-0 right-0 flex pl-0 sm:pl-16">
            <div x-show="open"
            x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="w-screen max-w-2xl"
            x-description="Slide-over panel, show/hide based on slide-over state.">
            <div class="flex flex-col h-full overflow-y-scroll bg-white shadow-xl">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
