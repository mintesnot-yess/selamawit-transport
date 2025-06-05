<!-- components/DarkModeToggle.vue -->
<script setup>
import { useDark, useToggle } from '@vueuse/core'

const isDark = useDark({
    storageKey: 'theme',
    valueDark: 'dark',
    valueLight: 'light',
    onChanged: (isDark) => {
        document.documentElement.classList.toggle('dark', isDark)
    }
})
const toggleDark = useToggle(isDark)
</script>

<template>
    <label class="px-4 w-full py-2 text-base text-gray-700 hover:bg-gray-100 gap-2 flex items-center text-nowrap">
        <i class="fa fa-moon"></i>
        <span class="text-sm font-medium">Dark Mode</span>
        <div class="ml-10">
            <input type="checkbox" class="sr-only peer" :checked="isDark" @change="toggleDark()" />
            <div
                class="relative w-10 h-6 bg-gray-200 rounded-full peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:bg-blue-600 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all">
            </div>
        </div>
    </label>
</template>