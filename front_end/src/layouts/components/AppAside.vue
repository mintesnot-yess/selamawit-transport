<template>

    <div class="flex items-center sidebar_ul gap-3 px-6 py-5 border-b border-surface-200 justify-between">
        <div class="flex flex-row items-center gap-3">
            <div class="w-8 h-8 rounded bg-accent-600 flex items-center justify-center">
                <img src="../../assets/logo_icon.png" class="w-5 saturate-0 invert brightness-100  " alt="">
            </div>
            <span class="font-semibold text-lg text-surface-900 sidebar-text">STAdmin</span>
        </div>

        <button @click="sidebarCollapse"
            class="p-2 rounded-lg text-surface-500 hover:text-surface-700 hover:bg-surface-100 hidden md:flex">
            <img src="../../assets/sidebar-close.svg" class="w-5 opacity-70   " alt="">
        </button>

    </div>

    <nav class="flex-1 overflow-y-auto px-4 py-6 text-sm text-surface-600 scrollbar-hide ">
        <div class="mb-8">
            <p class="text-xs font-medium uppercase mb-3 text-surface-500 tracking-wider sidebar-title">Menu</p>
            <ul class="space-y-2 sidebar-ul  ">
                <li>
                    <router-link active-class="bg-accent-100 text-accent-700 hover:bg-accent-100" to="/"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-surface-100 w-full font-medium text-surface-700 transition-colors">
                        <img class="w-5 h-5 invert" src="../../assets//vector.png" alt="">
                        <span class="sidebar-text">Dashboard</span>
                    </router-link>
                </li>
                <li>
                    <router-link active-class="bg-accent-100 text-accent-700 hover:bg-accent-100" to="/orders"
                        title="orders"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-surface-100  font-medium   transition-colors">
                        <img class="w-5 h-5 invert" src="../../assets//order.png" alt="">
                        <span class="sidebar-text">Orders</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/expense" active-class="bg-accent-100 text-accent-700 hover:bg-accent-100"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors"
                        href="#">
                        <img class="w-5 h-5 invert" src="../../assets//wallet.png" alt="">
                        <span class="sidebar-text">Exposes</span>
                    </router-link>
                </li>
                <li class="relative">
                    <button type="button" @click="toggleSidebar"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <img class="w-5 h-5 invert" src="../../assets//book.png" alt="">
                        <span class="flex-1 text-left rtl:text-right whitespace-nowrap sidebar-text">Reports</span>
                        <i class="fas fa-chevron-right ml-auto text-surface-400 text-xs sidebar-chevron"></i>
                    </button>
                    <ul id="report_dropdown" :class="['py-2 space-y-2', reportDropdownOpen ? '' : 'hidden']">
                        <li>
                            <a href="#"
                                class="flex items-center gap-3 w-full px-7 self-end content-end py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                                <span class=" ">Products</span></a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center gap-3 w-full px-7 self-end content-end py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                                <span class=" ">Billing</span></a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center gap-3 w-full px-7 self-end content-end py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                                <span class=" ">Invoice</span></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <router-link to="/expense_type" active-class="bg-accent-100 text-accent-700 hover:bg-accent-100"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <img class="w-5 h-4 invert" src="../../assets//wallet.png" alt="">
                        <span class="sidebar-text">Expose Type</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/vehicles" active-class="bg-accent-100 text-accent-700 hover:bg-accent-100"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <img class="w-6 invert" src="../../assets/vehicles.png" alt="">
                        <span class="sidebar-text">Vehicles</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/employees" active-class="bg-accent-100 text-accent-700 hover:bg-accent-100"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <img class="w-5 invert" src="../../assets/users.png" alt="">
                        <span class="sidebar-text">Employees</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/location" active-class="bg-accent-100 text-accent-700 hover:bg-accent-100"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <i class="fa fa-location text-xl opacity-70 w-5"></i>
                        <span class="sidebar-text">Location</span>
                    </router-link>
                </li>
                <li>

                    <router-link to="/load_types" active-class="bg-accent-100 text-accent-700 hover:bg-accent-100"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <img class="w-6 invert" src="../../assets/load.png" alt="">
                        <span class="sidebar-text">Load Type</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/banks" active-class="bg-accent-100 text-accent-700 hover:bg-accent-100"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <img class="w-5 invert" src="../../assets/bank.png" alt="">
                        <span class="sidebar-text">Bank</span>
                    </router-link>
                </li>
            </ul>
        </div>
        <div class="mb-8">
            <p class="text-xs font-medium uppercase mb-3 text-surface-500 tracking-wider sidebar-title">
                User Management
            </p>
            <ul class="space-y-2">
                <li>
                    <router-link to="/clients" active-class="bg-accent-100 text-accent-700 hover:bg-accent-100"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <img class="w-5 h-5 invert" src="../../assets/hund.png" alt="">
                        <span class="sidebar-text">Clients</span>
                    </router-link>
                </li>
                <li>
                    <button
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <img class="w-5 invert" src="../../assets/user_lock.png" alt="">
                        <span class="sidebar-text">System User</span>
                    </button>
                </li>
                <li>
                    <router-link to="/logs" active-class="bg-accent-100 text-accent-700 hover:bg-accent-100"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors cursor-pointer">
                        <i class="fa-solid ext-xl opacity-70 w-5 fa-bars-progress"></i>
                        <span class="sidebar-text">Logs</span>
                    </router-link>
                </li>
            </ul>
        </div>
    </nav>



</template>


<script setup>
import { ref } from 'vue';

const isSidebarCollapsed = ref(false);
const reportDropdownOpen = ref(false);

function sidebarCollapse() {
    isSidebarCollapsed.value = !isSidebarCollapsed.value;
    if (isSidebarCollapsed.value) {
        document.body.classList.add('sidebar-collapsed');
    } else {
        document.body.classList.remove('sidebar-collapsed');
    }
}

function toggleSidebar() {
    reportDropdownOpen.value = !reportDropdownOpen.value;
}
</script>

<style scoped>
/* Add this to your styles */
.sidebar-collapsed .sidebar-text,
.sidebar-collapsed .sidebar-title,
.sidebar-collapsed .sidebar-chevron {
    display: none;
}

.sidebar-collapsed .sidebar_ul {
    flex-direction: column;
}


.sidebar-collapsed nav {
    padding-left: 0.5rem;
    padding-right: 0.5rem;

}

nav::-webkit-scrollbar {
    display: none;

}

.sidebar-collapsed .flex.items-center.gap-3 {
    justify-content: center;
}
</style>