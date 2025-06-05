<template>
    <div @click="toggleSidebar" :class="[
        'fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden  ',
        sidebarOpen ? '' : 'hidden',
    ]" id="sidebar-overlay"></div>
    <aside :class="[
        'fixed md:sticky top-0 w-fit bg-white border-r border-surface-200 h-screen flex flex-col z-50 transition-transform duration-300',
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

            <!-- Order Form Sidebar -->
            <div id="side_form_container" class="side-form" :class="{ hidden: !isSideFormVisible }">
                <div
                    class="fixed z-50 top-0 left-0 bg-zinc-900 bg-opacity-50 h-full w-full shadow-2xl border border-gray-10 flex overflow-y-auto">
                    <button aria-label="Close" @click="toggleAddOrderForm"
                        class="toggle_side_form_btn absolute top-0 right-2 text-gey-500 m-5 hover:text-gray-700 rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-100 transition-colors duration-200">
                        <i class="fa fa-xmark"></i>
                    </button>
                    <div @click="toggleAddOrderForm" id="side_form"
                        class="w-0 md:w-full sticky top-0 bg-transparent cursor-pointer"></div>
                    <div id="side_form" class="md:max-w-md p-6 w-full h-full bg-white rounded-xl">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="font-bold text-gray-800 text-xl md:text-2xl leading-tight">
                                Orders
                            </h2>
                        </div>
                        <p class="text-sm text-indigo-600 mb-6 leading-relaxed font-medium">
                            {{ isUpdating ? 'Update Order Information' : 'Add Order Information' }}
                        </p>
                        <form @submit.prevent="isUpdating ? handleSubmitUpdate() : handleSubmitAdd()"
                            class="flex flex-col space-y-6 font-['Inter']">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Client</label>
                                <input v-model="form.client" type="text"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3"
                                    placeholder="Client name" />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Driver</label>
                                <input v-model="form.driver" type="text"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3"
                                    placeholder="Driver name" />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Vehicle</label>
                                <input v-model="form.vehicle" type="text"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3"
                                    placeholder="Vehicle" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Load
                                    Type</label>
                                <input v-model="form.load_type" type="text"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3"
                                    placeholder="Load Type" />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Destination</label>
                                <input v-model="form.destination" type="text"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3"
                                    placeholder="Destination" />
                            </div>
                            <div v-if="error" class="text-red-500 text-sm ">
                                {{ error }}
                            </div>
                            <button :disabled="loading" type="submit"
                                class="mt-6 w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md hover:shadow-lg">
                                <span v-if="!loading">{{ isUpdating ? 'Update' : 'SAVE' }}</span>
                                <span v-else>Processing...</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </main>
    </div>
    <AppFooter />
</template>

<script setup>
import { ref } from "vue";
import AppAside from "../components/AppAside.vue";
import OrdersTable from "./components/Tables.vue";
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
