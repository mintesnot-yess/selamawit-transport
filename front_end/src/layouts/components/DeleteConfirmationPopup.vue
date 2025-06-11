<template>
    <div class="fixed inset-0  bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 w-fit   ">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Confirm Deletion</h3>
                <button @click="$emit('cancel')" class="text-gray-400 hover:text-gray-500" :disabled="isDeleting">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <p class="text-gray-600 mb-6 w-full">Are you sure you want to delete <strong>{{ itemName }}</strong>? This
                action
                cannot be undone.</p>

            <div class="flex justify-end space-x-3">
                <button @click="$emit('cancel')"
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                    :disabled="isDeleting">
                    Cancel
                </button>
                <button @click="$emit('confirm')"
                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 flex items-center"
                    :disabled="isDeleting">
                    <svg v-if="isDeleting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    {{ isDeleting ? 'Deleting...' : 'Delete' }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        itemName: {
            type: String,
            required: true
        },
        isDeleting: {
            type: Boolean,
            default: false
        }
    }
}
</script>