<template>

    <div class="flex-1 flex flex-col">
        <!-- Header with search -->
        <header
            class="sticky top-0 flex items-center justify-between px-4 md:px-6 py-4 border-b border-surface-200 bg-white/80 backdrop-blur-sm z-30">
            <span></span>

            <div class="flex items-center gap-3">

                <form @input.prevent="searchVehicles(searchQuery)"
                    class="flex items-center border border-surface-300 rounded-lg px-2 py-2 text-surface-500 max-w-md w-full focus-within:ring-2 focus-within:ring-accent-500 focus-within:border-accent-500 transition-all">
                    <i class="fas fa-search mr-2 text-sm"></i>
                    <input v-model="searchQuery" @input="handleSearchInput"
                        class="flex-1 outline-none text-sm text-surface-700 placeholder:text-surface-400 bg-transparent"
                        placeholder="Search vehicles..." type="search" />
                    <button v-if="searchQuery" @click="clearSearch" type="button"
                        class="ml-2 text-surface-400 hover:text-surface-600">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
            </div>

            <UserDropdown />

        </header>

        <main class="p-4 md:p-6 space-y-6">
            <!-- vehicles Table -->
            <div class="bg-white rounded-xl shadow-sm border border-surface-200">
                <div class="px-6 py-4 border-b border-surface-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-surface-900">Vehicles</h2>
                            <p class="text-sm text-surface-500">
                                <template v-if="isSearching">Searchfuncing...</template>
                                <template v-else-if="searchError" class="text-red-500">{{ searchError }}</template>
                                <!-- <template v-else>
                                    Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }}
                                    vehicle
                                </template> -->
                            </p>
                            <!-- Filterable Buttons -->
                            <div class="flex gap-2 mt-2">
                                <button :class="[
                                    'px-3 py-1 rounded-md text-xs font-semibold border transition-colors',
                                    !filterType ? 'bg-blue-500 text-white border-blue-500' : 'bg-white text-surface-700 border-surface-300 hover:bg-blue-50'
                                ]" @click="filterType = ''; fetchVehicles(1)">
                                    All
                                </button>
                                <button :class="[
                                    'px-3 py-1 rounded-md text-xs font-semibold border transition-colors',
                                    filterType === 'OWNED' ? 'bg-blue-500 text-white border-blue-500' : 'bg-white text-surface-700 border-surface-300 hover:bg-blue-50'
                                ]" @click="filterType = 'OWNED'; fetchVehicles(1)">
                                    Owned
                                </button>
                                <button :class="[
                                    'px-3 py-1 rounded-md text-xs font-semibold border transition-colors',
                                    filterType === 'PRIVATE' ? 'bg-blue-500 text-white border-blue-500' : 'bg-white text-surface-700 border-surface-300 hover:bg-blue-50'
                                ]" @click="filterType = 'PRIVATE'; fetchVehicles(1)">
                                    Private
                                </button>
                            </div>
                        </div>
                        <button @click="openAddVehicleForm"
                            class="text-sm font-semibold text-white hover:text-white p-2 bg-blue-500 hover:bg-blue-400 rounded-lg flex items-center justify-center text-center gap-2 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md">
                            <i class="fas fa-plus"></i>
                            <span>Add vehicle</span>
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
                                    Plate Number
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Vehicle Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Own Type
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Own Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Own Phone
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    libre
                                </th>

                                <th scope="col" class="relative px-6 py-3">
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-surface-200 w-full">

                            <template v-if="loadingVehicles">
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
                                <tr v-for="vehicle in vehicles" :key="vehicle.id" class="hover:bg-surface-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-surface-900">
                                        {{ (pagination.from - 1) + (vehicles.indexOf(vehicle) + 1) }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">

                                            <!-- <div
                                                class="flex-shrink-0 h-8 w-8 bg-blue-400 rounded-full flex items-center justify-center">
                                                <img class="h-7 w-7 object-contain rounded-full "
                                                    src="@/assets/vehicles.png" :alt="">
                                            </div> -->

                                            <div class="ml-4">
                                                <router-link :to="`/vehicle/${vehicle.id}`"
                                                    class="text-sm font-medium text-surface-900 hover:underline">{{
                                                        vehicle.plate_number
                                                    }}</router-link>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500"
                                        data-v-inspector="src/layouts/orders/components/Tables.vue:53:21"> {{
                                            vehicle.vehicle_name
                                        }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500"
                                        data-v-inspector="src/layouts/orders/components/Tables.vue:53:21"> {{
                                            vehicle.owner_type
                                        }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500"
                                        data-v-inspector="src/layouts/orders/components/Tables.vue:53:21"> {{
                                            vehicle.owner_name
                                        }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500"
                                        data-v-inspector="src/layouts/orders/components/Tables.vue:53:21"> {{
                                            vehicle.owner_phone
                                        }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">
                                        <template v-if="vehicle.libre">
                                            <img :src="`http://127.0.0.1:8000/storage/${vehicle.libre}`" alt="Libre"
                                                class="h-10 w-10 object-cover rounded"
                                                style="max-width: 60px; max-height: 60px;" />
                                        </template>
                                        <template v-else>
                                            <span class="text-surface-400 italic">No image</span>
                                        </template>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <!-- <ToggleMenu @show="() => $router.push(`/vehicle/${vehicle.id}`)"
                                            @edit="editVehicle(vehicle)"
                                            @delete="confirmDelete(vehicle.id, vehicle.name)" /> -->

                                        <ToggleMenu @show="() => $router.push(`/vehicle/${vehicle.id}`)" :item="vehicle"
                                            @edit="editVehicle" @delete="confirmDelete" />
                                    </td>
                                </tr>

                                <tr v-if="vehicles.length === 0 && !loadingVehicles">
                                    <td colspan="10"
                                        class="px-4 py-8 text-center text-surface-400 text-base font-medium">
                                        <i class="fas fa-truck text-2xl mb-2 block"></i>
                                        No vehicles found
                                    </td>
                                </tr>
                            </template>




                        </tbody>

                        <!-- With this version -->

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

            <!-- vehicle Form Sidebar -->
            <div id="side_form_container" class="side-form" :class="{ hidden: !isSideFormVisible }">
                <div
                    class="fixed z-50 top-0 left-0 bg-zinc-900 bg-opacity-50 h-full w-full shadow-2xl border border-gray-10 flex overflow-y-auto">
                    <button aria-label="Close" @click="toggleAddVehicleForm"
                        class="toggle_side_form_btn absolute top-0 right-2 text-gey-500 m-5 hover:text-gray-700 rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-100 transition-colors duration-200">
                        <i class="fa fa-xmark"></i>
                    </button>
                    <div @click="toggleAddVehicleForm" id="side_form"
                        class="w-0 md:w-full sticky top-0 bg-transparent cursor-pointer">
                    </div>
                    <div id="side_form" class="md:max-w-md p-6 w-full h-full bg-white rounded-xl">


                        <template v-if="isUpdating">
                            <div class="flex justify-between items-center mb-3">
                                <h2 class="font-bold text-gray-800 text-xl md:text-2xl leading-tight">
                                    Update Vehicle
                                </h2>
                            </div>
                            <p class="text-sm text-indigo-600 mb-6 leading-relaxed font-medium">
                                Update vehicle information
                            </p>

                            <form @submit.prevent="handleSubmitUpdate" class="space-y-6 font-['Inter']">
                                <div>
                                    <label for="vehicle_name" class="block text-sm font-medium text-gray-800 mb-1">
                                        Vehicle Name
                                    </label>
                                    <input v-model="form.vehicle_name" id="vehicle_name" type="text"
                                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                        placeholder="Enter vehicle name" />
                                </div>
                                <div>
                                    <label for="plate_number" class="block text-sm font-medium text-gray-800 mb-1">
                                        Plate Number
                                    </label>
                                    <input v-model="form.plate_number" id="plate_number" type="text"
                                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                        placeholder="Enter plate number" />
                                </div>
                                <div>
                                    <label for="owner_name" class="block text-sm font-medium text-gray-800 mb-1">
                                        Owner Name
                                    </label>
                                    <input v-model="form.owner_name" id="owner_name" type="text"
                                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                        placeholder="Enter owner name" />
                                </div>
                                <div>
                                    <label for="owner_phone" class="block text-sm font-medium text-gray-800 mb-1">
                                        Owner Phone
                                    </label>
                                    <input v-model="form.owner_phone" id="owner_phone" type="text"
                                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                        placeholder="Enter owner phone" />
                                </div>
                                <div>
                                    <label for="owner_type" class="block text-sm font-medium text-gray-800 mb-1">
                                        Owner Type
                                    </label>
                                    <div class="relative">
                                        <select v-model="form.owner_type" id="owner_type"
                                            class="w-full appearance-none rounded-xl border border-gray-300/80 px-4 py-3 pr-10 text-gray-900 bg-white/95 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200">
                                            <option value="">Select type</option>
                                            <option value="OWNED">OWNED</option>
                                            <option value="PRIVATE">PRIVATE</option>
                                        </select>
                                        <span
                                            class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <label for="libre_input" class="block text-sm font-medium text-gray-800 mb-1">
                                        Libre
                                    </label>
                                    <div class="relative flex items-center">
                                        <input id="libre_input" type="file" class="sr-only"
                                            @change="form.libre = $event.target.files[0]" />
                                        <label for="libre_input"
                                            class="flex items-center justify-center w-full px-4 py-2 bg-white border border-gray-300/80 rounded-xl shadow-sm cursor-pointer hover:bg-blue-50 transition-all duration-200 text-gray-700">
                                            <i class="fas fa-upload mr-2 text-blue-500"></i>
                                            <span>
                                                {{ form.libre && form.libre.name ? form.libre.name : 'Choose file...' }}
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div v-if="success" class="text-blue-600 text-sm">
                                    {{ success }}
                                </div>
                                <div v-else-if="error" class="text-red-500 text-sm">
                                    {{ error }}
                                </div>
                                <button :disabled="loading" type="submit"
                                    class="mt-2 w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md hover:shadow-lg disabled:opacity-60 disabled:cursor-not-allowed">
                                    <span v-if="!loading">Update</span>
                                    <span v-else>Processing...</span>
                                </button>
                            </form>

                        </template>

                        <template v-else>
                            <div class="flex justify-between items-center mb-3">
                                <h2 class="font-bold text-gray-800 text-xl md:text-2xl leading-tight">
                                    Vehicles
                                </h2>
                            </div>
                            <p class="text-sm text-indigo-600 mb-6 leading-relaxed font-medium">
                                Fill vehicle Information
                            </p>

                            <form @submit.prevent="handleSubmitAdd" enctype="multipart/form-data"
                                class="space-y-6 font-['Inter']">
                                <div>
                                    <label for="vehicle_name" class="block text-sm font-medium text-gray-800 mb-1">
                                        Vehicle Name
                                    </label>
                                    <input v-model="form.vehicle_name" id="vehicle_name" type="text"
                                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                        placeholder="Enter vehicle name" />
                                </div>
                                <div>
                                    <label for="vehicle_number" class="block text-sm font-medium text-gray-800 mb-1">
                                        Plate Number
                                    </label>
                                    <input v-model="form.plate_number" id="vehicle_number" type="text"
                                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                        placeholder="Enter plate number" />
                                </div>
                                <div>
                                    <label for="owner_name" class="block text-sm font-medium text-gray-800 mb-1">
                                        Owner Name
                                    </label>
                                    <input v-model="form.owner_name" id="owner_name" type="text"
                                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                        placeholder="Enter owner name" />
                                </div>
                                <div>
                                    <label for="owner_phone" class="block text-sm font-medium text-gray-800 mb-1">
                                        Owner Phone
                                    </label>
                                    <input v-model="form.owner_phone" id="owner_phone" type="text"
                                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                        placeholder="Enter owner phone" />
                                </div>
                                <div>
                                    <label for="owner_type" class="block text-sm font-medium text-gray-800 mb-1">
                                        Owner Type
                                    </label>
                                    <div class="relative">
                                        <select v-model="form.owner_type" id="owner_type"
                                            class="w-full appearance-none rounded-xl border border-gray-300/80 px-4 py-3 pr-10 text-gray-900 bg-white/95 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200">
                                            <option value="" disabled>Select type</option>
                                            <option value="OWNED">OWNED</option>
                                            <option value="PRIVATE">PRIVATE</option>
                                        </select>
                                        <span
                                            class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <label for="libre_input" class="block text-sm font-medium text-gray-800 mb-1">
                                        Libre
                                    </label>
                                    <div class="relative flex items-center">
                                        <input id="libre_input" type="file" class="sr-only"
                                            @change="form.libre = $event.target.files[0]" />
                                        <label for="libre_input"
                                            class="flex items-center justify-center w-full px-4 py-2 bg-white border border-gray-300/80 rounded-xl shadow-sm cursor-pointer hover:bg-blue-50 transition-all duration-200 text-gray-700">
                                            <i class="fas fa-upload mr-2 text-blue-500"></i>
                                            <span>
                                                {{ form.libre ? form.libre.name : 'Choose file...' }}
                                            </span>
                                        </label>

                                    </div>
                                </div>
                                <div v-if="error" class="text-red-500 text-sm">
                                    {{ error }}
                                </div>
                                <button :disabled="loading" type="submit"
                                    class="mt-2 w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md hover:shadow-lg disabled:opacity-60 disabled:cursor-not-allowed">
                                    <span v-if="!loading">SAVE</span>
                                    <span v-else>Processing...</span>
                                </button>
                            </form>
                        </template>

                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import vehicleService from '@/services/vehicle';
import AppAside from "../components/AppAside.vue";
import UserDropdown from "../components/UserDropdown.vue";
// import Forms from "./components/Forms.vue";
import ToggleMenu from "@/layouts/components/ToggleMenu.vue";
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
                id: "",
                plate_number: "",
                vehicle_name: "",
                vehicle_number: "",
                owner_name: "",
                owner_phone: "",
                owner_type: "",
                libre: "",
                active: true,
                isMenuOpen: false,

            },
            vehicles: [],
            loading: false,
            loadingVehicles: false,
            error: null,
            success: null,
            editingVehicle: null,
            searchQuery: '',
            filterType: '',
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
        await this.fetchVehicles();
    },
    methods: {
        async fetchVehicles(page = 1) {
            this.loadingVehicles = true;
            try {
                const params = {
                    page: page,
                    perPage: this.pagination.per_page,
                    search: this.searchQuery
                };
                // Add filterType if set
                if (this.filterType) {
                    params.owner_type = this.filterType;
                }

                const response = await vehicleService.getAll(params);

                // Standardized response handling
                this.vehicles = response.data;

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
                console.error('Error fetching vehicles:', error);
                this.$toast.error("Failed to load vehicles: " + error.message);
            } finally {
                this.loadingVehicles = false;
            }
        },

        async handleSubmitAdd() {

            this.loading = true;
            this.error = null;
            // If editingVehicle is set, update the vehicle, else create new

            try {
                const response = await vehicleService.store(this.form);
                await this.fetchVehicles();
                this.$router.push('vehicles');


                this.form.name = "";
                this.isSideFormVisible = false;


            } catch (error) {
                this.error = error.response?.data?.message || error.message || "Failed to save vehicle information";
                console.error("vehicle save error:", error);
            } finally {
                this.loading = false;
            }
        },

        editVehicle(vehicle) {
            this.isUpdating = true;
            this.form = {
                id: vehicle.id,
                plate_number: vehicle.plate_number || "",
                vehicle_name: vehicle.vehicle_name || "",
                owner_name: vehicle.owner_name || "",
                owner_phone: vehicle.owner_phone || "",
                owner_type: vehicle.owner_type || "",
                libre: vehicle.libre || "",
                // active: vehicle.active !== undefined ? vehicle.active : true,

            };
            this.isSideFormVisible = true;

        },
        async handleSubmitUpdate() {

            this.loading = true;
            this.error = null;
            this.success = null;
            // If editingVehicle is set, update the vehicle, else create new

            try {
                const response = await vehicleService.update(this.form.id, this.form);
                await this.fetchVehicles();
                this.success = "vehicle updated successfully"




            } catch (error) {
                this.error = error.response?.data?.message || error.message || "Failed to save vehicle information";
                console.error("vehicle save error:", error);
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
        async searchVehicles() {
            if (!this.searchQuery.trim()) {
                this.clearSearch();
                return;
            }

            this.isSearching = true;
            this.searchError = null;

            try {
                const response = await vehicleService.search({
                    query: this.searchQuery,
                    page: this.pagination.current_page,
                    perPage: this.pagination.per_page
                });

                if (response.success) {
                    this.vehicles = response.data;
                    this.updatePagination(response.meta);
                } else {
                    throw new Error(response.message || 'Invalid response');
                }
            } catch (error) {
                console.error('Search error:', error);
                this.searchError = typeof error === 'string' ? error : error.message;
                this.vehicles = [];
                this.$toast.error(`Search failed: ${this.searchError}`);
            } finally {
                this.isSearching = false;
            }
        },

        // Debounced search input handler
        handleSearchInput: debounce(function () {
            if (this.searchQuery.trim().length >= 3) {
                this.searchVehicles();
            } else if (!this.searchQuery.trim()) {
                this.clearSearch();
            }
        }, 500),

        clearSearch() {
            this.searchQuery = '';
            this.searchError = null;
            this.fetchVehicles();
        },
        nextPage() {
            if (this.pagination.current_page < this.pagination.last_page) {
                this.pagination.current_page++;
                this.loadVehicles();
            }
        },

        prevPage() {
            if (this.pagination.current_page > 1) {
                this.pagination.current_page--;
                this.loadVehicles();
            }
        },

        async loadVehicles() {
            this.loadingVehicles = true;
            try {
                const params = {
                    page: this.pagination.current_page,
                    per_page: this.pagination.per_page
                };

                // Include search query if it exists
                if (this.searchQuery.trim()) {
                    params.q = this.searchQuery.trim();
                }

                const response = await vehicleService.getAll(params);

                this.vehicles = response.data || [];
                this.updatePagination(response.meta || {});

            } catch (error) {
                console.error('Error loading vehicles:', error);
                this.$toast.error('Failed to load vehicles');
            } finally {
                this.loadingVehicles = false;
            }
        },



        openAddVehicleForm() {
            this.isUpdating = false;

            this.resetForm();
            this.isSideFormVisible = true;
        },

        toggleAddVehicleForm() {
            this.isSideFormVisible = !this.isSideFormVisible;
            if (!this.isSideFormVisible) {
                this.resetForm();
            }
        },

        async handleSubmit() {
            this.loading = true;
            this.error = null;

            try {
                if (this.editingVehicle) {
                    await vehicleService.update(this.editingVehicle.id, this.form);
                    this.$toast.success("vehicle updated successfully");
                } else {
                    await vehicleService.store(this.form);
                    this.$toast.success("vehicle created successfully");
                }

                this.closeSideForm();
                await this.fetchVehicles();
            } catch (error) {
                this.error = error.message;
                this.$toast.error("Operation failed");
            } finally {
                this.loading = false;
            }
        },
        // vehicle edit function


        async confirmDelete(id, name) {
            try {
                await vehicleService.delete(id);
                await this.fetchVehicles();

                this.$toast.success("vehicle deleted successfully");


            } catch (error) {
                this.$toast.error("Failed to delete vehicle");
            }

        },

        resetForm() {
            this.form = {
                name: "",
                active: true
            };
            this.editingVehicle = null;
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