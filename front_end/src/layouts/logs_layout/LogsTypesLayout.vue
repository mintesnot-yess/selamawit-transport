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
                <form @input.prevent="searchLogs(searchQuery)"
                    class="flex items-center border border-surface-300 rounded-lg px-2 py-2 text-surface-500 max-w-md w-full focus-within:ring-2 focus-within:ring-accent-500 focus-within:border-accent-500 transition-all">
                    <i class="fas fa-search mr-2 text-sm"></i>
                    <input v-model="searchQuery" @input="handleSearchInput"
                        class="flex-1 outline-none text-sm text-surface-700 placeholder:text-surface-400 bg-transparent"
                        placeholder="Search logs..." type="search" />
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
            <!-- Logs Table -->
            <div class="bg-white rounded-xl shadow-sm border border-surface-200">
                <div class="px-6 py-4 border-b border-surface-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-surface-900">Logs</h2>
                            <p class="text-sm text-surface-500">
                                <template v-if="isSearching">Searching...</template>
                                <template v-else-if="searchError" class="text-red-500">{{ searchError }}</template>
                                <template v-else>
                                    Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} logs
                                </template>
                            </p>
                        </div>
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
                                    User
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Action
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    IP Address
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Timestamp
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-surface-200">
                            <template v-if="loadingLogs">
                                <tr v-for="i in 5" :key="`skeleton-${i}`">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-4 bg-surface-200 rounded w-1/2 animate-pulse"></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-4 bg-surface-200 rounded w-24 animate-pulse"></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-4 bg-surface-200 rounded w-32 animate-pulse"></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-4 bg-surface-200 rounded w-16 animate-pulse"></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-4 bg-surface-200 rounded w-20 animate-pulse"></div>
                                    </td>
                                </tr>
                            </template>

                            <template v-else>
                                <tr v-for="(log, idx) in logs" :key="log.id" class="hover:bg-surface-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-surface-900">
                                        {{ (pagination.from - 1) + (idx + 1) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-700">
                                        {{ log.user && log.user.name ? log.user.name : 'Unknown' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">
                                        {{ log.action }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">
                                        {{ log.ip_address }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">
                                        {{ log.timestamp ? new Date(log.timestamp).toLocaleString() : '' }}
                                    </td>
                                </tr>
                                <tr v-if="logs.length === 0 && !loadingLogs">
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-surface-500">
                                        No logs found
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    <!-- Pagination -->
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
        </main>
    </div>
</template>

<script>
import LogsService from '@/services/logs';
import AppAside from "../components/AppAside.vue";
import UserDropdown from "../components/UserDropdown.vue";
import { debounce } from 'lodash';
export default {
    components: {
        AppAside,
        UserDropdown
    },
    data() {
        return {
            logs: [],
            loadingLogs: false,
            searchQuery: '',
            isSearching: false,
            searchError: null,
            sidebarOpen: false,
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
        await this.fetchLogs();
    },
    methods: {
        async fetchLogs(page = 1) {
            this.loadingLogs = true;
            try {
                const response = await LogsService.getAll({
                    page: page,
                    per_page: this.pagination.per_page,  // Changed from perPage to per_page
                    search: this.searchQuery
                });

                this.logs = response.data;

                // Ensure we have the correct pagination meta data
                if (response.meta) {
                    this.updatePagination(response.meta);
                } else if (response.pagination) {  // Some APIs use 'pagination' instead of 'meta'
                    this.updatePagination(response.pagination);
                } else {
                    console.warn('API response missing pagination data, using fallback');
                    this.updatePagination({
                        current_page: page,
                        per_page: this.pagination.per_page,
                        total: response.data.length,
                        last_page: Math.ceil(response.data.length / this.pagination.per_page),
                        from: ((page - 1) * this.pagination.per_page) + 1,
                        to: Math.min(page * this.pagination.per_page, response.data.length)
                    });
                }

            } catch (error) {
                console.error('Error fetching logs:', error);
                this.$toast.error("Failed to load logs: " + error.message);
            } finally {
                this.loadingLogs = false;
            }
        },

        updatePagination(meta) {
            this.pagination = {
                current_page: meta.current_page || 1,
                per_page: meta.per_page || this.pagination.per_page,
                total: meta.total || 0,
                last_page: meta.last_page || Math.ceil((meta.total || 0) / (meta.per_page || this.pagination.per_page)) || 1,
                from: meta.from || ((meta.current_page - 1) * meta.per_page) + 1 || 1,
                to: meta.to || Math.min(meta.current_page * meta.per_page, meta.total) || meta.per_page || this.pagination.per_page
            };
        },

        async searchLogs() {
            if (!this.searchQuery.trim()) {
                this.clearSearch();
                return;
            }

            this.isSearching = true;
            this.searchError = null;

            try {
                const response = await LogsService.search({
                    query: this.searchQuery,
                    page: this.pagination.current_page,
                    per_page: this.pagination.per_page  // Changed from perPage to per_page
                });

                this.logs = response.data || [];
                this.updatePagination(response.meta || response.pagination || {});

            } catch (error) {
                console.error('Search error:', error);
                this.searchError = typeof error === 'string' ? error : error.message;
                this.logs = [];
                this.$toast.error(`Search failed: ${this.searchError}`);
            } finally {
                this.isSearching = false;
            }
        },

        handleSearchInput: debounce(function () {
            if (this.searchQuery.trim().length >= 3) {
                this.searchLogs();
            } else if (!this.searchQuery.trim()) {
                this.clearSearch();
            }
        }, 500),

        clearSearch() {
            this.searchQuery = '';
            this.searchError = null;
            this.fetchLogs();
        },

        async nextPage() {
            if (this.pagination.current_page < this.pagination.last_page) {
                this.pagination.current_page++;
                await this.fetchLogs(this.pagination.current_page);
            }
        },

        async prevPage() {
            if (this.pagination.current_page > 1) {
                this.pagination.current_page--;
                await this.fetchLogs(this.pagination.current_page);
            }
        },

        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        }
    }
};
</script>

<style scoped>
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