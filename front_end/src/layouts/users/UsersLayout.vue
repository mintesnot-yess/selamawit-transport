<template>
    <div class="flex-1 flex flex-col">
        <!-- Header with search -->
        <header
            class="sticky top-0 flex items-center justify-between px-4 md:px-6 py-4 border-b border-surface-200 bg-white/80 backdrop-blur-sm z-30">
            <span></span>
            <div class="flex items-center gap-3">
                <!-- Enhanced Search -->
                <form @submit.prevent="searchUsers(searchQuery)"
                    class="flex items-center border border-surface-300 rounded-lg px-2 py-2 text-surface-500 max-w-md w-full focus-within:ring-2 focus-within:ring-accent-500 focus-within:border-accent-500 transition-all">
                    <i class="fas fa-search mr-2 text-sm"></i>
                    <input v-model="searchQuery" @input="handleSearchInput"
                        class="flex-1 outline-none text-sm text-surface-700 placeholder:text-surface-400 bg-transparent"
                        placeholder="Search users..." type="search" />
                    <button v-if="searchQuery" @click="clearSearch" type="button"
                        class="ml-2 text-surface-400 hover:text-surface-600">
                        <i class="fas fa-times"></i>
                    </button>
                </form>


            </div>



            <UserDropdown />

        </header>

        <main class="p-4 md:p-6 space-y-6">
            <!-- Users Table -->
            <div class="bg-white rounded-xl shadow-sm border border-surface-200">
                <div class="px-6 py-4 border-b border-surface-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-surface-900">Users</h2>
                            <p class="text-sm text-surface-500">
                                <template v-if="isSearching">Searching...</template>
                                <template v-else-if="searchError" class="text-red-500">{{ searchError }}</template>
                                <template v-else>
                                    Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} users
                                </template>
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <button @click="bulkDelete" v-if="selectedUsers.length > 0"
                                class="text-sm font-semibold text-white p-2 bg-red-500 hover:bg-red-400 rounded-lg flex items-center gap-2 transition-colors duration-200">
                                <i class="fas fa-trash"></i> Delete Selected
                            </button>
                            <button @click="exportToCSV" title="Export Users"
                                class="p-2 sm:flex hidden rounded-lg text-surface-500 hover:text-surface-700 hover:bg-surface-100 transition-colors">
                                <i class="fas fa-download"></i>
                            </button>

                            <button @click="openAddUserForm"
                                class="text-sm font-semibold text-white p-2 bg-blue-500 hover:bg-blue-400 rounded-lg flex items-center gap-2 transition-colors duration-200">
                                <i class="fas fa-plus"></i>
                                <span>Add User</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="">
                    <table class="min-w-full divide-y divide-surface-200">
                        <thead class="bg-surface-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    <input type="checkbox" v-model="selectAll" @change="toggleSelectAll" />
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    #
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    User Name
                                </th>
                                <th scope="col" class="relative px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-surface-200">
                            <template v-if="loadingUsers">
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
                                        <div class="h-4 bg-surface-200 rounded w-8 animate-pulse"></div>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr v-for="user in users" :key="user.id" class="hover:bg-surface-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" v-model="selectedUsers" :value="user.id" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-surface-900">
                                        {{ (pagination.from - 1) + (users.indexOf(user) + 1) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                            <div class="ml-4">
                                                <router-link :to="`/users/${user.id}`" class="text-sm font-medium "
                                                    :class="{
                                                        'text-primary-600 font-bold': isCurrentUser(user),
                                                        'text-surface-900': !isCurrentUser(user)
                                                    }">

                                                    {{ user.name }}
                                                    <span v-if="isCurrentUser(user)"
                                                        class="ml-1 text-xs text-primary-400">(You)</span>
                                                </router-link>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">


                                        <ToggleMenu @show="() => $router.push(`/users/${user.id}`)" :item="user"
                                            @edit="editUser" @delete="confirmDelete" />
                                    </td>
                                </tr>
                                <tr v-if="users.length === 0 && !loadingUsers">
                                    <td colspan="10"
                                        class="px-4 py-8 text-center text-surface-400 text-base font-medium">
                                        <i class="fas fa-user text-2xl mb-2 block"></i>
                                        No users found
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <!-- <div v-if="pagination.last_page > 1" -->
                    <div
                        class="px-6 py-4 border-t border-surface-200 flex flex-wrap items-center justify-between gap-3">
                        <div class="text-sm text-surface-500">
                            Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} results
                        </div>
                        <div class="flex items-center gap-2">
                            <select v-model.number="pagination.per_page" @change="fetchUsers()"
                                class="rounded border px-3 py-1">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <input v-model.number="pagination.current_page" @change="fetchUsers()"
                                class="w-12 text-center rounded border border-gray-300 px-2 py-1" type="number" min="1"
                                :max="pagination.last_page" />
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

            <!-- USER FORM SIDEBAR (Original Structure) -->
            <div id="side_form_container" class="side-form" :class="{ hidden: !isSideFormVisible }">
                <div
                    class="fixed z-50 top-0 left-0 bg-zinc-900 bg-opacity-50 h-full w-full shadow-2xl border border-gray-10 flex overflow-y-auto">
                    <button aria-label="Close" @click="closeSideForm"
                        class="absolute top-0 right-2 text-gray-500 m-5 hover:text-gray-700 rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-100 transition-colors duration-200">
                        <i class="fa fa-xmark"></i>
                    </button>

                    <div @click="closeSideForm" id="side_form"
                        class="w-0 md:w-full sticky top-0 bg-transparent cursor-pointer">
                    </div>

                    <div id="side_form" class="md:max-w-md p-6 w-full h-full bg-white rounded-xl">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="font-bold text-gray-800 text-xl md:text-2xl leading-tight">
                                {{ isUpdating ? 'Update User' : 'Add New User' }}
                            </h2>
                        </div>
                        <p class="text-sm text-indigo-600 mb-6 leading-relaxed font-medium">
                            {{ isUpdating ? 'Update User Information' : 'Fill in the user details' }}
                        </p>

                        <form @submit.prevent="handleSubmit" class="flex flex-col space-y-6 js font-['Inter']">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">
                                    User Name
                                </label>
                                <input v-model="form.name" id="name" type="text"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                    placeholder="Enter User name" required />
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">
                                    Email
                                </label>
                                <input v-model="form.email" id="email" type="email"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                    placeholder="Enter User email" required />
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">
                                    Role
                                </label>
                                <select v-model="form.role" id="role"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm">
                                    <option value="" disabled selected>Select Role</option>
                                    <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}
                                    </option>
                                </select>
                            </div>

                            <!-- Password Fields -->
                            <template v-if="!isUpdating">
                                <!-- Password -->
                                <div>
                                    <label for="password"
                                        class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Password</label>
                                    <div class="relative">
                                        <input v-model="form.password" id="password"
                                            :type="showPassword ? 'text' : 'password'" required
                                            class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                            placeholder="Enter Password" />
                                        <button @click.stop="showPassword = !showPassword" type="button"
                                            class="absolute right-3 top-3 text-gray-400">
                                            {{ showPassword ? "Hide" : "Show" }}
                                        </button>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label for="password_confirmation"
                                        class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Confirm
                                        Password</label>
                                    <input v-model="form.password_confirmation" id="password_confirmation"
                                        type="password" required
                                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                        placeholder="Confirm Password" />
                                </div>
                            </template>

                            <!-- Messages -->
                            <div v-if="success" class="text-blue-600 text-sm">{{ success }}</div>
                            <div v-if="error" class="text-red-500 text-sm">{{ error }}</div>

                            <!-- Submit Button -->
                            <button :disabled="loading" type="submit"
                                class="mt-6 w-full place-self-end bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md hover:shadow-lg">
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
import userService from '@/services/users';
import authService from '@/services/auth';
import AppAside from '../components/AppAside.vue';
import UserDropdown from '../components/UserDropdown.vue';
import { debounce } from 'lodash';
import ToggleMenu from "@/layouts/components/ToggleMenu.vue";
import { useProfileStore } from "@/stores/profile";

function exportToCSV(data, filename) {
    const csvRows = [];
    const headers = Object.keys(data[0]);
    csvRows.push(headers.join(','));

    for (const row of data) {
        const values = headers.map(header => `"${row[header]}"`);
        csvRows.push(values.join(','));
    }

    const csvString = csvRows.join('\n');
    const blob = new Blob([csvString], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
}

export default {
    components: {
        AppAside,
        UserDropdown,
        ToggleMenu,
    },
    data() {
        return {
            // Form Data
            form: {
                id: null,
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                role: '',
            },
            showPassword: false,

            // Users & Roles
            users: [],
            roles: [],

            // Loaders
            loading: false,
            loadingUsers: false,

            // Messages
            error: null,
            success: null,

            // State
            isUpdating: false,
            isSideFormVisible: false,

            // Search & Filters
            searchQuery: '',
            isSearching: false,
            searchError: null,
            filters: {
                role: '',
                status: ''
            },

            // Pagination
            pagination: {
                current_page: 1,
                per_page: 10,
                total: 0,
                last_page: 1,
                from: 0,
                to: 0
            },

            // Bulk Actions
            selectedUsers: [],
            selectAll: false,

            // Unsaved warning
            formChanged: false
        };
    },
    watch: {
        'form.email'(newVal) {
            if (!this.isUpdating && newVal) {
                this.checkEmailExists(newVal);
            }
        },
        'form.password'(newVal) {
            if (!this.isPasswordStrong(newVal)) {
                this.error = 'Password must be at least 8 characters long, include uppercase, lowercase, and numbers.';
            } else {
                this.error = '';
            }
        },
        'form.password_confirmation'(newVal) {
            if (this.form.password !== newVal) {
                this.error = "Passwords don't match.";
            } else {
                this.error = '';
            }
        }
    },
    methods: {
        isPasswordStrong(password) {
            return (
                password.length >= 8 &&
                /[A-Z]/.test(password) &&
                /[a-z]/.test(password) &&
                /\d/.test(password)
            );
        },
        async checkEmailExists(email) {
            try {
                const response = await userService.checkEmailExists(email);
                if (response.exists) {
                    this.error = 'This email is already taken.';
                }
            } catch (err) {
                console.error('Email check error:', err);
            }
        },
        async fetchUsers(page = 1) {
            this.loadingUsers = true;
            try {
                const response = await userService.getAll({
                    page: page,
                    perPage: this.pagination.per_page,
                    search: this.searchQuery,
                    role: this.filters.role,
                    status: this.filters.status
                });

                this.roles = response.roles || [];
                this.users = response.data || [];

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
                console.error('Error fetching users:', error);
                this.$toast.error('Failed to load users: ' + error.message);
            } finally {
                this.loadingUsers = false;
            }
        },

        async fetchUserRole() {

            try {
                const response = await authService.fetchUser();

                // this.roles = response.roles || [];

            } catch (e) {

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
            if (this.searchQuery.trim().length >= 3) {
                this.fetchUsers(1);
            } else if (!this.searchQuery.trim()) {
                this.clearSearch();
            }
        }, 500),
        clearSearch() {
            this.searchQuery = '';
            this.fetchUsers(1);
        },
        nextPage() {
            if (this.pagination.current_page < this.pagination.last_page) {
                this.pagination.current_page++;
                this.fetchUsers(this.pagination.current_page);
            }
        },
        prevPage() {
            if (this.pagination.current_page > 1) {
                this.pagination.current_page--;
                this.fetchUsers(this.pagination.current_page);
            }
        },
        openAddUserForm() {
            this.isUpdating = false;
            this.resetForm();
            this.isSideFormVisible = true;
        },
        closeSideForm() {
            if (this.formChanged && !confirm('You have unsaved changes. Leave anyway?')) {
                return;
            }
            this.isSideFormVisible = false;
            this.resetForm();
        },
        editUser(user) {
            if (this.isCurrentUser(user)) {
                this.$toast.warning("You can't edit your own account.");
                return;
            }
            this.isUpdating = true;
            this.form = {
                id: user.id,
                name: user.name,
                email: user.email,
                role: user.role_id || user.role,
                password: '',
                password_confirmation: ''
            };
            this.isSideFormVisible = true;
        },
        resetForm() {
            this.form = {
                id: null,
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                role: ''
            };
            this.showPassword = false;
            this.error = null;
            this.success = null;
            this.formChanged = false;
        },
        async handleSubmit() {
            this.loading = true;
            this.error = null;
            this.success = null;

            try {
                if (!this.isPasswordStrong(this.form.password) && !this.isUpdating) {
                    throw new Error('Password does not meet requirements.');
                }

                if (!this.isUpdating && this.form.password !== this.form.password_confirmation) {
                    throw new Error("Passwords don't match");
                }

                if (this.isUpdating) {
                    // Update existing user
                    const response = await userService.update(this.form.id, {
                        name: this.form.name,
                        email: this.form.email,
                        role: this.form.role
                    });
                    this.success = 'User updated successfully';
                } else {
                    // Create new user
                    const { access_token } = await authService.register({
                        name: this.form.name,
                        email: this.form.email,
                        password: this.form.password,
                        password_confirmation: this.form.password_confirmation,
                        role: this.form.role
                    });
                    this.success = 'User created successfully';
                }

                await this.fetchUsers();
                this.closeSideForm();
            } catch (error) {
                this.error =
                    error.response?.data?.message ||
                    error.message ||
                    (this.isUpdating ? 'Failed to update user' : 'Failed to create user');
                console.error('User form error:', error);
            } finally {
                this.loading = false;
            }
        },
        bulkDelete() {
            if (confirm(`Are you sure you want to delete ${this.selectedUsers.length} users?`)) {
                userService
                    .bulkDelete({ ids: this.selectedUsers })
                    .then(() => {
                        this.fetchUsers();

                        this.$toast.success('Users deleted successfully');
                        this.selectedUsers = [];
                        this.selectAll = false;
                    })
                    .catch((err) => {
                        this.$toast.error('Failed to delete users');
                        console.error(err);
                    });
            }
        },
        toggleSelectAll() {
            this.selectAll
                ? (this.selectedUsers = this.users.map((u) => u.id))
                : (this.selectedUsers = []);
        },
        exportToCSV() {
            exportToCSV(this.users, `users_${new Date().toISOString().split('T')[0]}.csv`);
        },

        isCurrentUser(user) {
            try {

                const profile = useProfileStore();

                return profile.user?.email && user?.email && profile.user.email === user.email;
            } catch (e) {
                return false;
            }
        },

        confirmDelete(id, name) {
            userService
                .delete(id)
                .then(() => {
                    this.fetchUsers();
                    this.$toast.success('User deleted successfully');
                })
                .catch((err) => {
                    this.$toast.error('Failed to delete user');
                    console.error(err);
                });
        }
    },
    mounted() {
        this.fetchUsers();

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