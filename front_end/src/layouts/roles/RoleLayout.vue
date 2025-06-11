<template>
    <div class="flex-1 flex flex-col">
        <!-- Header with search -->
        <header
            class="sticky top-0 flex items-center justify-between px-4 md:px-6 py-4 border-b border-surface-200 bg-white/80 backdrop-blur-sm z-30">
            <span></span>

            <UserDropdown />
        </header>

        <main class="p-4 md:p-6 space-y-6">
            <!-- Combined Role & Permission Management -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Roles Section -->
                <div
                    class="lg:col-span-1 h-fit md:sticky top-20 bg-white rounded-xl shadow-sm border border-surface-200">
                    <div class="px-6 py-4 border-b border-surface-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-semibold text-surface-900">Roles</h2>
                                <p class="text-sm text-surface-500">
                                    <template v-if="isSearching">Searching...</template>
                                    <template v-else-if="searchError" class="text-red-500">{{ searchError
                                    }}</template>
                                    <template v-else>
                                        Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total
                                        }}
                                        roles
                                    </template>
                                </p>
                            </div>
                            <button @click="openAddRoleForm"
                                class="text-sm font-semibold text-white hover:text-white p-2 bg-blue-500 hover:bg-blue-400 rounded-lg flex items-center justify-center text-center gap-2 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md">
                                <i class="fas fa-plus"></i>
                                <span>Add Role</span>
                            </button>

                        </div>
                        <div class="" style="max-height: 600px;">
                            <table class="min-w-full divide-y divide-surface-200">
                                <thead class="bg-surface-50 sticky top-0">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                            Role Name
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                            Perms
                                        </th>
                                        <th scope="col" class="relative px-6 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-surface-200">
                                    <template v-if="loadingRoles">
                                        <tr v-for="i in 5" :key="`skeleton-${i}`">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="h-4 bg-surface-200 rounded w-3/4 animate-pulse"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="h-4 bg-surface-200 rounded w-8 animate-pulse"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="h-4 bg-surface-200 rounded w-8 animate-pulse"></div>
                                            </td>
                                        </tr>
                                    </template>
                                    <template v-else>
                                        <tr v-for="role in roles" :key="role.id"
                                            class="hover:bg-surface-50 cursor-pointer"
                                            :class="{ 'bg-blue-50': selectedRole && selectedRole.id === role.id }"
                                            @click="selectRole(role)">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-8 w-8">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" class="lucide lucide-user-cog">
                                                            <path d="M10 15H6a4 4 0 0 0-4 4v2" />
                                                            <circle cx="18" cy="15" r="3" />
                                                            <circle cx="9" cy="7" r="4" />
                                                            <path d="M19 15v3.5" />
                                                            <path d="M16 18h6" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-surface-900">{{ role.name
                                                            }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-700">
                                                {{ role.permissions_count !== null ? role.permissions_count : 0 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <ToggleMenu :item="role" @edit="editRole" @delete="confirmDelete" />
                                            </td>
                                        </tr>
                                        <tr v-if="roles.length === 0 && !loadingRoles">
                                            <td colspan="3"
                                                class="px-4 py-8 text-center text-surface-400 text-base font-medium">
                                                <i class="fas fa-building-columns text-2xl mb-2 block"></i>
                                                No roles found
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div v-if="pagination.last_page > 1"
                        class="px-6 py-4 border-t border-surface-200 flex items-center justify-between">
                        <div class="text-sm text-surface-500">
                            Page {{ pagination.current_page }} of {{ pagination.last_page }}
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

                <!-- Permissions Section -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-surface-200">
                    <div class="px-6 py-4 border-b border-surface-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-semibold text-surface-900">
                                    Permissions
                                    <span v-if="selectedRole" class="text-blue-600">for {{ selectedRole.name }}</span>
                                    <span v-else class="text-gray-500">(Select a role)</span>
                                </h2>
                                <p class="text-sm text-surface-500 mt-1" v-if="selectedRole">
                                    {{ selectedPermissions.length }} permission{{ selectedPermissions.length !== 1 ? 's'
                                        : '' }}
                                    selected
                                </p>
                            </div>
                            <button @click="saveRolePermissions" :disabled="!selectedRole || isSaving"
                                class="text-sm font-semibold text-white p-2 bg-blue-500 hover:bg-blue-400 rounded-lg flex items-center justify-center gap-2 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md disabled:opacity-70 disabled:cursor-not-allowed">
                                <i class="fas fa-save" :class="{ 'fa-spin': isSaving }"></i>
                                <span>{{ isSaving ? 'Saving...' : 'Save Permissions' }}</span>
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        <div v-if="!selectedRole" class="text-center py-12 text-surface-400">
                            <i class="fas fa-user-shield text-4xl mb-4"></i>
                            <p class="text-lg">Please select a role to manage permissions</p>
                        </div>

                        <div v-else>
                            <div class="mb-4 flex justify-between items-center">
                                <div class="flex items-center">
                                    <input type="checkbox" :checked="allPermissionsSelected"
                                        @change="toggleSelectAllPermissions"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-2">
                                    <span class="text-sm text-surface-700">
                                        {{ allPermissionsSelected ? 'Deselect All' : 'Select All' }}
                                    </span>
                                </div>
                                <div class="relative">
                                    <input v-model="permissionSearch" @input="filterPermissions"
                                        placeholder="Filter permissions..."
                                        class="pl-8 pr-4 py-2 border border-surface-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <i class="fas fa-search absolute left-3 top-3 text-surface-400 text-sm"></i>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                <template v-if="loadingPermissions">
                                    <div v-for="i in 6" :key="`perm-skeleton-${i}`"
                                        class="p-3 border rounded-lg bg-surface-50 animate-pulse">
                                        <div class="h-4 w-3/4 bg-surface-200 rounded mb-2"></div>
                                        <div class="h-3 w-1/2 bg-surface-200 rounded"></div>
                                    </div>
                                </template>

                                <template v-else>
                                    <label v-for="permission in filteredPermissions" :key="permission.id"
                                        class="flex items-start p-3 border rounded-lg hover:bg-surface-50 cursor-pointer transition-colors"
                                        :class="{ 'border-blue-300 bg-blue-50': selectedPermissions.includes(String(permission.id)) }">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" v-model="selectedPermissions"
                                                :value="String(permission.id)"
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <span class="font-medium text-surface-700">{{ permission.name }}</span>
                                            <p class="text-surface-500 mt-1 text-xs">
                                                {{ permission.description || 'No description' }}</p>
                                        </div>
                                    </label>
                                </template>

                                <div v-if="filteredPermissions.length === 0 && !loadingPermissions"
                                    class="col-span-full text-center py-8 text-surface-400">
                                    <i class="fas fa-ban text-2xl mb-2"></i>
                                    <p>No permissions found</p>
                                </div>
                            </div>
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
                                {{ isUpdating ? 'Update' : 'Add' }} Role
                            </h2>
                        </div>
                        <p class="text-sm text-indigo-600 mb-6 leading-relaxed font-medium">
                            {{ isUpdating ? 'Update role information' : 'Create a new role' }}
                        </p>

                        <form @submit.prevent="isUpdating ? handleSubmitUpdate() : handleSubmitAdd()"
                            class="flex flex-col space-y-6">
                            <div>
                                <label for="roleName"
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">
                                    Role Name
                                </label>
                                <input v-model="form.name" id="roleName" type="text"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                    placeholder="Enter role name" required>
                                <input type="hidden" v-model="form.id">
                            </div>

                            <div v-if="error" class="text-red-500 text-sm">
                                {{ error }}
                            </div>
                            <div v-if="success" class="text-green-500 text-sm">
                                {{ success }}
                            </div>

                            <button :disabled="loading" type="submit"
                                class="mt-6 w-full place-self-end-end bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md hover:shadow-lg">
                                <span v-if="!loading">{{ isUpdating ? 'Update' : 'Save' }}</span>
                                <span v-else>Processing...</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import roleService from '@/services/roles';
import permissionService from '@/services/permissions';
import UserDropdown from "../components/UserDropdown.vue";
import ToggleMenu from "@/layouts/components/ToggleMenu.vue";
import { debounce } from 'lodash';

export default {
    components: {
        UserDropdown,
        ToggleMenu
    },
    data() {
        return {
            // Roles data
            roles: [],
            selectedRole: null,
            loadingRoles: false,
            isSideFormVisible: false,
            isUpdating: false,

            // Permissions data
            permissions: [],
            filteredPermissions: [],
            selectedPermissions: [],
            loadingPermissions: false,
            isSaving: false,
            permissionSearch: '',

            // Forms
            form: {
                id: null,
                name: '',
            },

            // Search & pagination
            searchQuery: '',
            isSearching: false,
            searchError: null,
            error: null,
            success: null,
            loading: false,

            pagination: {
                current_page: 1,
                per_page: 15,
                total: 0,
                last_page: 1,
                from: 0,
                to: 0
            }
        };
    },
    computed: {
        allPermissionsSelected() {
            if (this.filteredPermissions.length === 0) return false;
            return this.filteredPermissions.every(perm => this.selectedPermissions.includes(String(perm.id)))
        }
    },
    async created() {
        await this.fetchRoles();
        await this.fetchAllPermissions();
    },
    methods: {
        // Role methods
        async fetchRoles() {
            this.loadingRoles = true;
            try {
                const response = await roleService.getAll({
                    page: this.pagination.current_page,
                    perPage: this.pagination.per_page,
                    search: this.searchQuery
                });

                this.roles = response.data;
                this.updatePagination(response.meta);

                // If we have a selected role, refresh its data
                if (this.selectedRole) {
                    const updatedRole = this.roles.find(r => r.id === this.selectedRole.id);
                    if (updatedRole) {
                        this.selectedRole = updatedRole;
                    }
                }
            } catch (error) {
                console.error('Error fetching roles:', error);
                this.searchError = "Failed to load roles. Please try again.";
            } finally {
                this.loadingRoles = false;
                this.isSearching = false;
            }
        },

        selectRole(role) {
            this.selectedRole = role;
            this.loadRolePermissions();
        },

        async loadRolePermissions() {
            if (!this.selectedRole) return;

            this.loadingPermissions = true;
            this.selectedPermissions = []; // Reset before loading

            try {
                const response = await roleService.getPermissions(this.selectedRole.id);

                // Handle null/undefined permissions
                if (!response || !response.permissions) {
                    console.warn('No permissions data received for role', this.selectedRole.id);
                    this.selectedPermissions = [];
                    return;
                }

                // Handle different response formats
                let permissionsData = [];


                if (Array.isArray(response.permissions)) {
                    permissionsData = response.permissions;
                } else if (response.permission.id) {
                    // If we just get an array of IDs
                    permissionsData = response.permission.id.map(id => ({ id }));
                }

                // Safely map permissions
                this.selectedPermissions = permissionsData
                    .filter(p => p !== null && p !== undefined) // Filter out null values
                    .map(p => String(p.id || p)); // Handle both objects and direct IDs

            } catch (error) {
                console.error('Error loading permissions:', error);
                this.$toast.error("Failed to load permissions");
                this.selectedPermissions = [];
            } finally {
                this.loadingPermissions = false;
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

        editRole(role) {
            this.form = {
                id: role.id,
                name: role.name
            };
            this.isUpdating = true;
            this.isSideFormVisible = true;
        },

        async handleSubmitAdd() {
            this.loading = true;
            this.error = null;
            this.success = null;

            try {
                const response = await roleService.store(this.form);
                await this.fetchRoles();
                this.toggleAddRoleForm();
            } catch (error) {
                this.error = error.response?.data?.message || error.message || "Failed to create role";
                console.error("Role creation error:", error);
            } finally {
                this.loading = false;
            }
        },

        async handleSubmitUpdate() {
            this.loading = true;
            this.error = null;
            this.success = null;

            try {
                const response = await roleService.update(this.form.id, this.form);
                this.success = "Role updated successfully";
                await this.fetchRoles();

                // If we're updating the currently selected role, update it
                if (this.selectedRole && this.selectedRole.id === this.form.id) {
                    this.selectedRole.name = this.form.name;
                }
            } catch (error) {
                this.error = error.response?.data?.message || error.message || "Failed to update role";
                console.error("Role update error:", error);
            } finally {
                this.loading = false;
            }
        },

        async confirmDelete(role) {





            try {
                await roleService.delete(role);

                // If we're deleting the currently selected role, clear selection
                if (this.selectedRole && this.selectedRole.id === role.id) {
                    this.selectedRole = null;
                    this.selectedPermissions = [];
                }

                await this.fetchRoles();
            } catch (error) {
                this.$toast.error("Failed to delete role");
                console.error("Role deletion error:", error);
            }
        },

        // Permission methods
        async fetchAllPermissions() {
            this.loadingPermissions = true;
            try {
                const response = await permissionService.getAll();
                this.permissions = response.data;
                this.filteredPermissions = [...this.permissions];
            } catch (error) {
                console.error('Error fetching permissions:', error);
                this.$toast.error("Failed to load permissions");
            } finally {
                this.loadingPermissions = false;
            }
        },

        filterPermissions: debounce(function () {
            if (!this.permissionSearch.trim()) {
                this.filteredPermissions = [...this.permissions];
                return;
            }

            const searchTerm = this.permissionSearch.toLowerCase();
            this.filteredPermissions = this.permissions.filter(perm =>
                perm.name.toLowerCase().includes(searchTerm) ||
                (perm.description && perm.description.toLowerCase().includes(searchTerm))
            );
        }, 300),

        toggleSelectAllPermissions() {
            const allFilteredPermIds = this.filteredPermissions.map(p => String(p.id));

            if (this.allPermissionsSelected) {
                // Remove all filtered permissions from selection
                this.selectedPermissions = this.selectedPermissions.filter(
                    id => !allFilteredPermIds.includes(id));
            } else {
                // Add all filtered permissions to selection (without duplicates)
                const newSelection = [...new Set([...this.selectedPermissions, ...allFilteredPermIds])];
                this.selectedPermissions = newSelection;
            }
        },

        async saveRolePermissions() {
            if (!this.selectedRole) return;

            this.isSaving = true;
            try {
                await roleService.assignPermissions(this.selectedRole.id, {
                    permissions: this.selectedPermissions
                });

                // Update the permissions count for the selected role
                const updatedRole = await roleService.get(this.selectedRole.id);

                this.selectedRole.permissions_count = updatedRole.permissions_count;
            } catch (error) {
                console.error('Error saving permissions:', error);
                this.$toast.error("Failed to save permissions");
            } finally {
                this.isSaving = false;
            }
        },

        // Search & pagination
        handleSearchInput: debounce(function () {
            this.isSearching = true;
            this.searchError = null;
            if (this.searchQuery.trim().length >= 3 || !this.searchQuery.trim()) {
                this.pagination.current_page = 1; // Reset to first page when searching
                this.fetchRoles();
            }
        }, 500),

        clearSearch() {
            this.searchQuery = '';
            this.isSearching = false;
            this.searchError = null;
            this.pagination.current_page = 1;
            this.fetchRoles();
        },

        nextPage() {
            if (this.pagination.current_page < this.pagination.last_page) {
                this.pagination.current_page++;
                this.fetchRoles();
            }
        },

        prevPage() {
            if (this.pagination.current_page > 1) {
                this.pagination.current_page--;
                this.fetchRoles();
            }
        },

        updatePagination(meta) {
            this.pagination = {
                current_page: meta.current_page || 1,
                per_page: meta.per_page || this.pagination.per_page,
                total: meta.total || 0,
                last_page: meta.last_page || 1,
                from: meta.from || 1,
                to: meta.to || meta.per_page || this.pagination.per_page
            };
        },

        resetForm() {
            this.form = {
                id: null,
                name: ''
            };
            this.error = null;
            this.success = null;
        }
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

/* Custom scrollbar for the roles table */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>