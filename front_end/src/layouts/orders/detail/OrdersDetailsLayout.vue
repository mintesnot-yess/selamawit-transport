<template>
    <div class="flex-1 flex flex-col bg-gray-50">
        <!-- Header -->
        <header
            class="sticky top-0 z-30 flex items-center justify-between px-4 md:px-6 py-4 border-b border-surface-200 bg-white/80 backdrop-blur-sm">
            <span></span>

            <UserDropdown />

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
                                class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
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

                        <form @submit.prevent="isUpdating ? handleSubmitUpdate() : handleSubmitAddPayment()"
                            enctype="multipart/form-data" class="flex flex-col space-y-6 font-['Inter']" novalidate>

                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-1">
                                    Order
                                </label>
                                <input disabled type="text"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                    :placeholder="orders.name || `Order #${orders.id}`" />
                                <input v-model="payment_collected_form.order_id" type="hidden" />
                            </div>




                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">From Bank</label>
                                <div class="relative">
                                    <select v-model="payment_collected_form.bank_id"
                                        class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 pr-10 text-gray-900 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                        <option value="" disabled>From Bank</option>
                                        <option v-for="bank in banks" :key="bank.id" :value="bank.id">
                                            {{ bank.name }}
                                        </option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">From Account</label>
                                <div class="relative">
                                    <select v-model="payment_collected_form.account_number"
                                        class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 pr-10 text-gray-900 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                        <option value="" disabled>From Account</option>
                                        <option v-for="bank_account in bank_accounts" :key="bank_account.account_number"
                                            :value="bank_account.account_number">
                                            {{ bank_account.account_number }}
                                        </option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                    Date</label>

                                <input type="date" v-model="payment_collected_form.received_date"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm">
                            </div>
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-800 mb-1">
                                    Amount
                                </label>
                                <input v-model="payment_collected_form.amount" id="amount" type="text"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                    placeholder="Enter Amount" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-1">
                                    Remark
                                </label>
                                <input v-model="payment_collected_form.remark" type="text"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                    placeholder="Enter Amount" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Payment
                                    Method</label>
                                <div class="relative">
                                    <select v-model="payment_collected_form.payment_type"
                                        class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 pr-10 text-gray-900 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                        <option value="" disabled>Choose Payment Method</option>
                                        <option value="cash">Cash</option>
                                        <option value="transfer">Transfer</option>
                                        <option value="check">Check</option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="libre_input" class="block text-sm font-medium text-gray-800 mb-1">
                                    Attachment
                                </label>
                                <div class="relative flex items-center">
                                    <input id="libre_input" type="file" class="sr-only"
                                        @change="payment_collected_form.attachment = $event.target.files[0]" />
                                    <label for="libre_input"
                                        class="flex items-center justify-center w-full px-4 py-2 bg-white border border-gray-300/80 rounded-xl shadow-sm cursor-pointer hover:bg-blue-50 transition-all duration-200 text-gray-700">
                                        <i class="fas fa-upload mr-2 text-blue-500"></i>
                                        <span>
                                            {{ payment_collected_form.attachment ?
                                                payment_collected_form.attachment.name :
                                                'Choose_file...' }}
                                        </span>
                                    </label>

                                </div>
                            </div>
                            <button :disabled="loading" type="submit"
                                class="mt-2 w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md hover:shadow-lg disabled:opacity-60 disabled:cursor-not-allowed">
                                <span v-if="!loading">SAVE</span>
                                <span v-else>Processing...</span>
                            </button>
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
                            {{ isUpdating ? 'Update Expense Information' : 'Fill Expense Information' }}
                        </p>

                        <form @submit.prevent="isUpdating ? handleSubmitUpdate() : handleSubmitAdd()"
                            enctype="multipart/form-data" class="flex flex-col space-y-6 font-['Inter']" novalidate>

                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-1">
                                    Order
                                </label>
                                <input disabled type="text"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                    :placeholder="orders.name || `Order #${orders.id}`" />

                                <input v-model="form.order_id" type="hidden" />
                            </div>
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-800 mb-1">
                                    Amount
                                </label>
                                <input v-model="form.amount" id="amount" type="text"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                    placeholder="Enter Amount" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Expense Type</label>
                                <div class="relative">
                                    <select v-model="form.expense_type"
                                        class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 pr-10 text-gray-900 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                        <option value="" disabled>Choose Expense Type</option>
                                        <option v-for="expense_type in expense_types" :key="expense_type.id"
                                            :value="expense_type.id">
                                            {{ expense_type.name }}
                                        </option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                    Date</label>

                                <input type="date" v-model="form.paid_date"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">From Bank</label>
                                <div class="relative">
                                    <select v-model="form.selectedBank"
                                        class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 pr-10 text-gray-900 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                        <option value="" disabled>From Bank</option>
                                        <option v-for="bank in banks" :key="bank.id" :value="bank.id">
                                            {{ bank.name }}
                                        </option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">From Account</label>
                                <div class="relative">
                                    <select v-model="form.selectedAccount"
                                        class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 pr-10 text-gray-900 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                        <option value="" disabled>From Account</option>
                                        <option v-for="bank_account in bank_accounts" :key="bank_account.id"
                                            :value="bank_account.id">
                                            {{ bank_account.account_number }}
                                        </option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">To Bank</label>
                                <div class="relative">
                                    <select v-model="form.toBank"
                                        class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 pr-10 text-gray-900 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                        <option value="" disabled>To Bank</option>
                                        <option v-for="bank in banks" :key="bank.id" :value="bank.id">
                                            {{ bank.name }}
                                        </option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-1">
                                    To Account
                                </label>
                                <input v-model="form.toAccount" type="text"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                    placeholder="Enter Amount" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-1">
                                    Remark
                                </label>
                                <input v-model="form.remark" type="text"
                                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                    placeholder="Enter Amount" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Payment
                                    Method</label>
                                <div class="relative">
                                    <select v-model="form.payment_type"
                                        class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 pr-10 text-gray-900 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                        <option value="" disabled>Choose Payment Method</option>
                                        <option value="cash">Cash</option>
                                        <option value="transfer">Transfer</option>
                                        <option value="check">Check</option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="libre_input" class="block text-sm font-medium text-gray-800 mb-1">
                                    File
                                </label>
                                <div class="relative flex items-center">
                                    <input id="libre_input" type="file" class="sr-only"
                                        @change="form.file = $event.target.files[0]" />
                                    <label for="libre_input"
                                        class="flex items-center justify-center w-full px-4 py-2 bg-white border border-gray-300/80 rounded-xl shadow-sm cursor-pointer hover:bg-blue-50 transition-all duration-200 text-gray-700">
                                        <i class="fas fa-upload mr-2 text-blue-500"></i>
                                        <span>
                                            {{ form.file ? form.file.name : 'Choose file...' }}
                                        </span>
                                    </label>

                                </div>
                            </div>
                            <button :disabled="loading" type="submit"
                                class="mt-2 w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md hover:shadow-lg disabled:opacity-60 disabled:cursor-not-allowed">
                                <span v-if="!loading">SAVE</span>
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
import expenseService from '@/services/expenses';
import incomeService from '@/services/incomes';

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
            expense_types: [],
            banks: [],
            bank_accounts: [],

            loading: true,
            error: null,
            isPaymentCollected: false,
            isSidePaymentFormVisible: false,
            isSideExpenseFormVisible: false,

            form: {
                order_id: '',
                amount: '',
                expense_type: '',
                selectedBank: '',
                toBank: '',
                selectedAccount: '',
                toAccount: '',
                payment_type: '',
                paid_date: '',
                remark: '',
                file: '',
            },
            payment_collected_form: {
                order_id: '',
                amount: '',
                bank_id: '',
                account_number: '',
                payment_type: '',
                received_date: '',
                remark: '',
                attachment: '',
            },

            paymentColumns: [
                { key: "id", label: "#" },
                { key: "account_number", label: "Bank" },
                { key: "payment_type", label: "Payment Type" },
                { key: "amount", label: "Amount" },
                { key: "remark", label: "Remark" },
            ],
            expenseColumns: [
                { key: "id", label: "#" },
                { key: "expense_type_id", label: "Expense Type" },
                { key: "payment_type", label: "Payment Type" },
                { key: "amount", label: "Amount" },
                { key: "from_bank", label: "From" },
                { key: "to_account", label: "To" },
                { key: "remark", label: "Remark" },
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
                this.expense_types = response.expense_type;
                this.banks = response.bank;
                this.bank_accounts = response.bank_account;
                this.form.order_id = this.orders.id;
                this.payment_collected_form.order_id = this.orders.id;

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
        },
        async handleSubmitAdd() {

            this.loading = true;
            this.error = null;
            // If editingVehicle is set, update the expense, else create new

            try {


                const response = await expenseService.store(this.form);
                await this.fetchOrder();
                console.log(this.form);


                this.isSideFormVisible = false;


            } catch (error) {
                this.error = error.response?.data?.message || error.message || "Failed to save expense information";
                console.error("expense save error:", error);
            } finally {
                this.loading = false;
            }
        },
        async handleSubmitAddPayment() {

            this.loading = true;
            this.error = null;
            // If editingVehicle is set, update the expense, else create new

            try {


                const response = await incomeService.store(this.payment_collected_form);
                await this.fetchOrder();
                console.log(this.payment_collected_form);


                this.isSideFormVisible = false;


            } catch (error) {
                this.error = error.response?.data?.message || error.message || "Failed to save expense information";
                console.error("expense save error:", error);
            } finally {
                this.loading = false;
            }
        },

    }

};
</script>