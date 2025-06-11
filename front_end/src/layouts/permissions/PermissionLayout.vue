<template>
    <div class="flex-1 flex flex-col">
        <!-- Header with search -->
        <header
            class="sticky top-0 flex items-center justify-between px-4 md:px-6 py-4 border-b border-surface-200 bg-white/80 backdrop-blur-sm z-30">
            <span></span>
            <div class="flex items-center gap-3">
                <form @submit.prevent
                    class="flex items-center border border-surface-300 rounded-lg px-2 py-2 text-surface-500 max-w-md w-full focus-within:ring-2 focus-within:ring-accent-500 focus-within:border-accent-500 transition-all">
                    <i class="fas fa-search mr-2 text-sm"></i>
                    <input v-model="searchQuery" @input="handleSearchInput"
                        class="flex-1 outline-none text-sm text-surface-700 placeholder:text-surface-400 bg-transparent"
                        placeholder="Search permissions..." type="search" />
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

        <div v-if="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
            role="alert">
            <span class="block sm:inline">{{ errorMessage }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="errorMessage = null">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>

        <main class="p-4 md:p-6 space-y-6">
            <!-- Role Selection Card -->
            <div class="bg-white rounded-lg shadow-sm border border-surface-200 p-6 mb-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-surface-700 mb-1">Select Role</label>
                        <div class="relative">
                            <select v-model="selectedRole" @change="onRoleChange"
                                class="block w-full pl-3 pr-10 py-2 text-base border border-surface-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md transition-all duration-150 appearance-none bg-surface-50">
                                <option value="" disabled>-- Select a Role --</option>
                                <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-surface-500">
                                <i class="fas fa-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <div v-if="selectedRole" class="pt-4 border-t border-surface-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-semibold text-surface-900">Permissions for <span
                                        class="text-blue-600">{{ selectedRoleName }}</span></h3>
                                <p class="text-sm text-surface-500 mt-1" v-if="selectedPermissions.length > 0">
                                    {{ selectedPermissions.length }} permission{{ selectedPermissions.length !== 1 ? 's'
                                        : '' }} selected
                                </p>
                            </div>
                            <button @click="saveRolePermissions" :disabled="isSaving"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-70 disabled:cursor-not-allowed transition-colors duration-150 min-w-[150px] justify-center">
                                <i class="fas fa-save mr-2" :class="{ 'fa-spin': isSaving }"></i>
                                <span>{{ isSaving ? 'Saving...' : 'Save Permissions' }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="">
                <table class="min-w-full divide-y divide-surface-200">
                    <thead class="bg-surface-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider w-10">
                                <input type="checkbox" :checked="allPermissionsSelected"
                                    @change="toggleSelectAllPermissions"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                Permissions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-surface-200">
                        <template v-if="loadingPermissions">
                            <tr>
                                <td colspan="2" class="px-6 py-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                        <div v-for="i in 8" :key="`skeleton-${i}`"
                                            class="flex items-center space-x-3 p-3 border rounded-lg bg-surface-50 animate-pulse">
                                            <div class="h-4 w-4 bg-surface-200 rounded"></div>
                                            <div class="h-4 w-32 bg-surface-200 rounded"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr>
                                <td colspan="2" class="px-6 py-4">
                                    <div v-if="permissions.length > 0"
                                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                        <label v-for="permission in permissions" :key="permission.id"
                                            class="flex items-center space-x-3 p-3 border rounded-lg hover:bg-surface-50 cursor-pointer">
                                            <input type="checkbox" v-model="selectedPermissions"
                                                :value="String(permission.id)"
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <span class="text-sm font-medium text-surface-700">
                                                {{ permission.name }}
                                            </span>
                                        </label>
                                    </div>
                                    <div v-else class="text-center py-12">
                                        <div
                                            class="mx-auto w-16 h-16 rounded-full bg-surface-100 flex items-center justify-center mb-4">
                                            <i class="fas fa-lock text-surface-400 text-xl"></i>
                                        </div>
                                        <h4 class="text-lg font-medium text-surface-500 mb-1">No permissions found</h4>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</template>

<script>
import permissionService from '@/services/permissions.js';
import roleService from '@/services/roles.js';
import UserDropdown from "../components/UserDropdown.vue";
import { debounce } from 'lodash';

export default {
    components: {
        UserDropdown
    },
    data() {
        return {
            roles: [],
            selectedRole: '',
            selectedRoleName: '',
            permissions: [],
            selectedPermissions: [],
            loading: false,
            loadingPermissions: false,
            loadingRoles: false,
            error: null,
            success: null,
            searchQuery: '',
            isSearching: false,
            searchError: null,
            errorMessage: null,
            isSaving: false,
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
    computed: {
        allPermissionsSelected() {
            if (this.permissions.length === 0) return false;
            return this.permissions.every(perm => this.selectedPermissions.includes(String(perm.id)));
        },
        roleIdFromUrl() {
            return this.$route.query.role_id || null;
        }
    },
    watch: {
        roleIdFromUrl: {
            immediate: true,
            handler(newRoleId) {
                if (newRoleId) {
                    this.selectedRole = newRoleId;
                    this.loadRolePermissions();
                }
            }
        }
    },
    async created() {
        await this.fetchRoles();
        await this.fetchPermissions();

        // If URL has role_id but roles haven't loaded yet, wait for them
        if (this.roleIdFromUrl && !this.roles.length) {
            await this.fetchRoles();
        }
    },
    methods: {
        async fetchRoles() {
            this.loadingRoles = true;
            try {
                const response = await roleService.getAll();
                this.roles = response.data;

                // If URL has role_id, find and select the role
                if (this.roleIdFromUrl) {
                    const roleExists = this.roles.some(role => role.id === this.roleIdFromUrl);
                    if (roleExists) {
                        this.selectedRole = this.roleIdFromUrl;
                        await this.loadRolePermissions();
                    }
                }
            } catch (error) {
                console.error('Error fetching roles:', error);
                this.$toast.error("Failed to load roles");
                this.roles = [];
            } finally {
                this.loadingRoles = false;
            }
        },

        async fetchPermissions(page = 1) {
            this.loadingPermissions = true;
            try {
                const response = await permissionService.getAll({
                    page: page,
                    perPage: this.pagination.per_page,
                    search: this.searchQuery
                });

                this.permissions = response.data;
                this.updatePagination(response.meta || {});
            } catch (error) {
                console.error('Error fetching permissions:', error);
                this.$toast.error("Failed to load permissions");
                this.permissions = [];
                this.updatePagination({});
            } finally {
                this.loadingPermissions = false;
            }
        },

        async loadRolePermissions() {
            if (!this.selectedRole) {
                this.selectedPermissions = [];
                this.selectedRoleName = '';
                return;
            }

            this.loading = true;
            this.errorMessage = null;

            try {
                // Find the selected role name
                const role = this.roles.find(r => r.id === this.selectedRole);
                this.selectedRoleName = role ? role.name : '';

                // Load permissions for this role
                const response = await roleService.getPermissions(this.selectedRole);

                // Update URL with role_id if it's not already there
                if (this.$route.query.role_id !== this.selectedRole) {
                    this.$router.replace({
                        query: { ...this.$route.query, role_id: this.selectedRole }
                    });
                }

                // Ensure data is an array before mapping
                const permissionsData = Array.isArray(response.permissions)
                    ? response.permissions
                    : [];

                this.selectedPermissions = permissionsData.map(p => String(p.id)).filter(Boolean);

            } catch (error) {
                error.message ||
                    'Failed to load role permissions';
                this.selectedPermissions = [];
            } finally {
                this.loading = false;
            }
        },

        onRoleChange() {
            this.loadRolePermissions();
            // Update URL with the new role_id
            this.$router.replace({
                query: { ...this.$route.query, role_id: this.selectedRole }
            });
        },

        async saveRolePermissions() {

            if (!this.selectedRole) {
                this.$toast.warning("Please select a role first");
                return;
            }

            this.isSaving = true;
            this.errorMessage = null;

            try {
                await roleService.assignPermissions(this.selectedRole, {
                    permissions: this.selectedPermissions
                });
                this.$toast.success("Permissions updated successfully");
            } catch (error) {

                // Improved error handling
                let errorMessage = "Failed to save permissions";
                if (error?.response?.data?.message) {
                    errorMessage = error.response.data.message;
                } else if (error?.message) {
                    errorMessage = error.message;
                } else if (error?.response?.statusText) {
                    errorMessage = `${error.response.status}: ${error.response.statusText}`;
                }

            } finally {
                this.isSaving = false;
            }
        },


        toggleSelectAllPermissions() {
            if (this.allPermissionsSelected) {
                this.selectedPermissions = [];
            } else {
                this.selectedPermissions = this.permissions.map(p => String(p.id));
            }
        },

        updatePagination(meta) {
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

        handleSearchInput: debounce(function () {
            try {
                if (this.searchQuery.trim().length >= 3) {
                    this.searchPermissions();
                } else if (!this.searchQuery.trim()) {
                    this.clearSearch();
                }
            } catch (error) {
                console.error('Search input error:', error);
                this.$toast.error("An error occurred during search");
            }
        }, 500),

        async searchPermissions() {
            this.isSearching = true;
            this.searchError = null;

            try {
                const response = await permissionService.search({
                    query: this.searchQuery,
                    page: this.pagination.current_page,
                    perPage: this.pagination.per_page
                });

                this.permissions = response.data;
                this.updatePagination(response.meta);
            } catch (error) {
                console.error('Search error:', error);
                this.searchError = error.message;
                this.permissions = [];
                this.$toast.error(`Search failed: ${this.searchError}`);
            } finally {
                this.isSearching = false;
            }
        },

        clearSearch() {
            this.searchQuery = '';
            this.searchError = null;
            this.fetchPermissions();
        }
    }
};
</script>