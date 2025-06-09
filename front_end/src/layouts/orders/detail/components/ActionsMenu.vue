<template>
    <div class="relative inline-block text-left">
        <button @click="toggleMenu"
            class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-100 focus:outline-none"
            aria-label="Actions">
            <i class="fas fa-ellipsis-h text-gray-500"></i>
        </button>
        <div v-show="isOpen"
            class="absolute right-0 z-10 mt-1 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5">
            <div class="py-1">
                <button @click="$emit('view')"
                    class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-eye mr-3"></i> Show
                </button>
                <button @click="$emit('edit')"
                    class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-edit mr-3"></i> Edit
                </button>
                <button @click="$emit('delete')"
                    class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-trash mr-3"></i> Delete
                </button>
            </div>
        </div>
        <div v-if="isOpen" @click="isOpen = false" class="fixed inset-0 h-full w-full z-9 cursor-pointer"></div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isOpen: false
        };
    },
    methods: {
        toggleMenu() {
            this.isOpen = !this.isOpen;
        }
    }
};
</script>