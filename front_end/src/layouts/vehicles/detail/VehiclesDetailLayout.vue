<template>
    <!-- Sidebar overlay -->
    <div @click="toggleSidebar" :class="[
        'fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden',
        sidebarOpen ? '' : 'hidden',
    ]" id="sidebar-overlay"></div>

    <!-- Sidebar -->
    <aside :class="[
        'fixed md:sticky top-0 w-fit bg-white border-r border-surface-200 h-screen flex flex-col z-50 transition-transform duration-300',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0',
    ]">
        <AppAside />
    </aside>

    <div class="flex-1 flex flex-col">
        <!-- Header with search -->
        <header
            class="sticky top-0 flex items-center justify-between px-4 md:px-6 py-4 border-b border-surface-200 bg-white/80 backdrop-blur-sm z-30">
            <div class="flex items-center gap-3">
                <button @click="toggleSidebar" id="sidebar-toggle"
                    class="p-2 rounded-lg text-surface-500 hover:text-surface-700 hover:bg-surface-100 md:hidden">
                    <i class="fas fa-bars"></i>
                </button>


            </div>
            <div class="flex items-center gap-3 md:gap-4">
                <button
                    class="p-2 sm:flex hidden rounded-lg text-surface-500 hover:text-surface-700 hover:bg-surface-100 transition-colors relative">
                    <i class="fas fa-bell"></i>
                    <span
                        class="absolute top-1.5 right-1.5 block w-2 h-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                </button>
                <UserDropdown />
            </div>
        </header>

        <main class="p-4 md:p-6 space-y-6">



        </main>
    </div>
</template>

<script>
import vehicleService from '@/services/vehicle';
// import Forms from "./components/Forms.vue";
import ToggleMenu from "./components/ToggleMenu.vue";
import AppAside from '@/layouts/components/AppAside.vue';
import UserDropdown from '@/layouts/components/UserDropdown.vue';

export default {
    components: {
        AppAside,
        UserDropdown,
        ToggleMenu
    },
    data() {
        return {

            vehicles: [],
            loading: false,
            loadingVehicles: false,
            error: null,


            sidebarOpen: false,
            isSideFormVisible: false,
            pagination: {
                current_page: 1,
                per_page: 15,
                total: 0,
                last_page: 1,
                from: 0,
                to: 0
            },
        };
    },
    async created() {
        await this.fetchVehicles();
    },
    methods: {

        async fetchVehicles(page = 1) {
            this.loadingVehicles = true;
            try {
                const params = {
                    page: page,
                    perPage: this.pagination.per_page,
                    search: this.searchQuery
                };
                // Add filterType if set
                if (this.filterType) {
                    params.owner_type = this.filterType;
                }
                // id from url 
                const id = this.$route.params.id || null;
                console.log('Fetching vehicle with ID:', id);

                const response = await vehicleService.getById(id, params);

                // Standardized response handling
                this.vehicles = response.data;

                // Ensure meta exists
                if (!response.meta) {
                    console.warn('API response missing meta, generating fallback');
                    response.meta = {
                        current_page: 1,
                        per_page: this.pagination.per_page,
                        total: response.data.length,
                        last_page: 1,
                        from: 1,
                        to: response.data.length
                    };
                }

                this.updatePagination(response.meta);

            } catch (error) {
                console.error('Error fetching vehicles:', error);
                this.$toast.error("Failed to load vehicles: " + error.message);
            } finally {
                this.loadingVehicles = false;
            }
        },

    },
    mounted() {
        document.addEventListener('click', this.closeMenu);
    },
    beforeUnmount() {
        document.removeEventListener('click', this.closeMenu);
        clearTimeout(this.searchTimeout);
    }
};
</script>