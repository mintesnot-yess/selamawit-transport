<template>
    <div @click="toggleSidebar" :class="[
        'fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden  ',
        sidebarOpen ? '' : 'hidden',
    ]" id="sidebar-overlay"></div>
    <aside :class="[
        'fixed md:sticky top-0 w-64 bg-white border-r border-surface-200 h-screen flex flex-col z-50 transition-transform duration-300',
        sidebarOpen
            ? 'translate-x-0'
            : '-translate-x-full md:translate-x-0',
    ]">
        <AppAside />
    </aside>

    <div class="flex-1 flex flex-col">
        <header
            class="sticky top-0 flex items-center justify-between px-4 md:px-6 py-4 border-b border-surface-200 bg-white/80 backdrop-blur-sm z-30">
            <div class="flex items-center gap-3">
                <button @click="toggleSidebar" id="sidebar-toggle"
                    class="p-2 rounded-lg text-surface-500 hover:text-surface-700 hover:bg-surface-100 md:hidden">
                    <i class="fas fa-bars"></i>
                </button>
                <form
                    class="flex items-center border border-surface-300 rounded-lg px-2 py-2 text-surface-500 max-w-md w-full focus-within:ring-2 focus-within:ring-accent-500 focus-within:border-accent-500 transition-all">
                    <i class="fas fa-search mr-2 text-sm"></i>
                    <input
                        class="flex-1 outline-none text-sm text-surface-700 placeholder:text-surface-400 bg-transparent"
                        placeholder="Search or type command..." type="search" />
                    <kbd
                        class="ml-3 px-2 py-1 rounded-md border border-surface-300 text-surface-500 text-xs font-mono font-medium select-none hidden sm:inline-flex">⌘K</kbd>
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
            <!-- Welcome banner -->
            <!-- <div class="bg-gradient-to-r from-accent-600 to-accent-500 rounded-xl p-6 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold">Orders</h1>
                        <p class="text-accent-100 mt-1 text-sm md:text-base">Here's what's happening with your store
                            today.</p>
                    </div>
                    <button
                        class="bg-white/10 hover:bg-white/20 border border-white/20 rounded-lg px-4 py-2 text-sm font-medium transition-colors backdrop-blur-sm self-start md:self-auto">
                        View Analytics
                    </button>
                </div>
            </div>

 -->

            <!-- Recent orders -->
            <div class="bg-white rounded-xl shadow-sm border border-surface-200">
                <div class="px-6 py-4 border-b border-surface-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-surface-900">
                                Banks
                            </h2>
                            <p class="text-sm text-surface-500">
                                Banks Lists and their details
                            </p>
                        </div>
                        <button @click="toggleSideForm"
                            class="toggle_side_form_btn text-sm font-semibold text-white hover:text-white p-2 bg-blue-500 hover:bg-blue-400 rounded-lg flex items-center justify-center text-center gap-2 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md">
                            <i class="fas fa-plus"></i>
                            <span> Add Bank </span>
                        </button>
                    </div>
                </div>

                <OrdersTable />
            </div>


            <!-- Bank List -->
            <div class="flex-1 bg-white rounded-xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-bold text-gray-800 text-xl md:text-2xl leading-tight">
                        Bank List
                    </h2>
                    <div class="relative">
                        <input type="text" v-model="searchQuery" placeholder="Search banks..."
                            class="rounded-xl border border-gray-300/80 px-4 py-2 pl-10 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm">
                        <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <div v-if="loadingBanks" class="flex justify-center py-8">
                    <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-blue-500"></div>
                </div>

                <div v-else-if="filteredBanks.length === 0" class="text-center py-8 text-gray-500">
                    No banks found
                </div>

                <ul v-else class="divide-y divide-gray-200">
                    <li v-for="bank in filteredBanks" :key="bank.id" class="py-4 flex justify-between items-center">
                        <span class="font-medium text-gray-800">{{ bank.name }}</span>
                        <div class="flex space-x-2">
                            <button @click="editBank(bank)" class="text-blue-600 hover:text-blue-800">
                                Edit
                            </button>
                            <button @click="deleteBank(bank.id)" class="text-red-600 hover:text-red-800">
                                Delete
                            </button>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- side form -->

            <div id="side_form_container" class="side-form   " :class="{ hidden: !isSideFormVisible }">
                <div
                    class="fixed z-50 top-0 left-0     bg-slate-700 bg-opacity-50 h-full w-full shadow-2xl border border-gray-10 flex overflow-y-auto">
                    <button aria-label="Close" @click="toggleSideForm"
                        class="toggle_side_form_btn absolute top-0 right-2 text-gey-500 m-5 hover:text-gray-700 rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-100 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div @click="hideSideForm" id="side_form"
                        class="w-0 md:w-full sticky top-0 bg-transparent cursor-pointer">
                    </div>
                    <Forms />
                </div>

            </div>

        </main>
    </div>
    <AppFooter />






    <div class="flex flex-col md:flex-row gap-6">
        <!-- Bank Form -->
        <div id="side_form" class="md:max-w-md p-6 w-full h-full bg-white rounded-xl">
            <div class="flex justify-between items-center mb-3">
                <h2 class="font-bold text-gray-800 text-xl md:text-2xl leading-tight">
                    {{ editingBank ? 'Edit Bank' : 'Add New Bank' }}
                </h2>
                <button v-if="editingBank" @click="cancelEdit" class="text-sm text-gray-500 hover:text-gray-700">
                    Cancel
                </button>
            </div>

            <form @submit.prevent="handleSubmit" class="flex flex-col space-y-6">
                <div>
                    <label for="bankName" class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">
                        Bank Name
                    </label>
                    <input id="bankName" type="text" v-model="form.name"
                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                        placeholder="Enter bank name" required />
                </div>

                <div v-if="error" class="text-red-500 text-sm">
                    {{ error }}
                </div>

                <button type="submit" :disabled="loading"
                    class="mt-6 w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                    <span v-if="!loading">{{ editingBank ? 'UPDATE BANK' : 'SAVE BANK' }}</span>
                    <span v-else>Processing...</span>
                </button>
            </form>
        </div>

        <!-- Bank List -->
        <div class="flex-1 bg-white rounded-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-bold text-gray-800 text-xl md:text-2xl leading-tight">
                    Bank List
                </h2>
                <div class="relative">
                    <input type="text" v-model="searchQuery" placeholder="Search banks..."
                        class="rounded-xl border border-gray-300/80 px-4 py-2 pl-10 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm">
                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <div v-if="loadingBanks" class="flex justify-center py-8">
                <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-blue-500"></div>
            </div>

            <div v-else-if="filteredBanks.length === 0" class="text-center py-8 text-gray-500">
                No banks found
            </div>

            <ul v-else class="divide-y divide-gray-200">
                <li v-for="bank in filteredBanks" :key="bank.id" class="py-4 flex justify-between items-center">
                    <span class="font-medium text-gray-800">{{ bank.name }}</span>
                    <div class="flex space-x-2">
                        <button @click="editBank(bank)" class="text-blue-600 hover:text-blue-800">
                            Edit
                        </button>
                        <button @click="deleteBank(bank.id)" class="text-red-600 hover:text-red-800">
                            Delete
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>

import bankService from '@/services/banks';
import { debounce } from 'lodash';

import { ref } from "vue";
import AppAside from "../components/AppAside.vue";
import OrdersTable from "./components/Tables.vue";
import Forms from "./components/Forms.vue";

const isSideFormVisible = ref(false);
import UserDropdown from "../components/UserDropdown.vue";

const toggleSideForm = () => {
    isSideFormVisible.value = !isSideFormVisible.value;
};
//   Hide function
const hideSideForm = () => {
    isSideFormVisible.value = false;
};

const sidebarOpen = ref(false);

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};
</script>
