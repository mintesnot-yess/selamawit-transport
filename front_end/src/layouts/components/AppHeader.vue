<template>
    <header
        class="sticky top-0 flex items-center justify-between px-4 md:px-6 py-4 border-b border-surface-200 bg-white/80 backdrop-blur-sm z-30">
        <div class="flex items-center gap-3">
            <!-- sidebar-toggle button -->
            <button id="sidebar-toggle"
                class="p-2 rounded-lg text-surface-500 hover:text-surface-700 hover:bg-surface-100 md:hidden">
                <i class="fas fa-bars"></i>
            </button>
            <form
                class="flex items-center border border-surface-300 rounded-lg px-2 py-2 text-surface-500 max-w-md w-full focus-within:ring-2 focus-within:ring-accent-500 focus-within:border-accent-500 transition-all">
                <i class="fas fa-search mr-2 text-sm"></i>
                <input class="flex-1 outline-none text-sm text-surface-700 placeholder:text-surface-400 bg-transparent"
                    placeholder="Search or type command..." type="search" />
                <kbd
                    class="ml-3 px-2 py-1 rounded-md border border-surface-300 text-surface-500 text-xs font-mono font-medium select-none hidden sm:inline-flex">⌘K</kbd>
            </form>
        </div>
        <div class="flex items-center gap-3 md:gap-4">

            <button
                class="p-2 sm:flex hidden rounded-lg text-surface-500 hover:text-surface-700 hover:bg-surface-100 transition-colors relative">
                <i class="fas fa-bell"></i>
                <span class="absolute top-1.5 right-1.5 block w-2 h-2 rounded-full bg-red-500 ring-2 ring-white"></span>
            </button>

            <UserDropdown />



        </div>
    </header>
</template>

<script setup>

import UserDropdown from './UserDropdown.vue';

</script>