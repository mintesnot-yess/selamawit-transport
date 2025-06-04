<template>
    <!-- Sidebar overlay -->
    <div @click="toggleSidebar" :class="[
        'fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden',
        sidebarOpen ? '' : 'hidden',
    ]" id="sidebar-overlay"></div>

    <!-- Sidebar -->
    <aside :class="[
        'fixed md:sticky top-0 w-fit bg-white border-r border-surface-200 h-screen flex flex-col z-50 transition-transform duration-300',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0',
    ]">
        <AppAside />
    </aside>

    <div class="flex-1 flex flex-col">
        <!-- Header with search -->
        <header
            class="sticky top-0 flex items-center justify-between px-4 md:px-6 py-4 border-b border-surface-200 bg-white/80 backdrop-blur-sm z-30">
            <div class="flex items-center gap-3">
                <button @click="toggleSidebar" id="sidebar-toggle"
                    class="p-2 rounded-lg text-surface-500 hover:text-surface-700 hover:bg-surface-100 md:hidden">
                    <i class="fas fa-bars"></i>
                </button>

                <form @input.prevent="searchVehicles(searchQuery)"
                    class="flex items-center border border-surface-300 rounded-lg px-2 py-2 text-surface-500 max-w-md w-full focus-within:ring-2 focus-within:ring-accent-500 focus-within:border-accent-500 transition-all">
                    <i class="fas fa-search mr-2 text-sm"></i>
                    <input v-model="searchQuery" @input="handleSearchInput"
                        class="flex-1 outline-none text-sm text-surface-700 placeholder:text-surface-400 bg-transparent"
                        placeholder="Search expenses..." type="search" />
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

        <main class="p-4 md:p-6 space-y-6">
            <!-- expenses Table -->
            <div class="bg-white rounded-xl shadow-sm border border-surface-200">
                <div class="px-6 py-4 border-b border-surface-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-surface-900">Expenses</h2>
                            <p class="text-sm text-surface-500">
                                <template v-if="isSearching">Searching...</template>
                                <template v-else-if="searchError" class="text-red-500">{{ searchError }}</template>
                                <!-- <template v-else>
                                    Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }}
                                    expense
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
                            <span>Add expense</span>
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-surface-200 ">
                        <thead class="bg-surface-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    #
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Expense Type
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    From
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    To
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Remark
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    File
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
                                <tr v-for="expense in expenses" :key="expense.id" class="hover:bg-surface-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-surface-900">
                                        {{ (pagination.from - 1) + (expenses.indexOf(expense) + 1) }}
                                    </td>



                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500"
                                        data-v-inspector="src/layouts/orders/components/Tables.vue:53:21">
                                        {{
                                            expense.expense_type.name
                                        }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500"
                                        data-v-inspector="src/layouts/orders/components/Tables.vue:53:21"> {{
                                            expense.expense_type.category + " | " + expense.expense_type.name
                                        }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500"
                                        data-v-inspector="src/layouts/orders/components/Tables.vue:53:21"> {{
                                            expense.amount
                                        }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500"
                                        data-v-inspector="src/layouts/orders/components/Tables.vue:53:21">
                                        {{ new Date(expense.paid_date).toLocaleDateString() }}

                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500"
                                        data-v-inspector="src/layouts/orders/components/Tables.vue:53:21"> {{
                                            expense.from_bank.name + " | " + expense.from_account.account_number
                                        }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500"
                                        data-v-inspector="src/layouts/orders/components/Tables.vue:53:21"> {{
                                            expense.to_bank.name + " | " + expense.to_account
                                        }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500"
                                        data-v-inspector="src/layouts/orders/components/Tables.vue:53:21"> {{
                                            expense.remark ? expense.remark : 'No remark'
                                        }}
                                    </td>




                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">
                                        <template v-if="expense.file">
                                            <img :src="`http://127.0.0.1:8000/storage/${expense.file}`" alt="Libre"
                                                class="h-10 w-10 object-cover rounded"
                                                style="max-width: 60px; max-height: 60px;" />
                                        </template>
                                        <template v-else>
                                            <span class="text-surface-400 italic">No image</span>
                                        </template>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <ToggleMenu @show="() => $router.push(`/expense/${expense.id}`)"
                                            @edit="editVehicle(expense)"
                                            @delete="confirmDelete(expense.id, expense.name)" />
                                    </td>
                                </tr>
                                <tr v-if="expenses.length === 0 && !loadingVehicles">

                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-surface-500">
                                        No expenses found
                                    </td>
                                </tr>
                            </template>






                        </tbody>

                        <!-- With this version -->

                    </table>

                    <!-- Pagination -->

                    <!-- <div v-if="pagination.last_page > 1" -->
                    <div class="px-6 py-4 border-t border-surface-200 flex items-center justify-between">
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

            <!-- expense Form Sidebar -->
            <div id="side_form_container" class="side-form " :class="{ hidden: !isSideFormVisible }">
                <div
                    class="fixed z-50 top-0 left-0 bg-zinc-900 bg-opacity-50 h-full w-full shadow-2xl border border-gray-10 flex overflow-y-auto">
                    <button aria-label="Close" @click="toggleAddVehicleForm"
                        class="toggle_side_form_btn absolute top-0 right-2 text-gey-500 m-5 hover:text-gray-700 rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-100 transition-colors duration-200">
                        <i class="fa fa-xmark"></i>
                    </button>
                    <div @click="toggleAddVehicleForm" id="side_form"
                        class="w-0 md:w-full sticky top-0 bg-transparent cursor-pointer">
                    </div>
                    <div id="side_form" class="md:max-w-md p-6 w-full h-fit overflow-auto bg-white rounded-xl">


                        <template v-if="isUpdating">
                            <div class="flex justify-between items-center mb-3">
                                <h2 class="font-bold text-gray-800 text-xl md:text-2xl leading-tight">
                                    Update expense
                                </h2>
                            </div>
                            <p class="text-sm text-indigo-600 mb-6 leading-relaxed font-medium">
                                Update expense information
                            </p>
                            <form @submit.prevent="handleSubmitUpdate" class="space-y-6 font-['Inter']">
                                <div>
                                    <label for="expense_name" class="block text-sm font-medium text-gray-800 mb-1">
                                        expense Name
                                    </label>
                                    <input v-model="form.expense_name" id="expense_name" type="text"
                                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                        placeholder="Enter expense name" />
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
                                    Expenses
                                </h2>
                            </div>
                            <p class="text-sm text-indigo-600 mb-6 leading-relaxed font-medium">
                                Fill expense Information
                            </p>
                            <form @submit.prevent="handleSubmitAdd" enctype="multipart/form-data"
                                class="space-y-6 font-['Inter']">

                                <div class="space-y-6 max-w-3xl mx-auto">
                                    <!-- Main Category Selector -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Expense
                                            Category</label>
                                        <div class="grid grid-cols-3 gap-3">
                                            <label v-for="option in categoryOptions" :key="option.value" :class="{
                                                'border-blue-500 bg-blue-50 shadow-inner': form.expense_category === option.value,
                                                'border-gray-200': form.expense_category !== option.value
                                            }"
                                                class="cursor-pointer rounded-lg border p-4 transition-all duration-200 hover:border-blue-400 hover:shadow-sm">
                                                <input type="radio" v-model="form.expense_category"
                                                    :value="option.value" class="hidden" @change="resetSubCategories">
                                                <div class="flex flex-col items-center gap-2">
                                                    <span :class="{
                                                        'text-blue-600': form.expense_category === option.value,
                                                        'text-gray-600': form.expense_category !== option.value
                                                    }" class="text-2xl">
                                                        <i :class="option.icon"></i>
                                                    </span>
                                                    <span :class="{
                                                        'text-blue-700': form.expense_category === option.value,
                                                        'text-gray-700': form.expense_category !== option.value
                                                    }" class="text-sm font-medium">
                                                        {{ option.label }}
                                                    </span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Dynamic Subcategory Sections with Animation -->
                                    <transition enter-active-class="transition-all duration-300 ease-out"
                                        enter-from-class="opacity-0 scale-95 translate-y-1"
                                        enter-to-class="opacity-100 scale-100 translate-y-0"
                                        leave-active-class="transition-all duration-200 ease-in"
                                        leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95"
                                        mode="out-in">

                                        <!-- General Expenses -->
                                        <div v-if="form.expense_category === 'General'" key="general"
                                            class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">General Expense
                                                Type</label>
                                            <div class="relative">
                                                <select v-model="form.General_category"
                                                    class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 pr-10 text-gray-900 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                                    <option value="" disabled>Select expense type</option>
                                                    <option v-for="cat in CategoryGeneral" :key="cat.id"
                                                        :value="cat.id">
                                                        {{ cat.name }}
                                                    </option>
                                                </select>
                                                <div
                                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                                    <i class="fas fa-chevron-down"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Vehicle Expenses -->
                                        <div v-else-if="form.expense_category === 'Vehicle'" key="vehicle"
                                            class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                                            <div class="grid grid-cols-1 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Select
                                                        Vehicle</label>
                                                    <div class="relative">
                                                        <select v-model="form.vehicles_id"
                                                            class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 pr-10 text-gray-900 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                                            <option value="" disabled>Choose vehicle</option>
                                                            <option v-for="cat in AllVehicles" :key="cat.id"
                                                                :value="cat.id">
                                                                {{ cat.plate_number }}
                                                            </option>
                                                        </select>
                                                        <div
                                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                                            <i class="fas fa-chevron-down"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Vehicle
                                                        Expense Type</label>
                                                    <div class="relative">
                                                        <select v-model="form.vehicle_category"
                                                            class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 pr-10 text-gray-900 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                                            <option value="" disabled>Select vehicle expense</option>
                                                            <option v-for="cat in CategoryVehicle" :key="cat.id"
                                                                :value="cat.id">
                                                                {{ cat.name }}
                                                            </option>
                                                        </select>
                                                        <div
                                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                                            <i class="fas fa-chevron-down"></i>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>

                                        <!-- Employee Expenses -->
                                        <div v-else-if="form.expense_category === 'Employee'" key="employee"
                                            class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                                            <div class="grid grid-cols-1 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                                        Select Employee
                                                    </label>
                                                    <div class="relative">
                                                        <select v-model="form.employees_id"
                                                            class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 pr-10 text-gray-900 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                                            <option value="" disabled>Choose employee</option>
                                                            <option v-for="cat in AllEmployees" :key="cat.id"
                                                                :value="cat.id">
                                                                {{ cat.first_name }} {{ cat.last_name }}
                                                            </option>
                                                        </select>
                                                        <div
                                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                                            <i class="fas fa-chevron-down"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Select
                                                        Vehicle</label>
                                                    <div class="relative">
                                                        <select v-model="form.employees_category"
                                                            class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 pr-10 text-gray-900 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                                            <option value="" disabled>Choose vehicle</option>
                                                            <option v-for="cat in CategoryEmployee" :key="cat.id"
                                                                :value="cat.id">
                                                                {{ cat.name }}
                                                            </option>
                                                        </select>
                                                        <div
                                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                                            <i class="fas fa-chevron-down"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </transition>
                                </div>

                                <div class="space-y-6 max-w-3xl mx-auto">
                                    <!-- Bank Selection Section -->
                                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100 space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">From Bank
                                            </label>
                                            <div class="relative">
                                                <select v-model="form.selectedBank" @change="filterBankAccounts"
                                                    class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 pr-10 text-gray-900 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                                    <option value="">select bank</option>
                                                    <option v-for="bank in AllBanks" :key="bank.id" :value="bank.id">
                                                        {{ bank.name }}
                                                    </option>
                                                </select>
                                                <div
                                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bank Account Selection -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">From Account
                                            </label>
                                            <div class="relative">
                                                <select v-model="form.selectedAccount"
                                                    class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 pr-10 text-gray-900 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                                    :disabled="!filteredAccounts.length">
                                                    <option value="" disabled>Select account</option>
                                                    <option v-for="account in filteredAccounts" :key="account.id"
                                                        :value="account.id">
                                                        {{ account.account_number }} - {{ account.account_name }}
                                                        <template v-if="!selectedBank">
                                                            ({{ getBankName(account.bank_id) }})
                                                        </template>
                                                    </option>
                                                </select>
                                                <div
                                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <p v-if="!filteredAccounts.length" class="mt-1 text-sm text-gray-500">
                                                No accounts available for selected bank
                                            </p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">To Bank </label>
                                            <div class="relative">
                                                <select v-model="form.toBank"
                                                    class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 pr-10 text-gray-900 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                                    <option v-for="bank in AllBanks" :key="bank.id" :value="bank.id">
                                                        {{ bank.name }}
                                                    </option>
                                                </select>
                                                <div
                                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">To Account
                                            </label>

                                            <input v-model="form.toAccount" id="owner_name" type="text"
                                                class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                                placeholder="Enter Amount" />
                                        </div>
                                    </div>
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
                                    <label for="date" class="block text-sm font-medium text-gray-800 mb-1">
                                        Date
                                    </label>
                                    <input v-model="form.paid_date" id="date" type="date"
                                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                        placeholder="Enter owner phone" />
                                </div>
                                <div>
                                    <label for="remark" class="block text-sm font-medium text-gray-800 mb-1">
                                        Remark
                                    </label>
                                    <input v-model="form.remark" id="remark" type="text"
                                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                                        placeholder="Enter owner phone" />
                                </div>
                                <div>
                                    <label for="file_input" class="block text-sm font-medium text-gray-800 mb-1">
                                        File
                                    </label>
                                    <div class="relative flex items-center">
                                        <input id="file_input" type="file" class="sr-only"
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
import expenseService from '@/services/expenses';
import AppAside from "../components/AppAside.vue";
import UserDropdown from "../components/UserDropdown.vue";
// import Forms from "./components/Forms.vue";
import ToggleMenu from "./components/ToggleMenu.vue";
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
                General_category: '',
                vehicles_id: '',
                vehicle_category: '',
                employees_id: '',
                employees_category: '',
                selectedBank: '',
                selectedAccount: '',
                toAccount: '',
                toBank: '',
                amount: '',
                paid_date: '',
                remark: '',
                file: null,



            },
            categoryOptions: [
                { value: 'General', label: 'General', icon: 'fas fa-file-invoice-dollar' },
                { value: 'Vehicle', label: 'Vehicle', icon: 'fas fa-car' },
                { value: 'Employee', label: 'Employee', icon: 'fas fa-user-tie' }
            ],
            selectedBank: '',
            selectedAccount: '',
            expenses: [],
            CategoryGeneral: [],
            CategoryEmployee: [],
            CategoryVehicle: [],
            AllEmployees: [],
            AllVehicles: [],
            AllBanks: [],
            AllBankAccounts: [],
            filteredAccounts: [],


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

                const response = await expenseService.getAll(params);

                // Standardized response handling
                this.expenses = response.data;
                this.CategoryEmployee = response.CategoryEmployee;
                this.CategoryGeneral = response.CategoryGeneral;
                this.CategoryVehicle = response.CategoryVehicle;
                this.AllEmployees = response.AllEmployees;
                this.AllVehicles = response.AllVehicles;
                this.AllBanks = response.AllBanks;
                this.AllBankAccounts = response.AllBanksAccount;


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
                console.error('Error fetching expenses:', error);
                this.$toast.error("Failed to load expenses: " + error.message);
            } finally {
                this.loadingVehicles = false;
            }
        },

        async handleSubmitAdd() {

            this.loading = true;
            this.error = null;
            // If editingVehicle is set, update the expense, else create new

            try {


                const response = await expenseService.store(this.form);
                await this.fetchVehicles();
                console.log(this.form);


                this.isSideFormVisible = false;


            } catch (error) {
                this.error = error.response?.data?.message || error.message || "Failed to save expense information";
                console.error("expense save error:", error);
            } finally {
                this.loading = false;
            }
        },

        editVehicle(expense) {
            this.isUpdating = true;
            this.form = {
                id: expense.id,
                plate_number: expense.plate_number || "",
                expense_name: expense.expense_name || "",
                owner_name: expense.owner_name || "",
                owner_phone: expense.owner_phone || "",
                owner_type: expense.owner_type || "",
                libre: expense.libre || "",
                // active: expense.active !== undefined ? expense.active : true,

            };
            this.isSideFormVisible = true;

        },
        async handleSubmitUpdate() {

            this.loading = true;
            this.error = null;
            this.success = null;
            // If editingVehicle is set, update the expense, else create new

            try {
                const response = await expenseService.update(this.form.id, this.form);
                await this.fetchVehicles();
                this.success = "expense updated successfully"




            } catch (error) {
                this.error = error.response?.data?.message || error.message || "Failed to save expense information";
                console.error("expense save error:", error);
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
                const response = await expenseService.search({
                    query: this.searchQuery,
                    page: this.pagination.current_page,
                    perPage: this.pagination.per_page
                });

                if (response.success) {
                    this.expenses = response.data;
                    this.updatePagination(response.meta);
                } else {
                    throw new Error(response.message || 'Invalid response');
                }
            } catch (error) {
                console.error('Search error:', error);
                this.searchError = typeof error === 'string' ? error : error.message;
                this.expenses = [];
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

                const response = await expenseService.getAll(params);

                this.expenses = response.data || [];
                this.updatePagination(response.meta || {});

            } catch (error) {
                console.error('Error loading expenses:', error);
                this.$toast.error('Failed to load expenses');
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
                    await expenseService.update(this.editingVehicle.id, this.form);
                    this.$toast.success("expense updated successfully");
                } else {
                    await expenseService.store(this.form);
                    this.$toast.success("expense created successfully");
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
        // expense edit function


        async confirmDelete(id, name) {
            if (confirm(`Are you sure you want to delete ${name} expense?`)) {
                try {
                    await expenseService.delete(id);
                    await this.fetchVehicles();

                    this.$toast.success("expense deleted successfully");


                } catch (error) {
                    this.$toast.error("Failed to delete expense");
                }
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
        },
        filterBankAccounts() {
            // Ensure AllBankAccounts is an array before filtering
            if (!Array.isArray(this.AllBankAccounts)) {
                this.AllBankAccounts = [];
            }

            if (!this.selectedBank) {
                this.filteredAccounts = [...this.AllBankAccounts]; // Now safe to spread
            } else {
                this.filteredAccounts = this.AllBankAccounts.filter(
                    account => account.bank_id === this.selectedBank
                );
            }
            this.selectedAccount = '';
        },

        getBankName(bankId) {
            const bank = this.AllBanks.find(b => b.id === bankId);
            return bank ? bank.name : 'Unknown Bank';
        },
    },
    async mounted() {
        document.addEventListener('click', this.closeMenu);

        try {
            // Example of fetching data (replace with your actual data loading)
            // this.allBanks = await fetchBanks();
            // this.allAccounts = await fetchAccounts();

            // Initialize with empty arrays if no data loaded
            this.AllBanks = this.AllBanks || [];
            this.AllBankAccounts = this.AllBankAccounts || [];
            this.filteredAccounts = [...this.AllBankAccounts];
        } catch (error) {
            console.error("Error loading data:", error);
            this.AllBanks = [];
            this.allAccounts = [];
            this.filteredAccounts = [];
        }
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
    color: #5f5f5f;
}


/* Animations */
.fade-grow-enter-active,
.fade-grow-leave-active {
    transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
}

.fade-grow-enter-from {
    opacity: 0;
    transform: scale(0.96) translateY(5px);
}

.fade-grow-leave-to {
    opacity: 0;
    transform: scale(0.98) translateY(-5px);
}
</style>