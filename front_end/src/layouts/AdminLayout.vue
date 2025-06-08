<template>
    <div class="flex-1 flex flex-col">
        <header
            class="sticky top-0 flex items-center justify-between px-4 md:px-6 py-4 border-b border-surface-200 bg-white/80 backdrop-blur-sm z-30">
            <span></span>
            <!-- <div class="flex items-center gap-3">
                <form
                    class="flex items-center border border-surface-300 rounded-lg px-2 py-2 text-surface-500 max-w-md w-full focus-within:ring-2 focus-within:ring-accent-500 focus-within:border-accent-500 transition-all">
                    <i class="fas fa-search mr-2 text-sm"></i>
                    <input
                        class="flex-1 outline-none text-sm text-surface-700 placeholder:text-surface-400 bg-transparent"
                        placeholder="Search or type command..." type="search" />
                    <kbd
                        class="ml-3 px-2 py-1 rounded-md border border-surface-300 text-surface-500 text-xs font-mono font-medium select-none hidden sm:inline-flex">⌘K</kbd>
                </form>
            </div> -->
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

        <main class="p-4 md:p-6 space-y-6 overflow-scroll">
            <!-- Welcome banner -->
            <div class="bg-gradient-to-r from-accent-600 to-accent-500 rounded-xl p-6 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold">
                            Welcome back, Musharof!
                        </h1>
                        <p class="text-accent-100 mt-1 text-sm md:text-base">
                            Here's what's happening with your store today.
                        </p>
                    </div>
                    <button
                        class="bg-white/10 hover:bg-white/20 border border-white/20 rounded-lg px-4 py-2 text-sm font-medium transition-colors backdrop-blur-sm self-start md:self-auto">
                        View Analytics
                    </button>
                </div>
            </div>

            <!-- Stats grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- <div class="bg-white rounded-xl p-5 shadow-sm border border-surface-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                                <i class="fas fa-wallet text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-surface-500">
                                    This Year Income
                                </p>
                                <p class="text-xl font-bold text-surface-900">
                                    $45,231
                                </p>
                            </div>
                        </div>
                        <div
                            class="text-xs font-medium text-green-600 bg-green-100 rounded-full px-2 py-1 flex items-center gap-1">
                            <i class="fas fa-arrow-up text-[0.6rem]"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="h-2 bg-surface-100 rounded-full overflow-hidden">
                            <div class="h-full bg-green-500 rounded-full" style="width: 100%"></div>
                        </div>
                        <p class="text-xs p-1 rounded-md text-surface-500 mt-2 w-fit hover:bg-slate-100 cursor-pointer">
                            Show Detail
                        </p>
                    </div>
                </div> -->

                <div class="bg-white rounded-xl p-5 shadow-sm border border-surface-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user-lock text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-surface-500">
                                    System User
                                </p>
                                <p v-if="users && users.length" class="text-xl font-bold text-surface-900">
                                    {{ users.length }} </p>
                                <p v-else class="text-xl font-bold text-surface-900">
                                    <i class="fa-solid fa-circle-notch animate-spin"></i>
                                </p>


                            </div>
                        </div>
                        <div
                            class="text-xs font-medium text-green-600 bg-green-100 rounded-full px-2 py-1 flex items-center gap-1">
                            <!-- <i class="fas fa-arrow-up text-[0.6rem]"></i> -->
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="h-2 bg-surface-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full" style="width: 100%"></div>
                        </div>
                        <!-- <p class="text-xs text-surface-500 mt-2">vs last month</p> -->
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 shadow-sm border border-surface-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-car text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-surface-500">Vehicles</p>
                                <p class="text-xl font-bold text-surface-900">
                                <p v-if="vehicles && vehicles.length" class="text-xl font-bold text-surface-900">
                                    {{ vehicles.length }} </p>
                                <p v-else class="text-xl font-bold text-surface-900">
                                    <i class="fa-solid fa-circle-notch animate-spin"></i>
                                </p>

                                </p>
                            </div>
                        </div>
                        <div
                            class="text-xs font-medium text-green-600 bg-green-100 rounded-full px-2 py-1 flex items-center gap-1">
                            <!-- <i class="fas fa-arrow-up text-[0.6rem]"></i> -->
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="h-2 bg-surface-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full" style="width: 100%"></div>
                        </div>
                        <!-- <p class="text-xs text-surface-500 mt-2">vs last month</p> -->
                    </div>
                </div>
                <div class="bg-white rounded-xl p-5 shadow-sm border border-surface-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user-plus text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-surface-500">
                                    Employees
                                </p>
                                <p class="text-xl font-bold text-surface-900">
                                <p v-if="Employees && Employees.length" class="text-xl font-bold text-surface-900">
                                    {{ Employees.length }} </p>
                                <p v-else class="text-xl font-bold text-surface-900">
                                    <i class="fa-solid fa-circle-notch animate-spin"></i>
                                </p>

                                </p>


                            </div>
                        </div>
                        <div
                            class="text-xs font-medium text-green-600 bg-green-100 rounded-full px-2 py-1 flex items-center gap-1">
                            <!-- <i class="fas fa-arrow-up text-[0.6rem]"></i> -->
                            <!-- 8.2% -->
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="h-2 bg-surface-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full" style="width: 100%"></div>
                        </div>
                        <!-- <p class="text-xs text-surface-500 mt-2">vs last month</p> -->
                    </div>
                </div>

                <!-- Orders -->


                <div class="bg-white rounded-xl p-5 shadow-sm border border-surface-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-shopping-bag text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-surface-500">
                                    Total Orders
                                </p>



                                <p v-if="orders && orders.length" class="text-xl font-bold text-surface-900">
                                    {{ orders.length }}
                                </p>
                                <p v-else class="text-xl font-bold text-surface-900">
                                    <i class="fa-solid fa-circle-notch animate-spin"></i>
                                </p>

                            </div>
                        </div>
                        <div
                            class="text-xs font-medium text-blue-600 bg-blue-100 rounded-full px-2 py-1 flex items-center gap-1">
                            <!-- <i class="fas fa-arrow-down text-[0.6rem]"></i> -->
                            <!-- 3.4% -->
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="h-2 bg-surface-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full" style="width: 100%"></div>
                        </div>
                        <!-- <p class="text-xs text-surface-500 mt-2">vs last month</p> -->
                    </div>
                </div>

                <!-- This Year Expense -->
                <div class="bg-white rounded-xl p-5 shadow-sm border border-surface-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                <i class="fas fa-money-bill text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-surface-500">
                                    This Year Expense
                                </p>
                                <p v-if="Expense && orders.length" class="text-xl font-bold text-surface-900">
                                    {{ formatCurrency(Expense) }}
                                </p>
                                <p v-else class="text-xl font-bold text-surface-900">
                                    {{ formatCurrency(0) }}
                                </p>

                            </div>
                        </div>



                        <div
                            class="text-xs font-medium text-purple-600 bg-purple-100 rounded-full px-2 py-1 flex items-center gap-1">
                            <!-- <i class="fas fa-arrow-down text-[0.6rem]"></i> -->
                            <!-- 3.4% -->
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="h-2 bg-surface-100 rounded-full overflow-hidden">
                            <div class="h-full bg-purple-500 rounded-full" style="width: 100%"></div>
                        </div>
                        <!-- <p class="text-xs text-surface-500 mt-2">vs last month</p> -->
                    </div>
                </div>
                <!-- This Month Income -->

                <div class="bg-white rounded-xl p-5 shadow-sm border border-surface-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                                <i class="fas fa-money-bill text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-surface-500">
                                    This Month Income
                                </p>
                                <p class="text-xl font-bold text-surface-900">
                                    $5,727
                                </p>
                            </div>
                        </div>
                        <div
                            class="text-xs font-medium text-green-600 bg-green-100 rounded-full px-2 py-1 flex items-center gap-1">
                            <!-- <i class="fas fa-arrow-down text-[0.6rem]"></i> -->
                            <!-- 3.4% -->
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="h-2 bg-surface-100 rounded-full overflow-hidden">
                            <div class="h-full bg-green-500 rounded-full" style="width: 100%"></div>
                        </div>
                        <!-- <p class="text-xs text-surface-500 mt-2">vs last month</p> -->
                    </div>
                </div>
                <!-- This Month Expense -->
                <div class="bg-white rounded-xl p-5 shadow-sm border border-surface-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                <i class="fas fa-arrow-trend-up text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-surface-500">
                                    This Month Expense
                                </p>
                                <p class="text-xl font-bold text-surface-900">
                                    $5,727
                                </p>
                            </div>
                        </div>
                        <div
                            class="text-xs font-medium text-purple-600 bg-purple-100 rounded-full px-2 py-1 flex items-center gap-1">
                            <!-- <i class="fas fa-arrow-down text-[0.6rem]"></i> -->
                            <!-- 3.4% -->
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="h-2 bg-surface-100 rounded-full overflow-hidden">
                            <div class="h-full bg-purple-500 rounded-full" style="width: 100%"></div>
                        </div>
                        <!-- <p class="text-xs text-surface-500 mt-2">vs last month</p> -->
                    </div>
                </div>
            </div>

            <!-- Charts row -->
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
                <!-- Sales chart -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-surface-200 lg:col-span-2">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-lg font-semibold text-surface-900">
                                Income and Expense Overview
                            </h2>
                            <p class="text-sm text-surface-500">
                                Total performance for last 1 year
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-accent-500"></span>
                                <span class="text-xs text-surface-500">Income</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-surface-300"></span>
                                <span class="text-xs text-surface-500">Expose</span>
                            </div>
                            <!-- <button class="ml-2 text-surface-400 hover:text-surface-600">
                                <i class="fas fa-ellipsis-vertical"></i>
                            </button> -->
                        </div>
                    </div>
                    <div class="h-64">
                        <IncomeExpenseChart :labels="months" :income-data="incomes" :expense-data="expenseData" />
                        <!-- <canvas id="salesChart"></canvas> -->
                    </div>
                </div>

                <!-- Revenue target -->
                <!-- <div class="bg-white rounded-xl p-6 shadow-sm border border-surface-200">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-lg font-semibold text-surface-900"></h2>
                            <p class="text-sm text-surface-500">
                                Monthly Income and Expense
                            </p>
                        </div>

                    </div>
                    <div class="flex justify-center">
                        <div class="relative w-40 h-40">
                            <svg class="w-full h-full" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="45" fill="none" stroke="#e2e8f0" stroke-width="8" />
                                <circle cx="50" cy="50" r="45" fill="none" stroke="#6366f1" stroke-width="8"
                                    stroke-linecap="round" stroke-dasharray="283" stroke-dashoffset="130.10"
                                    transform="rotate(-90 50 50)" />
                                <text x="50" y="50" text-anchor="middle" dominant-baseline="middle" font-size="20"
                                    font-weight="600" fill="#0f172a">
                                    55%
                                </text>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-8 grid grid-cols-3 gap-4 text-center">
                        <div>
                            <p class="text-xs text-surface-500">
                                This Month Income
                            </p>
                            <p class="text-sm font-semibold text-indigo-600">
                                $5,727
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-surface-500"></p>
                            <p class="text-sm font-semibold text-surface-900">
                                -
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-surface-500">
                                This Month Expense
                            </p>
                            <p class="text-sm font-semibold text-surface-900">
                                $5,122K
                            </p>
                        </div>
                    </div>
                </div> -->
            </div>

            <!-- Recent orders -->
            <div v-if="orders.length > 1"
                class="bg-white rounded-xl shadow-sm border border-surface-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-surface-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-surface-900">
                                Recent Orders
                            </h2>
                            <p class="text-sm text-surface-500">
                                Latest transactions from your store
                            </p>
                        </div>
                        <router-link to="/orders"
                            class="text-sm font-medium text-accent-600 hover:text-accent-700 flex items-center gap-1">
                            View All
                        </router-link>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-surface-200">
                        <thead class="bg-surface-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Order Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Client Name
                                </th>


                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Loading
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Destination
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Load Type
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Status
                                </th>


                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y  ">

                            <tr v-for="(order, idx) in orders" :key="order.id">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">

                                        <div class="ml-4">
                                            <div class="text-sm font-medium  ">
                                                {{ order.name || `Order #${order.id}` }}
                                            </div>

                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">

                                        <div class="ml-4">
                                            <div class="text-sm font-medium  ">
                                                {{ order.client.name || `Order #${order.id}` }}
                                            </div>

                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">
                                    <div class="text-sm font-medium  ">
                                        {{ order.loading_location.location_name }}
                                    </div>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">
                                    <div class="text-sm font-medium  ">
                                        {{ order.destination_location.location_name }}
                                    </div>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">
                                    {{ order.load_type.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span :class="[
                                        ' ',
                                        order.status === 'PENDING' ? 'bg-yellow-50 text-yellow-600' : '',
                                        order.status === 'COMPLETED' ? 'bg-green-50 text-green-600' : '',
                                        order.status === 'IN_PROGRESS' ? 'bg-blue-50 text-blue-600' : '',
                                        order.status === 'CANCELLED' ? 'bg-red-50 text-red-500' : ''
                                    ]">
                                        {{ order.status }}
                                    </span>
                                </td>






                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>


        </main>
    </div>
    <AppFooter />
</template>

<script>
import { ref } from "vue";
import userService from '@/services/users';
import vehicleService from '@/services/vehicle';
import EmployeeService from '@/services/employees';
import orderService from '@/services/orders';
import ExpenseService from '@/services/expenses';

import UserDropdown from "./components/UserDropdown.vue";
import AppHeader from "./components/AppHeader.vue";
import AppAside from "./components/AppAside.vue";
import AppFooter from "./components/AppFooter.vue";
import IncomeExpenseChart from "./components/IncomeExpenseChart.vue";

const sidebarOpen = ref(false);

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};

const closeSidebar = () => {
    sidebarOpen.value = false;
};


export default {
    components: {
        AppHeader,       // Added missing component
        AppAside,
        AppFooter,        // Added missing component
        IncomeExpenseChart, // Added missing component
        UserDropdown,
    },
    data() {
        return {
            users: [],
            vehicles: [],
            Employees: [],
            orders: [],
            Expense: [],
            months: [],
            incomes: [],
            expenseData: [],


            loadingUsers: false,
            currentPage: 1,
            totalPages: 0,
            searchQuery: null,
        }
    },
    created() {
        this.fetchUsers(); // Fetch users when component is created
        this.fetchVehicles();
        this.fetchEmployees();
        this.fetchOrder();
        this.fetchExpense();

    },
    methods: { // Fixed syntax (was "methods{")



        async fetchUsers() {
            try {
                const response = await userService.getAll();
                this.users = response.data || [];
            } catch (error) { }
        },

        async fetchVehicles() {
            try {
                const response = await vehicleService.getAll();
                this.vehicles = response.data;
            } catch (error) { }
        },
        async fetchEmployees() {
            try {
                const response = await EmployeeService.getAll();
                this.Employees = response.data;
            } catch (error) { }
        },

        async fetchOrder() {
            try {
                const response = await orderService.getAll();
                this.orders = response.data;
            } catch (error) { }
        },
        async fetchExpense() {
            try {
                const response = await ExpenseService.getAll();
                this.Expense = response.totalExpense;

                this.expenseData = response.chart.expenses;
                this.incomes = response.chart.income;
                this.months = response.chart.months;

            } catch (error) { }
        },

        formatCurrency(value) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'ETB'
            }).format(value);
        }




    },




}
</script>