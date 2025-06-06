<template>

    <div class="flex-1 flex flex-col">
        <!-- Header with search -->
        <header
            class="sticky top-0 flex items-center justify-between px-4 md:px-6 py-4 border-b border-surface-200 bg-white/80 backdrop-blur-sm z-30">
            <span></span>
            <div class="flex items-center gap-3">

                <form @input.prevent="searchRoles(searchQuery)"
                    class="flex items-center border border-surface-300 rounded-lg px-2 py-2 text-surface-500 max-w-md w-full focus-within:ring-2 focus-within:ring-accent-500 focus-within:border-accent-500 transition-all">
                    <i class="fas fa-search mr-2 text-sm"></i>
                    <input v-model="searchQuery" @input="handleSearchInput"
                        class="flex-1 outline-none text-sm text-surface-700 placeholder:text-surface-400 bg-transparent"
                        placeholder="Search roles..." type="search" />
                    <button v-if="searchQuery" @click="clearSearch" type="button"
                        class="ml-2 text-surface-400 hover:text-surface-600">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
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
            <!-- Roles Table -->
            <div class="bg-white rounded-xl shadow-sm border border-surface-200">
                <div class="px-6 py-4 border-b border-surface-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-surface-900">Roles</h2>
                            <p class="text-sm text-surface-500">
                                <template v-if="isSearching">Searching...</template>
                                <template v-else-if="searchError" class="text-red-500">{{ searchError }}</template>
                                <template v-else>
                                    Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} role

                                </template>
                            </p>
                        </div>
                        <button @click="openAddRoleForm"
                            class="text-sm font-semibold text-white hover:text-white p-2 bg-blue-500 hover:bg-blue-400 rounded-lg flex items-center justify-center text-center gap-2 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md">
                            <i class="fas fa-plus"></i>
                            <span>Add Role</span>
                        </button>
                    </div>
                </div>

                <div class=" ">
                    <table class="min-w-full divide-y divide-surface-200">
                        <thead class="bg-surface-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    #
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Role Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Permissions
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-surface-200">

                            <template v-if="loadingRoles">
                                <tr v-for="i in 5" :key="`skeleton-${i}`">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-4 bg-surface-200 rounded w-1/2 animate-pulse"></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-8 w-8 bg-surface-200 rounded-full animate-pulse">
                                            </div>
                                            <div class="ml-4">
                                                <div class="h-4 bg-surface-200 rounded w-32 animate-pulse"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-4 bg-surface-200 rounded w-12 animate-pulse"></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-4 bg-surface-200 rounded w-8 animate-pulse"></div>
                                    </td>
                                </tr>
                            </template>

                            <template v-else>
                                <tr v-for="role in roles" :key="role.id" class="hover:bg-surface-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-surface-900">
                                        {{ (pagination.from - 1) + (roles.indexOf(role) + 1) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-user-cog-icon lucide-user-cog">
                                                    <path d="M10 15H6a4 4 0 0 0-4 4v2" />
                                                    <path d="m14.305 16.53.923-.382" />
                                                    <path d="m15.228 13.852-.923-.383" />
                                                    <path d="m16.852 12.228-.383-.923" />
                                                    <path d="m16.852 17.772-.383.924" />
                                                    <path d="m19.148 12.228.383-.923" />
                                                    <path d="m19.53 18.696-.382-.924" />
                                                    <path d="m20.772 13.852.924-.383" />
                                                    <path d="m20.772 16.148.924.383" />
                                                    <circle cx="18" cy="15" r="3" />
                                                    <circle cx="9" cy="7" r="4" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">

                                                <!-- make it link  permissions?role_id=1 -->


                                                <router-link :to="`permissions?role_id=${role.id}`"
                                                    class="text-sm font-medium text-surface-900 hover:underline">{{
                                                        role.name
                                                    }}</router-link>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-700">
                                        <!-- Show permission count, fallback to 0 if not present -->
                                        <span v-if="role.permissions && Array.isArray(role.permissions)">
                                            {{ role.permissions.length }}
                                        </span>
                                        <span v-else>0</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                                        <ToggleMenu @show="() => $router.push(`/permissions?role_id=${role.id}`)"
                                            @edit="editRole(role)" @delete="confirmDelete(role.id, role.name)" />
                                    </td>
                                </tr>

                                <tr v-if="roles.length === 0 && !loadingRoles">
                                    <td colspan="10"
                                        class="px-4 py-8 text-center text-surface-400 text-base font-medium">
                                        <i class="fas fa-building-columns text-2xl mb-2 block"></i>
                                        No roles found
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <!-- <div v-if="pagination.last_page > 1" -->

                    <div v-if="pagination.last_page > 1"
                        class="px-6 py-4 border-t border-surface-200 flex items-center justify-between">
                        <div class="text-sm text-surface-500">
                            Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} results
                        </div>
                        <div class="flex space-x-2">
                            <button @click="prevPage" :disabled="pagination.current_page === 1"
                                class="px-3 py-1 border rounded-md text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                Previous
                            </button>
                            <button @click="nextPage" :disabled="pagination.current_page === pagination.last_page"
                                class="px-3 py-1 border rounded-md text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Role Form Sidebar -->
            <div id="side_form_container" class="side-form" :class="{ hidden: !isSideFormVisible }">
                <div
                    class="fixed z-50 top-0 left-0 bg-zinc-900 bg-opacity-50 h-full w-full shadow-2xl border border-gray-10 flex overflow-y-auto">
                    <button aria-label="Close" @click="toggleAddRoleForm"
                        class="toggle_side_form_btn absolute top-0 right-2 text-gey-500 m-5 hover:text-gray-700 rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-100 transition-colors duration-200">
                        <i class="fa fa-xmark"></i>
                    </button>
                    <div @click="toggleAddRoleForm" id="side_form"
                        class="w-0 md:w-full sticky top-0 bg-transparent cursor-pointer">
                    </div>
                    <div id="side_form" class="md:max-w-md p-6 w-full h-full bg-white rounded-xl">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="font-bold text-gray-800 text-xl md:text-2xl leading-tight">
                                Roles
                            </h2>
                        </div>
                        <p class="text-sm text-indigo-600 mb-6 leading-relaxed font-medium">
                            Update Role Information
                        </p>

                        <template v-if="isUpdating">
                            <form @submit.prevent="handleSubmitUpdate"
                                class="flex flex-col  space-y-6 js font-['Inter']">
                                <div>
                                    <label for="siteName"
                                        class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">
                                        Role Name</label>
                                    <input v-model="form.name" id="siteName" type="text"
                                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                        placeholder="Enter Role name" :required="form.isMenuOpen" />
                                    <input type="number" v-model="form.id" hidden>
                                </div>
                                <div v-if="success" class="text-blue-600 text-sm ">
                                    {{ success }}
                                </div>
                                <div v-else class="text-red-500 text-sm ">
                                    {{ error }}
                                </div>
                                <!-- Submit Button -->
                                <button :disabled="loading" type="submit"
                                    class="mt-6 w-full place-self-end-end bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md hover:shadow-lg">
                                    <span v-if="!loading">Update </span>
                                    <span v-else>Processing...</span> </button>
                            </form>
                        </template>
                        <template v-else>

                            <form @submit.prevent="handleSubmitAdd" class="flex flex-col  space-y-6 js font-['Inter']">
                                <div>
                                    <label for="siteName"
                                        class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">
                                        Role Name</label>
                                    <input v-model="form.name" id="siteName" type="text"
                                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                        placeholder="Enter Role name" />
                                </div>
                                <!-- Error Message -->
                                <div v-if="error" class="text-red-500 text-sm ">
                                    {{ error }}
                                </div>
                                <!-- Submit Button -->
                                <button :disabled="loading" type="submit"
                                    class="mt-6 w-full place-self-end-end bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md hover:shadow-lg">
                                    <span v-if="!loading">SAVE</span>
                                    <span v-else>Processing...</span> </button>
                            </form>
                        </template>

                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import roleService from '@/services/roles';
import AppAside from "../components/AppAside.vue";
import UserDropdown from "../components/UserDropdown.vue";
// import Forms from "./components/Forms.vue";
import ToggleMenu from "./components/ToggleMenu.vue";
import { debounce } from 'lodash';

export default {
    components: {
        AppAside,
        UserDropdown,
        ToggleMenu
    },
    data() {
        return {
            form: {
                name: "",
                active: true,
                isMenuOpen: false,

            },
            roles: [],
            loading: false,
            loadingRoles: false,
            error: null,
            success: null,
            editingRole: null,
            searchQuery: '',
            isSearching: false,
            isUpdating: false,

            searchTimeout: null,

            searchError: null,
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
        await this.fetchRoles();
    },
    methods: {
        async fetchRoles(page = 1) {
            this.loadingRoles = true;
            try {
                const response = await roleService.getAll({
                    page: page,
                    perPage: this.pagination.per_page,
                    search: this.searchQuery
                });


                // Standardized response handling
                this.roles = response.data;

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
                console.error('Error fetching roles:', error);
                this.$toast.error("Failed to load roles: " + error.message);
            } finally {
                this.loadingRoles = false;
            }
        },

        async handleSubmitAdd() {

            this.loading = true;
            this.error = null;
            // If editingRole is set, update the role, else create new

            try {
                const response = await roleService.store(this.form);
                await this.fetchRoles();


                this.form.name = "";
                this.isSideFormVisible = false;


            } catch (error) {
                this.error = error.response?.data?.message || error.message || "Failed to save role information";
                console.error("Role save error:", error);
            } finally {
                this.loading = false;
            }
        }, async handleSubmitUpdate() {

            this.loading = true;
            this.error = null;
            this.success = null;
            // If editingRole is set, update the role, else create new

            try {
                const response = await roleService.update(this.form.id, this.form);
                await this.fetchRoles();
                this.success = "Role updated successfully"




            } catch (error) {
                this.error = error.response?.data?.message || error.message || "Failed to save role information";
                console.error("Role save error:", error);
            } finally {
                this.loading = false;
            }
        },

        updatePagination(meta) {
            // Debugging: Log the incoming meta data

            const currentPage = meta.current_page || 1;
            const perPage = meta.per_page || this.pagination.per_page;
            const totalItems = meta.total || 0;
            const lastPage = meta.last_page || Math.ceil(totalItems / perPage) || 1;

            this.pagination = {
                current_page: currentPage,
                per_page: perPage,
                total: totalItems,
                last_page: lastPage,
                from: meta.from || ((currentPage - 1) * perPage) + 1,
                to: meta.to || Math.min(currentPage * perPage, totalItems)
            };

        },
        async searchRoles() {
            if (!this.searchQuery.trim()) {
                this.clearSearch();
                return;
            }

            this.isSearching = true;
            this.searchError = null;

            try {
                const response = await roleService.search({
                    query: this.searchQuery,
                    page: this.pagination.current_page,
                    perPage: this.pagination.per_page
                });

                if (response.success) {
                    this.roles = response.data;
                    this.updatePagination(response.meta);
                } else {
                    throw new Error(response.message || 'Invalid response');
                }
            } catch (error) {
                console.error('Search error:', error);
                this.searchError = typeof error === 'string' ? error : error.message;
                this.roles = [];
                this.$toast.error(`Search failed: ${this.searchError}`);
            } finally {
                this.isSearching = false;
            }
        },

        // Debounced search input handler
        handleSearchInput: debounce(function () {
            if (this.searchQuery.trim().length >= 3) {
                this.searchRoles();
            } else if (!this.searchQuery.trim()) {
                this.clearSearch();
            }
        }, 500),

        clearSearch() {
            this.searchQuery = '';
            this.searchError = null;
            this.fetchRoles();
        },
        nextPage() {
            if (this.pagination.current_page < this.pagination.last_page) {
                this.pagination.current_page++;
                this.loadRoles();
            }
        },

        prevPage() {
            if (this.pagination.current_page > 1) {
                this.pagination.current_page--;
                this.loadRoles();
            }
        },

        async loadRoles() {
            this.loadingRoles = true;
            try {
                const params = {
                    page: this.pagination.current_page,
                    per_page: this.pagination.per_page
                };

                // Include search query if it exists
                if (this.searchQuery.trim()) {
                    params.q = this.searchQuery.trim();
                }

                const response = await roleService.getAll(params);

                this.roles = response.data || [];
                this.updatePagination(response.meta || {});

            } catch (error) {
                console.error('Error loading roles:', error);
                this.$toast.error('Failed to load roles');
            } finally {
                this.loadingRoles = false;
            }
        },



        openAddRoleForm() {
            this.isUpdating = false;

            this.resetForm();
            this.isSideFormVisible = true;
        },

        toggleAddRoleForm() {
            this.isSideFormVisible = !this.isSideFormVisible;
            if (!this.isSideFormVisible) {
                this.resetForm();
            }
        },

        async handleSubmit() {
            this.loading = true;
            this.error = null;

            try {
                if (this.editingRole) {
                    await roleService.update(this.editingRole.id, this.form);
                    this.$toast.success("Role updated successfully");
                } else {
                    await roleService.store(this.form);
                    this.$toast.success("Role created successfully");
                }

                this.closeSideForm();
                await this.fetchRoles();
            } catch (error) {
                this.error = error.message;
                this.$toast.error("Operation failed");
            } finally {
                this.loading = false;
            }
        },
        // role edit function
        editRole(role) {
            this.isUpdating = true;
            this.form = {
                name: role.name,
                id: role.id,
            };
            this.isSideFormVisible = true;

        },

        async confirmDelete(id, name) {
            if (confirm(`Are you sure you want to delete ${name} role?`)) {
                try {
                    await roleService.delete(id);
                    await this.fetchRoles();

                    this.$toast.success("Role deleted successfully");


                } catch (error) {
                    this.$toast.error("Failed to delete role");
                }
            }
        },

        resetForm() {
            this.form = {
                name: "",
                active: true
            };
            this.editingRole = null;
            this.error = null;
        },

        closeSideForm() {
            this.isSideFormVisible = false;
            this.resetForm();
        },

        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        },

        toggleMenu() {
            this.isOpen = !this.isOpen;
        },

        closeMenu(e) {
            if (!this.$el.contains(e.target)) {
                this.isOpen = false;
            }
        }
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

<style scoped>
.side-form {
    transition: all 0.3s ease;
}

.side-form.hidden {
    opacity: 0;
    visibility: hidden;
}

.pagination-controls {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    margin-top: 1.5rem;
    padding: 1rem 0;
}

.pagination-button {
    padding: 0.5rem 1rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    background: white;
    cursor: pointer;
    transition: all 0.2s ease;
}

.pagination-button:hover:not(:disabled) {
    background: #f5f5f5;
}

.pagination-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.pagination-info {
    font-size: 0.9rem;
    color: #666;
}
</style>