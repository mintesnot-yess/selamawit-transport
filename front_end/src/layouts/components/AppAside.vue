<template>
    <!-- Sidebar Toggle Button (Mobile) -->
    <button @click="toggleSidebar"
        class="p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 fixed top-4 left-4 md:hidden z-40 transition-colors"
        aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Overlay (Mobile) -->
    <div v-if="sidebarOpen" @click="toggleSidebar" class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"></div>

    <!-- Sidebar -->
    <aside :class="[
        'fixed md:sticky top-0 left-0 bg-white border-r h-screen flex flex-col z-50 transition-transform duration-300',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0',
        isSidebarCollapsed ? 'w-16' : 'w-64'
    ]">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between px-4 py-4 border-b bg-gray-50">
            <!-- Logo/Icon -->
            <div class="flex items-center gap-2">
                <div class="bg-blue-600 rounded-full w-10 h-10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 13l4-4 4 4m0 0l4-4 4 4M4 17h16" />
                    </svg>
                </div>
                <transition name="fade">
                    <span v-if="!isSidebarCollapsed"
                        class="font-bold text-xl text-gray-800 tracking-tight">STAdmin</span>
                </transition>
            </div>
            <!-- Collapse Button -->
            <button @click="sidebarCollapse"
                class="p-2 rounded-lg text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition hidden md:flex"
                aria-label="Collapse sidebar">
                <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                    <svg v-if="!isSidebarCollapsed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </button>
        </div>

        <!-- Sidebar Navigation -->
        <nav :class="[
            'flex-1 px-4 py-6 text-sm text-gray-600',
            !isSidebarCollapsed ? 'overflow-y-auto' : ''
        ]">
            <div>
                <p v-if="!isSidebarCollapsed" class="text-xs font-medium uppercase mb-3 text-gray-500 tracking-wider">
                    Menu</p>
                <ul class="space-y-2">
                    <li>
                        <router-link to="/" class="sidebar-link">
                            <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                                </svg>
                            </div>
                            <span v-if="!isSidebarCollapsed">Dashboard</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/orders" class="sidebar-link">
                            <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </div>
                            <span v-if="!isSidebarCollapsed">Orders</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/expense" class="sidebar-link">
                            <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3" />
                                </svg>
                            </div>
                            <span v-if="!isSidebarCollapsed">Expenses</span>
                        </router-link>
                    </li>
                    <!-- Reports Dropdown -->
                    <li class="relative">
                        <button @click="toggleReportDropdown" class="sidebar-link w-full"
                            :aria-expanded="reportDropdownOpen">
                            <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                                </svg>
                            </div>
                            <span v-if="!isSidebarCollapsed" class="flex-1 text-left">Reports</span>
                            <i v-if="!isSidebarCollapsed" class="fas fa-chevron-right ml-auto text-xs"
                                :class="{ 'rotate-90': reportDropdownOpen }"></i>
                        </button>
                        <ul v-if="reportDropdownOpen" :class="[
                            'py-2 space-y-2',
                            isSidebarCollapsed ? 'absolute left-full top-0 min-w-[180px] bg-white shadow-lg border rounded-md z-50 ml-2' : 'pl-8',
                        ]">
                            <li>
                                <a href="#" class="sidebar-sublink flex items-center gap-2">
                                    <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                                        </svg>
                                    </div>
                                    <span>Products</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="sidebar-sublink flex items-center gap-2">
                                    <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                                        </svg>
                                    </div>
                                    <span>Billing</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="sidebar-sublink flex items-center gap-2">
                                    <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                                        </svg>
                                    </div>
                                    <span>Billing</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <router-link to="/expense_type" class="sidebar-link">
                            <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            <span v-if="!isSidebarCollapsed">Expense Type</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/vehicles" class="sidebar-link">
                            <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                </svg>
                            </div>
                            <span v-if="!isSidebarCollapsed">Vehicles</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/employees" class="sidebar-link">
                            <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                            </div>
                            <span v-if="!isSidebarCollapsed">Employees</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/location" class="sidebar-link">
                            <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                            </div>
                            <span v-if="!isSidebarCollapsed">Location</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/load_types" class="sidebar-link">
                            <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m7.875 14.25 1.214 1.942a2.25 2.25 0 0 0 1.908 1.058h2.006c.776 0 1.497-.4 1.908-1.058l1.214-1.942M2.41 9h4.636a2.25 2.25 0 0 1 1.872 1.002l.164.246a2.25 2.25 0 0 0 1.872 1.002h2.092a2.25 2.25 0 0 0 1.872-1.002l.164-.246A2.25 2.25 0 0 1 16.954 9h4.636M2.41 9a2.25 2.25 0 0 0-.16.832V12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 12V9.832c0-.287-.055-.57-.16-.832M2.41 9a2.25 2.25 0 0 1 .382-.632l3.285-3.832a2.25 2.25 0 0 1 1.708-.786h8.43c.657 0 1.281.287 1.709.786l3.284 3.832c.163.19.291.404.382.632M4.5 20.25h15A2.25 2.25 0 0 0 21.75 18v-2.625c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125V18a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            </div>
                            <span v-if="!isSidebarCollapsed">Load Type</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/banks" class="sidebar-link">
                            <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                                </svg>
                            </div>
                            <span v-if="!isSidebarCollapsed">Bank</span>
                        </router-link>
                    </li>
                </ul>
            </div>
            <div class="mt-8">
                <p v-if="!isSidebarCollapsed" class="text-xs font-medium uppercase mb-3 text-gray-500 tracking-wider">
                    User Management</p>
                <ul class="space-y-2">
                    <li>
                        <router-link to="/clients" class="sidebar-link">
                            <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </div>
                            <span v-if="!isSidebarCollapsed">Clients</span>
                        </router-link>
                    </li>
                    <li>
                        <button class="sidebar-link w-full">
                            <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-shield-user-icon lucide-shield-user">
                                    <path
                                        d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                                    <path d="M6.376 18.91a6 6 0 0 1 11.249.003" />
                                    <circle cx="12" cy="11" r="4" />
                                </svg>
                            </div>
                            <span v-if="!isSidebarCollapsed">System User</span>
                        </button>
                    </li>
                    <li>
                        <router-link to="/roles" class="sidebar-link ">
                            <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-user-cog-icon lucide-user-cog">
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
                            <span v-if="!isSidebarCollapsed">Roles & Permissions</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/logs" class="sidebar-link ">
                            <div :class="{ 'transform scale-90': isSidebarCollapsed }">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-notebook-text-icon lucide-notebook-text">
                                    <path d="M2 6h4" />
                                    <path d="M2 10h4" />
                                    <path d="M2 14h4" />
                                    <path d="M2 18h4" />
                                    <rect width="16" height="20" x="4" y="2" rx="2" />
                                    <path d="M9.5 8h5" />
                                    <path d="M9.5 12H16" />
                                    <path d="M9.5 16H14" />
                                </svg>
                            </div>
                            <span v-if="!isSidebarCollapsed">Logs</span>
                        </router-link>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>
</template>

<script setup>
import { ref } from 'vue';

const isSidebarCollapsed = ref(false);
const reportDropdownOpen = ref(false);
const sidebarOpen = ref(false);

function toggleSidebar() {
    sidebarOpen.value = !sidebarOpen.value;
}
function sidebarCollapse() {
    isSidebarCollapsed.value = !isSidebarCollapsed.value;
    if (isSidebarCollapsed.value) {
        document.body.classList.add('sidebar-collapsed');
    } else {
        document.body.classList.remove('sidebar-collapsed');
    }
}
function toggleReportDropdown() {
    reportDropdownOpen.value = !reportDropdownOpen.value;
}
</script>

<style scoped>
/* aside scroll bar display none */
nav::-webkit-scrollbar {
    display: none;
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.625rem 1rem;
    border-radius: 0.5rem;
    font-weight: 500;
    color: #374151;
    transition: background 0.2s, color 0.2s;

    svg {

        color: #4b5563;
        padding: 0 10px 0 0;
        scale: 1.5;

    }
}

.sidebar-link:hover,
.router-link-exact-active.sidebar-link {
    background: #f1f5f9;
    color: #2563eb;
    position: relative;


}


.router-link-exact-active {
    &:after {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 1px;
        height: 50%;
        border-radius: 50px;
        background-color: #2563eb;
    }
}

.sidebar-sublink {
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
    color: #374151;
    font-weight: 500;
    transition: background 0.2s;
}

.sidebar-sublink:hover {
    background: #f3f4f6;
}

.rotate-90 {
    transform: rotate(90deg);
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>