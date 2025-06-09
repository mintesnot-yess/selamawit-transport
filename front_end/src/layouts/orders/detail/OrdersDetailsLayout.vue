<template>
    <div class="flex-1 flex flex-col bg-gray-50">
        <!-- Header -->
        <header
            class="sticky top-0 z-30 flex items-center justify-between px-4 md:px-6 py-4 border-b border-surface-200 bg-white/80 backdrop-blur-sm">
            <span></span>
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

        <!-- Main Content -->
        <main class="p-4 md:p-6 overflow-auto">
            <!-- Loading State -->
            <div v-if="loading" class="flex justify-center items-center h-64">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
            </div>

            <!-- Error State -->
            <div v-else-if="error" class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">Failed to load order details: {{ error }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Details -->
            <div v-else-if="orders" class="bg-white rounded-xl shadow-sm ">
                <!-- Order Header -->
                <div class="px-6 py-4 border-b border-surface-200 bg-surface-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-surface-900">{{ orders.name || `Order #${orders.id}`
                                }}</h2>
                            <p class="text-sm text-surface-500">Order Details</p>
                        </div>
                    </div>
                </div>

                <!-- Grid Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
                    <!-- Basic Info -->
                    <!-- Basic Info -->
                    <div class="space-y-4 w-auto ">
                        <h3 class="text-sm font-medium text-surface-500 uppercase tracking-wider">Basic Information</h3>
                        <div class="space-y-2 overflow-x-auto ">
                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Order Name</span>
                                <span class="text-sm font-medium text-surface-900">{{ orders.name || `Order
                                    #${orders.id}` }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Client</span>
                                <span class="text-sm font-medium text-surface-900">{{ orders.client?.name ?? 'N/A'
                                    }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Vehicle</span>
                                <span class="text-sm font-medium text-surface-900">
                                    {{ `${orders.vehicle?.vehicle_name ?? ''} ${orders.vehicle?.plate_number ??
                                        ''}`.trim() || 'N/A' }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Driver</span>
                                <span class="text-sm font-medium text-surface-900">
                                    {{ `${orders.employee?.first_name ?? ''} ${orders.employee?.last_name ?? ''}`.trim()
                                        || 'N/A' }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Load Type</span>
                                <span class="text-sm font-medium text-surface-900">{{ orders.load_type?.name ?? 'N/A'
                                    }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Loading Place</span>
                                <span class="text-sm font-medium text-surface-900">{{
                                    orders.loading_location?.location_name ?? 'N/A' }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Destination</span>
                                <span class="text-sm font-medium text-surface-900">{{
                                    orders.destination_location?.location_name ?? 'N/A' }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Quintal</span>
                                <span class="text-sm font-medium text-surface-900">{{ orders.quintal ?? 'N/A' }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Given Tariff</span>
                                <span class="text-sm font-medium text-surface-900">{{ orders.given_tariff ?? 'N/A'
                                    }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Sub Tariff</span>
                                <span class="text-sm font-medium text-surface-900">{{ orders.sub_tariff ?? 'N/A'
                                    }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Order Date</span>
                                <span class="text-sm font-medium text-surface-900">
                                    {{ orders.order_date ? new Date(orders.order_date).toLocaleDateString() : '-' }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Arrival At Loading</span>
                                <span class="text-sm font-medium text-surface-900">
                                    {{ orders.arrival_at_loading_site ? new
                                        Date(orders.arrival_at_loading_site).toLocaleDateString() : '-' }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Loading Date</span>
                                <span class="text-sm font-medium text-surface-900">
                                    {{ orders.loading_date ? new Date(orders.loading_date).toLocaleDateString() : '-' }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Current Condition</span>
                                <span class="text-sm font-medium text-surface-900">{{ orders.current_condition ?? 'N/A'
                                    }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Payment Collected</span>
                                <span
                                    :class="orders.payment_collected ? 'text-green-600 font-medium' : 'text-red-400 font-medium'">
                                    {{ orders.payment_collected ? 'Yes' : 'No' }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Status</span>
                                <span class="text-sm font-medium text-surface-900">{{ orders.status ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payments / Expenses Tabs -->
                    <section class="lg:col-span-2 space-y-4">
                        <div class="flex gap-2 items-center">
                            <button @click="isPaymentCollected = false" :class="[
                                'px-4 py-2 rounded-lg text-sm font-medium',
                                !isPaymentCollected ? 'bg-gray-100 text-gray-900' : 'text-gray-600'
                            ]">
                                Expenses
                            </button>
                            <button @click="isPaymentCollected = true" :class="[
                                'px-4 py-2 rounded-lg text-sm font-medium',
                                isPaymentCollected ? 'bg-gray-100 text-gray-900' : 'text-gray-600'
                            ]">
                                Payment Collected
                            </button>
                        </div>

                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-base font-medium text-surface-800">
                                {{ isPaymentCollected ? 'Payments' : 'Expenses' }}
                            </h3>
                            <button @click="handleAddClick"
                                class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                                + Add {{ isPaymentCollected ? 'Payment Collected' : 'Expense' }}
                            </button>
                        </div>

                        <!-- Table -->
                        <TableWrapper :columns="isPaymentCollected ? paymentColumns : expenseColumns"
                            :items="isPaymentCollected ? incomes : expenses" />


                    </section>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="bg-white rounded-xl shadow-sm p-8 text-center">
                <i class="fas fa-car text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">No Order Found</h3>
                <p class="mt-1 text-sm text-gray-500">We couldn't find any order with the specified ID.</p>
                <button @click="$router.go(-1)"
                    class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Orders
                </button>
            </div>


            <div id="side_form_container" class="side-form" :class="{ hidden: !isSidePaymentFormVisible }">
                <div
                    class="fixed z-50 top-0 left-0 bg-zinc-900 bg-opacity-50 h-full w-full shadow-2xl border border-gray-10 flex overflow-y-auto">
                    <button aria-label="Close" @click="toggleAddPaymentForm"
                        class="toggle_side_form_btn absolute top-0 right-2 text-gey-500 m-5 hover:text-gray-700 rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-100 transition-colors duration-200">
                        <i class="fa fa-xmark"></i>
                    </button>
                    <div @click="toggleAddPaymentForm" id="side_form"
                        class="w-0 md:w-full sticky top-0 bg-transparent cursor-pointer"></div>
                    <div id="side_form" class="md:max-w-md p-6 w-full h-full overflow-auto bg-white rounded-xl">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="font-bold text-gray-800 text-xl md:text-2xl leading-tight">
                                Payment Collection
                            </h2>
                        </div>
                        <p class="text-sm text-indigo-600 mb-6 leading-relaxed font-medium">
                            {{ isUpdating ? 'Update Order Information' : 'Fill Payment Collection Information ' }}
                        </p>
                        <form @submit.prevent="isUpdating ? handleSubmitUpdate() : handleSubmitAdd()"
                            class="flex flex-col space-y-6 font-['Inter']" novalidate>


                        </form>
                    </div>
                </div>
            </div>

            <div id="side_form_container" class="side-form" :class="{ hidden: !isSideExpenseFormVisible }">
                <div
                    class="fixed z-50 top-0 left-0 bg-zinc-900 bg-opacity-50 h-full w-full shadow-2xl border border-gray-10 flex overflow-y-auto">
                    <button aria-label="Close" @click="toggleAddExpenseForm"
                        class="toggle_side_form_btn absolute top-0 right-2 text-gey-500 m-5 hover:text-gray-700 rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-100 transition-colors duration-200">
                        <i class="fa fa-xmark"></i>
                    </button>
                    <div @click="toggleAddExpenseForm" id="side_form"
                        class="w-0 md:w-full sticky top-0 bg-transparent cursor-pointer"></div>
                    <div id="side_form" class="md:max-w-md p-6 w-full h-full overflow-auto bg-white rounded-xl">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="font-bold text-gray-800 text-xl md:text-2xl leading-tight">
                                Expense
                            </h2>
                        </div>
                        <p class="text-sm text-indigo-600 mb-6 leading-relaxed font-medium">
                            {{ isUpdating ? 'Update Order Information' : 'Add Order Information' }}
                        </p>
                        <form @submit.prevent="isUpdating ? handleSubmitUpdate() : handleSubmitAdd()"
                            class="flex flex-col space-y-6 font-['Inter']" novalidate>

                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import orderService from "@/services/orders";
import UserDropdown from "@/layouts/components/UserDropdown.vue";
import StatusBadge from "./components/StatusBadge.vue";
import DetailItem from "./components/DetailItem.vue";
import TableWrapper from "./components/TableWrapper.vue";

export default {
    components: {
        UserDropdown,
        StatusBadge,
        DetailItem,
        TableWrapper
    },
    data() {
        return {
            orders: [],
            expenses: [],
            incomes: [],

            loading: true,
            error: null,
            isPaymentCollected: false,
            isSidePaymentFormVisible: false,
            isSideExpenseFormVisible: false,


            paymentColumns: [
                { key: "id", label: "#" },
                { key: "bank", label: "Bank" },
                { key: "payment_type", label: "Payment Type" },
                { key: "amount", label: "Amount" },
                { key: "date", label: "Date" },
                { key: "remark", label: "Remark" }
            ],
            expenseColumns: [
                { key: "id", label: "#" },
                { key: "expense_type_id", label: "Expense Type" },
                { key: "amount", label: "Amount" },
                { key: "created_at", label: "Date" },
                { key: "from", label: "From" },
                { key: "to", label: "To" },
                { key: "remark", label: "Remark" },
                { key: "file", label: "File" }
            ]
        };
    },
    computed: {
        vehicleName() {
            return `${this.orders.vehicle?.vehicle_name} ${this.orders.vehicle?.plate_number}`;
        },
        driverName() {
            return `${this.orders.employee?.first_name} ${this.orders.employee?.last_name}`;
        },
        loadingLocation() {
            return this.orders.loading_location?.location_name || "N/A";
        },
        destinationLocation() {
            return this.orders.destination_location?.location_name || "N/A";
        }
    },
    async created() {
        await this.fetchOrder();
    },
    methods: {
        async fetchOrder() {
            this.loading = true;
            try {
                const id = this.$route.params.id;
                const response = await orderService.getOrderById(id);
                this.orders = response.order;
                this.expenses = response.order.expense;
                this.incomes = response.order.income;

            } catch (err) {
                this.error = "Unable to load order.";
            } finally {
                this.loading = false;
            }
        },
        formattedDate(date) {
            return date ? new Date(date).toLocaleDateString() : "-";
        },
        handleAction({ type, item }) {
            if (type === "view") {
                alert(`Viewing item ID: ${item.id}`);
            } else if (type === "edit") {
                alert(`Editing item ID: ${item.id}`);
            } else if (type === "delete") {
                if (confirm("Are you sure you want to delete this?")) {
                    alert(`Deleting item ID: ${item.id}`);
                }
            }
        },
        toggleAddPaymentForm() {
            this.isSidePaymentFormVisible = !this.isSidePaymentFormVisible;
            if (!this.isSidePaymentFormVisible) {
                this.resetForm();
            }
        }, toggleAddExpenseForm() {
            this.isSideExpenseFormVisible = !this.isSideExpenseFormVisible;
            if (!this.isSideExpenseFormVisible) {
                this.resetForm();
            }
        }, handleAddClick() {
            if (this.isPaymentCollected) {
                this.toggleAddPaymentForm();
            } else {
                this.toggleAddExpenseForm();

            }
        }
    }

};
</script>