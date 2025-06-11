<template>
    <div class="relative inline-block text-left">
        <!-- Dropdown toggle button -->
        <button @click="toggleDropdown"
            class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all"
            aria-label="Actions">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20"
                fill="currentColor">
                <path
                    d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
            </svg>
        </button>

        <!-- Dropdown menu -->
        <transition enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95">
            <div v-show="isOpen"
                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                <div class="py-1">
                    <button @click="handleAction('show')"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                        <i class="fas fa-eye mr-3"></i>
                        <span>View</span>
                    </button>
                    <button @click="handleAction('edit')"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                        <i class="fas fa-edit mr-3"></i>
                        <span>Edit</span>
                    </button>
                    <button @click="handleAction('delete')"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-red-900">
                        <i class="fas fa-trash mr-3"></i>
                        <span>Delete</span>
                    </button>
                </div>
            </div>
        </transition>

        <!-- Delete Confirmation Popup -->
        <DeleteConfirmationPopup v-if="showDeletePopup" :item-name="itemNameToDelete" @confirm="handleDeleteConfirm"
            @cancel="showDeletePopup = false" />
    </div>
</template>

<script>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import DeleteConfirmationPopup from '@/layouts/components/DeleteConfirmationPopup.vue';

export default {
    components: {
        DeleteConfirmationPopup
    },
    props: {
        item: {
            type: Object,
            required: true
        }
    },
    setup(props, { emit }) {
        const isOpen = ref(false);
        const showDeletePopup = ref(false);
        const itemNameToDelete = ref('');
        const itemIdToDelete = ref(null);

        const toggleDropdown = () => {
            isOpen.value = !isOpen.value;
        };

        const closeDropdown = (event) => {
            if (!event.target.closest('.relative')) {
                isOpen.value = false;
            }
        };

        const handleAction = (action) => {
            if (action === 'delete') {
                itemIdToDelete.value = props.item.id;
                itemNameToDelete.value = props.item.name || `#${props.item.id}`;
                showDeletePopup.value = true;
            } else {
                emit(action, props.item);
            }
            isOpen.value = false;
        };

        const handleDeleteConfirm = () => {
            emit('delete', itemIdToDelete.value, itemNameToDelete.value);
            showDeletePopup.value = false;
        };

        onMounted(() => {
            document.addEventListener('click', closeDropdown);
        });

        onBeforeUnmount(() => {
            document.removeEventListener('click', closeDropdown);
        });

        return {
            isOpen,
            showDeletePopup,
            itemNameToDelete,
            toggleDropdown,
            handleAction,
            handleDeleteConfirm
        };
    }
};
</script>