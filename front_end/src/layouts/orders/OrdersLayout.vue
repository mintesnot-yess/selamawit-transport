<template>

    <div class="flex-1 flex flex-col">
        <!-- Header with search -->

        <header
            class="sticky top-0  flex items-center justify-between px-4 md:px-6 py-4 border-b border-surface-200 bg-white/80 backdrop-blur-sm z-30">
            <span></span>

            <div class="flex items-center gap-3">

                <form @input.prevent="searchOrders(searchQuery)"
                    class="flex items-center border border-surface-300 rounded-lg px-2 py-2 text-surface-500 max-w-md w-full focus-within:ring-2 focus-within:ring-accent-500 focus-within:border-accent-500 transition-all">
                    <i class="fas fa-search mr-2 text-sm"></i>
                    <input v-model="searchQuery" @input="handleSearchInput"
                        class="flex-1 outline-none text-sm text-surface-700 placeholder:text-surface-400 bg-transparent"
                        placeholder="Search orders..." type="search" />
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

        <main class="p-4 md:p-6 space-y-6 h-screen   overflow-x-auto">
            <!-- Orders Table -->
            <div class="bg-white rounded-xl shadow-sm border border-surface-200">
                <div class="px-6 py-4 border-b border-surface-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-surface-900">Brders Accounts</h2>
                            <p class="text-sm text-surface-500">
                                <template v-if="isSearching">Searching...</template>
                                <template v-else-if="searchError" class="text-red-500">{{ searchError }}</template>
                                <template v-else>
                                    Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} order
                                    Accounts
                                </template>
                            </p>
                        </div>

                        <button v-if="hasPermission('create-order')" @click="openAddOrderForm"
                            class="text-sm font-semibold text-white hover:text-white p-2 bg-blue-500 hover:bg-blue-400 rounded-lg flex items-center justify-center text-center gap-2 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md">
                            <i class="fas fa-plus"></i>
                            <span>Add Order</span>
                        </button>

                    </div>
                </div>

                <div>
                    <div>
                        <table
                            class="min-w-[900px] w-full text-xs md:text-sm divide-y divide-surface-200 text-surface-600">
                            <thead class="bg-surface-50">
                                <tr>
                                    <th
                                        class="px-2 py-2 md:px-3 md:py-3 text-left font-semibold text-surface-400 uppercase tracking-wider text-xs">
                                        #
                                    </th>
                                    <th
                                        class="px-2 py-2 md:px-3 md:py-3 text-left font-semibold text-surface-400 uppercase tracking-wider text-xs">
                                        Order Name
                                    </th>
                                    <th
                                        class="px-2 py-2 md:px-3 md:py-3 text-left font-semibold text-surface-400 uppercase tracking-wider text-xs">
                                        Client
                                    </th>
                                    <th
                                        class="px-2 py-2 md:px-3 md:py-3 text-left font-semibold text-surface-400 uppercase tracking-wider text-xs">
                                        Vehicle
                                    </th>
                                    <th
                                        class="px-2 py-2 md:px-3 md:py-3 text-left font-semibold text-surface-400 uppercase tracking-wider text-xs">
                                        Driver
                                    </th>
                                    <th
                                        class="px-2 py-2 md:px-3 md:py-3 text-left font-semibold text-surface-400 uppercase tracking-wider text-xs">
                                        Load Type
                                    </th>
                                    <th
                                        class="px-2 py-2 md:px-3 md:py-3 text-left font-semibold text-surface-400 uppercase tracking-wider text-xs">
                                        Loading Place
                                    </th>
                                    <th
                                        class="px-2 py-2 md:px-3 md:py-3 text-left font-semibold text-surface-400 uppercase tracking-wider text-xs">
                                        Destination
                                    </th>
                                    <th
                                        class="px-2 py-2 md:px-3 md:py-3 text-left font-semibold text-surface-400 uppercase tracking-wider text-xs">
                                        Quintal
                                    </th>
                                    <th
                                        class="px-2 py-2 md:px-3 md:py-3 text-left font-semibold text-surface-400 uppercase tracking-wider text-xs">
                                        Given Tariff
                                    </th>
                                    <th
                                        class="px-2 py-2 md:px-3 md:py-3 text-left font-semibold text-surface-400 uppercase tracking-wider text-xs">
                                        Sub Tariff
                                    </th>
                                    <th
                                        class="px-2 py-2 md:px-3 md:py-3 text-left font-semibold text-surface-400 uppercase tracking-wider text-xs">
                                        Order Date
                                    </th>
                                    <th
                                        class="px-2 py-2 md:px-3 md:py-3 text-left font-semibold text-surface-400 uppercase tracking-wider text-xs">
                                        Arrival At Loading
                                    </th>
                                    <th
                                        class="px-2 py-2 md:px-3 md:py-3 text-left font-semibold text-surface-400 uppercase tracking-wider text-xs">
                                        Loading Date
                                    </th>
                                    <th
                                        class="px-2 py-2 md:px-3 md:py-3 text-left font-semibold text-surface-400 uppercase tracking-wider text-xs">
                                        Current Condition
                                    </th>
                                    <th
                                        class="px-2 py-2 md:px-3 md:py-3 text-left font-semibold text-surface-400 uppercase tracking-wider text-xs">
                                        Payment Collected
                                    </th>
                                    <th
                                        class="px-2 py-2 md:px-3 md:py-3 text-left font-semibold text-surface-400 uppercase tracking-wider text-xs">
                                        Status
                                    </th>
                                    <th class="relative px-2 py-2 md:px-3 md:py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-surface-100 text-surface-700">
                                <template v-if="loadingOrders">
                                    <tr v-for="i in 5" :key="`skeleton-${i}`">
                                        <td v-for="j in 18" :key="j" class="px-2 py-3 whitespace-nowrap">
                                            <div class="h-3 bg-surface-100 rounded w-3/4 animate-pulse"></div>
                                        </td>
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr v-if="orders.length === 0 && !loadingOrders">
                                        <td colspan="18"
                                            class="px-2 py-8 text-center text-surface-300 text-base font-normal">
                                            <i class="fas fa-box-open text-2xl mb-2 block"></i>
                                            No orders found.
                                        </td>
                                    </tr>
                                    <tr v-for="(order, idx) in orders" :key="order.id"
                                        class="group hover:bg-blue-50 transition text-xs text-surface-700">
                                        <td class="px-2 py-3 whitespace-nowrap text-center font-normal">
                                            {{ (pagination.from - 1) + (idx + 1) }}
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap">
                                            <router-link :to="`orders/${order.id}`"
                                                class="font-medium text-surface-800">
                                                {{ order.name || `Order #${order.id}` }}
                                            </router-link>
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap">
                                            <span v-if="order.client" class="text-surface-800">{{ order.client.name
                                                }}</span>
                                            <span v-else class="text-surface-300 italic">N/A</span>
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap">
                                            <div v-if="order.vehicle" class="flex flex-col">
                                                <span class="font-medium text-surface-800">{{ order.vehicle.plate_number
                                                    }}</span>
                                                <span class="text-xs text-surface-400">{{ order.vehicle.vehicle_name
                                                    }}</span>
                                            </div>
                                            <span v-else class="text-surface-300 italic">N/A</span>
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap">
                                            <div v-if="order.employee" class="flex flex-col">
                                                <span class="font-medium text-surface-800">{{ order.employee.first_name
                                                    }} {{ order.employee.last_name }}</span>
                                                <span class="text-xs text-surface-400">Driver</span>
                                            </div>
                                            <span v-else class="text-surface-300 italic">N/A</span>
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap">
                                            <span v-if="order.load_type"
                                                class="inline-block bg-blue-50 text-blue-600 px-2 py-0.5 rounded text-xs font-medium">
                                                {{ order.load_type.name }}
                                            </span>
                                            <span v-else class="text-surface-300 italic">N/A</span>
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap">
                                            <span v-if="order.loading_location"
                                                class="block font-medium text-surface-800">
                                                {{ order.loading_location.location_name }}
                                            </span>
                                            <span v-else class="text-surface-300 italic">N/A</span>
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap">
                                            <span v-if="order.destination_location"
                                                class="block font-medium text-surface-800">
                                                {{ order.destination_location.location_name }}
                                            </span>
                                            <span v-else class="text-surface-300 italic">N/A</span>
                                        </td>
                                        <td
                                            class="px-2 py-3 whitespace-nowrap text-center font-medium text-surface-800">
                                            {{ order.quintal || '-' }}
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap">
                                            <span class="text-surface-800">{{ order.given_tariff || '-' }}</span>
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap">
                                            <span class="text-surface-800">{{ order.sub_tariff || '-' }}</span>
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap text-xs">
                                            <span class="text-surface-700">{{ order.order_date ? new
                                                Date(order.order_date).toLocaleDateString() : '-' }}</span>
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap text-xs">
                                            <span class="text-surface-700">
                                                {{ order.arrival_at_loading_site ? new
                                                    Date(order.arrival_at_loading_site).toLocaleDateString() : '-' }}</span>
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap text-xs">
                                            <span class="text-surface-700">{{ order.loading_date ? new
                                                Date(order.loading_date).toLocaleDateString() : '-' }}</span>
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap text-xs">
                                            <span class="text-surface-700">{{ order.current_condition || '-' }}</span>
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap text-xs text-center">
                                            <span
                                                :class="order.payment_collected ? 'text-green-600 font-medium' : 'text-red-400 font-medium'">
                                                {{ order.payment_collected ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap text-xs text-center">
                                            <span :class="[
                                                'px-2 py-1 rounded font-medium inline-block min-w-[60px] text-center',
                                                order.status === 'PENDING' ? 'bg-yellow-50 text-yellow-600' : '',
                                                order.status === 'COMPLETED' ? 'bg-green-50 text-green-600' : '',
                                                order.status === 'IN_PROGRESS' ? 'bg-blue-50 text-blue-600' : '',
                                                order.status === 'CANCELLED' ? 'bg-red-50 text-red-500' : ''
                                            ]">
                                                {{ order.status }}
                                            </span>
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap text-right font-normal">
                                            <ToggleMenu @show="() => $router.push(`/orders/${order.id}`)"
                                                @edit="editOrder(order)"
                                                @delete="confirmDelete(order.id, order.name || `Order #${order.id}`)" />
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="pagination.last_page > 1"
                        class="px-6 py-4 border-t border-surface-100 flex items-center justify-between">
                        <div class="text-xs text-surface-300">
                            Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} results
                        </div>
                        <div class="flex space-x-2">
                            <button @click="prevPage" :disabled="pagination.current_page === 1"
                                class="px-3 py-1 border rounded-md text-xs text-surface-400 border-surface-100 bg-white disabled:opacity-50 disabled:cursor-not-allowed">
                                Previous
                            </button>
                            <button @click="nextPage" :disabled="pagination.current_page === pagination.last_page"
                                class="px-3 py-1 border rounded-md text-xs text-surface-400 border-surface-100 bg-white disabled:opacity-50 disabled:cursor-not-allowed">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Form Sidebar -->
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
                    <div id="side_form" class="md:max-w-md p-6 w-full h-full overflow-auto bg-white rounded-xl">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="font-bold text-gray-800 text-xl md:text-2xl leading-tight">
                                Orders
                            </h2>
                        </div>
                        <p class="text-sm text-indigo-600 mb-6 leading-relaxed font-medium">
                            {{ isUpdating ? 'Update Order Information' : 'Add Order Information' }}
                        </p>
                        <form @submit.prevent="isUpdating ? handleSubmitUpdate() : handleSubmitAdd()"
                            class="flex flex-col space-y-6 font-['Inter']" novalidate>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Client</label>
                                <select v-model="form.client_id" required
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3">
                                    <option value="">Select client</option>
                                    <option v-for="client in clients" :key="client.id" :value="client.id">
                                        {{ client.name }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Driver</label>
                                <select v-model="form.employee_id" required
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3">
                                    <option value="">Select driver</option>
                                    <option v-for="employee in employees" :key="employee.id" :value="employee.id">
                                        {{ employee.first_name }} {{ employee.last_name }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Vehicle</label>
                                <select v-model="form.vehicle_id" required
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3">
                                    <option value="">Select vehicle</option>
                                    <option v-for="vehicle in vehicles" :key="vehicle.id" :value="vehicle.id">
                                        {{ vehicle.plate_number }} - {{ vehicle.vehicle_name }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Load
                                    Type</label>
                                <select v-model="form.load_type_id" required
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3">
                                    <option value="">Select load type</option>
                                    <option v-for="type in loadTypes" :key="type.id" :value="type.id">
                                        {{ type.name }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Loading
                                    Place</label>
                                <select v-model="form.loading_place" required
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3">
                                    <option value="">Select loading place</option>
                                    <option v-for="location in locations" :key="location.id" :value="location.id">
                                        {{ location.location_name }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Destination</label>
                                <select v-model="form.destination" required
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3">
                                    <option value="">Select destination</option>
                                    <option v-for="location in locations" :key="location.id" :value="location.id">
                                        {{ location.location_name }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Quintal</label>
                                <input v-model.number="form.quintal" type="number" step="0.01" required
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3"
                                    placeholder="Quintal" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Given
                                    Tariff</label>
                                <input v-model.number="form.given_tariff" type="number" step="0.01" required
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3"
                                    placeholder="Given Tariff" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Sub
                                    Tariff</label>
                                <input v-model.number="form.sub_tariff" type="number" step="0.01" required
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3"
                                    placeholder="Sub Tariff" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Arrival at
                                    Loading
                                    Site</label>
                                <input v-model="form.arrival_at_loading_site" type="date" required
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Loading
                                    Date</label>
                                <input v-model="form.loading_date" type="date" required
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">Current
                                    Condition</label>
                                <select v-model="form.current_condition" required
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3">
                                    <option value="">Select condition</option>
                                    <option value="OFFLOADED">OFFLOADED</option>
                                    <option value="LOADED">LOADED</option>
                                </select>
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
</template>

<script>

import orderService from '@/services/orders';
import AppAside from "../components/AppAside.vue";
import UserDropdown from "../components/UserDropdown.vue";
import ToggleMenu from "./components/ToggleMenu.vue";
import { debounce } from 'lodash';
import { usePermissions } from "@/stores/usePermissions";


export default {
    components: {
        AppAside,
        UserDropdown,
        ToggleMenu
    },
    setup() {
        const { hasPermission } = usePermissions(); // ✅ Safe: called inside setup()

        return {
            hasPermission,
            // ... other reactive properties or methods
        };
    },
    data() {
        return {
            form: {
                client_id: "",
                employee_id: "",
                vehicle_id: "",
                loading_place: "",
                destination: "",
                load_type_id: "",
                quintal: null,
                given_tariff: null,
                sub_tariff: null,
                arrival_at_loading_site: "",
                loading_date: "",
                current_condition: "",

            },
            orders: [],
            clients: [],
            employees: [],
            vehicles: [],
            locations: [],
            loadTypes: [],
            loading: false,
            loadingOrders: false,
            error: null,
            success: null,
            editingOrder: null,
            searchQuery: '',
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
        await this.fetchOrders();
    },
    methods: {

        async fetchOrders(page = 1) {
            this.loadingOrders = true;
            try {
                const response = await orderService.getAll({
                    page: page,
                    perPage: this.pagination.per_page,
                    search: this.searchQuery
                });


                // Standardized response handling
                this.orders = response.data;
                // Populate dropdown lists if present in response
                if (response.clients) this.clients = response.clients;
                if (response.employees) this.employees = response.employees;
                if (response.vehicles) this.vehicles = response.vehicles;
                if (response.locations) this.locations = response.locations;
                if (response.loadTypes) this.loadTypes = response.loadTypes;
                console.log("Response from fetchOrders:", response);

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
                console.error('Error fetching orders:', error);
                this.$toast.error("Failed to load orders: " + error.message);
            } finally {
                this.loadingOrders = false;
            }
        },

        async handleSubmitAdd() {

            this.loading = true;
            this.error = null;
            // If editingOrder is set, update the order, else create new
            // make Validation
            if (!this.form.client_id || !this.form.employee_id || !this.form.vehicle_id ||
                !this.form.loading_place || !this.form.destination || !this.form.load_type_id ||
                this.form.quintal === null || this.form.given_tariff === null ||
                this.form.sub_tariff === null || !this.form.arrival_at_loading_site ||
                !this.form.loading_date || !this.form.current_condition) {
                this.error = "Please fill all required fields";
                this.loading = false;
                return;
            }

            try {
                const response = await orderService.store(this.form);
                await this.fetchOrders();
                this.$router.push('orders');


                this.form.name = "";
                this.isSideFormVisible = false;


            } catch (error) {
                this.error = error.response?.data?.message || error.message || "Failed to save order information";
                console.error("Order save error:", error);
            } finally {
                this.loading = false;
            }
        }, async handleSubmitUpdate() {

            this.loading = true;
            this.error = null;
            this.success = null;
            // If editingOrder is set, update the order, else create new

            try {
                const response = await orderService.update(this.form.id, this.form);
                await this.fetchOrders();
                this.success = "Order updated successfully"




            } catch (error) {
                this.error = error.response?.data?.message || error.message || "Failed to save order information";
                console.error("Order save error:", error);
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
        async searchOrders() {
            if (!this.searchQuery.trim()) {
                this.clearSearch();
                return;
            }

            this.isSearching = true;
            this.searchError = null;

            try {
                const response = await orderService.search({
                    query: this.searchQuery,
                    page: this.pagination.current_page,
                    perPage: this.pagination.per_page
                });

                if (response.success) {
                    this.orders = response.data;
                    this.updatePagination(response.meta);
                } else {
                    throw new Error(response.message || 'Invalid response');
                }
            } catch (error) {
                console.error('Search error:', error);
                this.searchError = typeof error === 'string' ? error : error.message;
                this.orders = [];
                this.$toast.error(`Search failed: ${this.searchError}`);
            } finally {
                this.isSearching = false;
            }
        },

        // Debounced search input handler
        handleSearchInput: debounce(function () {
            if (this.searchQuery.trim().length >= 3) {
                this.searchOrders();
            } else if (!this.searchQuery.trim()) {
                this.clearSearch();
            }
        }, 500),

        clearSearch() {
            this.searchQuery = '';
            this.searchError = null;
            this.fetchOrders();
        },
        nextPage() {
            if (this.pagination.current_page < this.pagination.last_page) {
                this.pagination.current_page++;
                this.loadOrders();
            }
        },

        prevPage() {
            if (this.pagination.current_page > 1) {
                this.pagination.current_page--;
                this.loadOrders();
            }
        },

        async loadOrders() {
            this.loadingOrders = true;
            try {
                const params = {
                    page: this.pagination.current_page,
                    per_page: this.pagination.per_page
                };

                // Include search query if it exists
                if (this.searchQuery.trim()) {
                    params.q = this.searchQuery.trim();
                }

                const response = await orderService.getAll(params);

                this.orders = response.data || [];
                this.updatePagination(response.meta || {});

            } catch (error) {
                console.error('Error loading orders:', error);
                this.$toast.error('Failed to load orders');
            } finally {
                this.loadingOrders = false;
            }
        },



        openAddOrderForm() {
            this.isUpdating = false;

            this.resetForm();
            this.isSideFormVisible = true;
        },

        toggleAddOrderForm() {
            this.isSideFormVisible = !this.isSideFormVisible;
            if (!this.isSideFormVisible) {
                this.resetForm();
            }
        },

        async handleSubmit() {
            this.loading = true;
            this.error = null;

            try {
                if (this.editingOrder) {
                    await orderService.update(this.editingOrder.id, this.form);
                    this.$toast.success("Order updated successfully");
                } else {
                    await orderService.store(this.form);
                    this.$toast.success("Order created successfully");
                }

                this.closeSideForm();
                await this.fetchOrders();
            } catch (error) {
                this.error = error.message;
                this.$toast.error("Operation failed");
            } finally {
                this.loading = false;
            }
        },
        // order edit function
        editOrder(order) {
            this.isUpdating = true;
            this.form = {
                id: order.id,
                name: order.name || "",
                client_id: order.client_id || "",
                employee_id: order.employee_id || "",
                vehicle_id: order.vehicle_id || "",
                loading_place: order.loading_place || "",
                destination: order.destination || "",
                load_type_id: order.load_type_id || "",
                quintal: order.quintal ?? null,
                given_tariff: order.given_tariff ?? null,
                sub_tariff: order.sub_tariff ?? null,
                arrival_at_loading_site: order.arrival_at_loading_site || "",
                loading_date: order.loading_date || "",
                current_condition: order.current_condition || "",


            };
            this.isSideFormVisible = true;

        },

        async confirmDelete(id, name) {
            if (confirm(`Are you sure you want to delete ${name} order?`)) {
                try {
                    await orderService.delete(id);
                    await this.fetchOrders();

                    this.$toast.success("Order deleted successfully");


                } catch (error) {
                    this.$toast.error("Failed to delete order");
                }
            }
        },

        resetForm() {
            this.form = {
                name: "",
                active: true
            };
            this.editingOrder = null;
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