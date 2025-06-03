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
                                Orders
                            </h2>
                            <p class="text-sm text-surface-500">
                                Latest transactions from your store
                            </p>
                        </div>
                        <button @click="toggleSideForm"
                            class="toggle_side_form_btn text-sm font-semibold text-white hover:text-white p-2 bg-blue-500 hover:bg-blue-400 rounded-lg flex items-center justify-center text-center gap-2 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md">
                            <i class="fas fa-plus"></i>
                            <span> Add Orders </span>
                        </button>
                    </div>
                </div>

                <OrdersTable />
            </div>

            <!-- side form -->

            <div id="side_form_container" class="side-form" :class="{ hidden: !isSideFormVisible }">
                <div
                    class="fixed z-50 -top-0.5 left-0 bg-slate-700 bg-opacity-50 h-full w-full shadow-2xl border border-gray-10 flex overflow-y-auto">
                    <button aria-label="Close" @click="toggleSideForm"
                        class="toggle_side_form_btn absolute top-0 right-2 text-gey-500 m-5 hover:text-gray-700 rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-100 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div @click="hideSideForm" id="side_form"
                        class="w-0 md:w-full sticky top-0 bg-transparent cursor-pointer"></div>
                    <div id="side_form" class="md:max-w-md p-6 w-full h-fit bg-white rounded-xl">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="font-bold text-gray-800 text-xl md:text-2xl leading-tight">
                                Orders
                            </h2>
                        </div>
                        <p class="text-sm text-indigo-600 mb-6 leading-relaxed font-medium">
                            Fill Order Information
                        </p>
                        <form class="flex flex-col space-y-6 font-['Inter']">
                            <div>
                                <label for="siteType"
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">
                                    Client</label>
                                <select id="siteType"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm appearance-none bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM2NjciIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS1jaGV2cm9uLWRvd24iPjxwYXRoIGQ9Im03IDE1IDUgNSA1LTUiLz48L3N2Zz4=')] bg-no-repeat bg-[right_1rem_center] bg-[length:1.25em]">
                                    <option value="" disabled selected>
                                        Select Client
                                    </option>
                                    <option value="residential">
                                        Residential
                                    </option>
                                    <option value="commercial">
                                        Commercial
                                    </option>
                                    <option value="industrial">
                                        Industrial
                                    </option>
                                    <option value="mixed-use">Mixed-Use</option>
                                </select>
                            </div>
                            <div>
                                <label for="siteType"
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">
                                    Driver</label>
                                <select id="siteType"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm appearance-none bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM2NjciIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS1jaGV2cm9uLWRvd24iPjxwYXRoIGQ9Im03IDE1IDUgNSA1LTUiLz48L3N2Zz4=')] bg-no-repeat bg-[right_1rem_center] bg-[length:1.25em]">
                                    <option value="" disabled selected>
                                        Select Driver
                                    </option>
                                    <option value="residential">
                                        Residential
                                    </option>
                                    <option value="commercial">
                                        Commercial
                                    </option>
                                    <option value="industrial">
                                        Industrial
                                    </option>
                                    <option value="mixed-use">Mixed-Use</option>
                                </select>
                            </div>
                            <div>
                                <label for="siteType"
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">
                                    Vehicle</label>
                                <select id="siteType"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm appearance-none bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM2NjciIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS1jaGV2cm9uLWRvd24iPjxwYXRoIGQ9Im03IDE1IDUgNSA1LTUiLz48L3N2Zz4=')] bg-no-repeat bg-[right_1rem_center] bg-[length:1.25em]">
                                    <option value="" disabled selected>
                                        Select Vehicle
                                    </option>
                                    <option value="residential">
                                        Residential
                                    </option>
                                    <option value="commercial">
                                        Commercial
                                    </option>
                                    <option value="industrial">
                                        Industrial
                                    </option>
                                    <option value="mixed-use">Mixed-Use</option>
                                </select>
                            </div>
                            <div>
                                <label for="siteType"
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">
                                    Load Type
                                </label>
                                <select id="siteType"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm appearance-none bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM2NjciIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS1jaGV2cm9uLWRvd24iPjxwYXRoIGQ9Im03IDE1IDUgNSA1LTUiLz48L3N2Zz4=')] bg-no-repeat bg-[right_1rem_center] bg-[length:1.25em]">
                                    <option value="" disabled selected>
                                        Select Load Type
                                    </option>
                                    <option value="residential">
                                        Residential
                                    </option>
                                    <option value="commercial">
                                        Commercial
                                    </option>
                                    <option value="industrial">
                                        Industrial
                                    </option>
                                    <option value="mixed-use">Mixed-Use</option>
                                </select>
                            </div>
                            <div>
                                <label for="siteType"
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">
                                    Loading Place</label>
                                <select id="siteType"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm appearance-none bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM2NjciIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS1jaGV2cm9uLWRvd24iPjxwYXRoIGQ9Im03IDE1IDUgNSA1LTUiLz48L3N2Zz4=')] bg-no-repeat bg-[right_1rem_center] bg-[length:1.25em]">
                                    <option value="" disabled selected>
                                        Select Loading Place
                                    </option>
                                    <option value="residential">
                                        Residential
                                    </option>
                                    <option value="commercial">
                                        Commercial
                                    </option>
                                    <option value="industrial">
                                        Industrial
                                    </option>
                                    <option value="mixed-use">Mixed-Use</option>
                                </select>
                            </div>
                            <div>
                                <label for="siteType"
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">
                                    Destination</label>
                                <select id="siteType"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm appearance-none bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM2NjciIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS1jaGV2cm9uLWRvd24iPjxwYXRoIGQ9Im03IDE1IDUgNSA1LTUiLz48L3N2Zz4=')] bg-no-repeat bg-[right_1rem_center] bg-[length:1.25em]">
                                    <option value="" disabled selected>
                                        Select Destination
                                    </option>
                                    <option value="residential">
                                        Residential
                                    </option>
                                    <option value="commercial">
                                        Commercial
                                    </option>
                                    <option value="industrial">
                                        Industrial
                                    </option>
                                    <option value="mixed-use">Mixed-Use</option>
                                </select>
                            </div>
                            <div>
                                <label for="siteQuintal"
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Quintal</label>
                                <input id="siteQuintal" type="number"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                    placeholder="Enter site name" />
                            </div>

                            <div class="space-y-3">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="latitude"
                                            class="block text-xs font-medium text-gray-600 mb-2 tracking-wider">Sub
                                            Tarrif</label>
                                        <input id="latitude" type="number"
                                            class="w-full rounded-xl border border-gray-300/80 px-4 py-2.5 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 bg-white/95 shadow-sm"
                                            placeholder="Sub Tarrif" />
                                    </div>
                                    <div>
                                        <label for="longitude"
                                            class="block text-xs font-medium text-gray-600 mb-2 tracking-wider">Given
                                            Tarrif</label>
                                        <input id="longitude" type="number"
                                            class="w-full rounded-xl border border-gray-300/80 px-4 py-2.5 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 bg-white/95 shadow-sm"
                                            placeholder="Given Tarrif" />
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="longitude"
                                            class="block text-xs font-medium text-gray-600 mb-2 tracking-wider">Loading
                                            Date</label>
                                        <input id="longitude" type="date"
                                            class="w-full rounded-xl border border-gray-300/80 px-4 py-2.5 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 bg-white/95 shadow-sm"
                                            placeholder="Loading Date" />
                                    </div>
                                    <div>
                                        <label for="latitude"
                                            class="block text-xs font-medium text-gray-600 mb-2 tracking-wider">Arrival
                                            Date</label>
                                        <input id="latitude" type="date"
                                            class="w-full rounded-xl border border-gray-300/80 px-4 py-2.5 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 bg-white/95 shadow-sm"
                                            placeholder="Sub Tarrif" />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="siteType"
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">
                                    Condition</label>
                                <select id="siteType"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm appearance-none bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM2NjciIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS1jaGV2cm9uLWRvd24iPjxwYXRoIGQ9Im03IDE1IDUgNSA1LTUiLz48L3N2Zz4=')] bg-no-repeat bg-[right_1rem_center] bg-[length:1.25em]">
                                    <option value="" disabled selected>
                                        Select Loading Place
                                    </option>
                                    <option value="residential">
                                        Residential
                                    </option>
                                    <option value="commercial">
                                        Commercial
                                    </option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="mt-6 w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md hover:shadow-lg">
                                SAVE CHANGES
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
