<template>

    <div class="flex items-center gap-3 px-6 py-5 border-b border-surface-200">
        <div class="w-8 h-8 rounded bg-accent-600 flex items-center justify-center">
            <img src="../../assets/logo_icon.png" class="w-5 saturate-0 invert brightness-100  " alt="">

        </div>
        <span class="font-semibold text-lg text-surface-900">STAdmin</span>

    </div>

    <nav class="flex-1 overflow-y-auto px-4 py-6 text-sm text-surface-600 scrollbar-hide">
        <div class="mb-8">
            <p class="text-xs font-medium uppercase mb-3 text-surface-500 tracking-wider">Menu</p>
            <ul class="space-y-2">
                <li>
                    <router-link active-class="bg-accent-100 text-accent-700 hover:bg-accent-100" to="/"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-surface-100 w-full font-medium text-surface-700 transition-colors">
                        <!-- <i class="fas fa-grid text-accent-500 text-base w-5"></i> -->
                        <img class="w-5 h-5 invert" src="../../assets//vector.png" alt="">
                        Dashboard
                        <!-- <i class="fas fa-chevron-right ml-auto text-surface-400 text-xs"></i> -->
                    </router-link>
                </li>
                <li>
                    <router-link active-class="bg-accent-100 text-accent-700 hover:bg-accent-100" to="/orders"
                        title="orders"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-surface-100  font-medium   transition-colors">
                        <img class="w-5 h-5 invert" src="../../assets//order.png" alt="">
                        Orders
                    </router-link>
                </li>

                <li>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors"
                        href="#">
                        <img class="w-5 h-5 invert" src="../../assets//wallet.png" alt="">

                        Exposes
                    </a>
                </li>

                <li>

                    <button type="button" @click="toggleSidebar"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <img class="w-5 h-5 invert" src="../../assets//book.png" alt="">

                        <span class="flex-1  text-left rtl:text-right whitespace-nowrap">Reports</span>
                        <i class="fas fa-chevron-right ml-auto text-surface-400 text-xs"></i>
                    </button>

                    <ul id="report_dropdown" :class="['py-2 space-y-2', reportDropdownOpen ? '' : 'hidden']">
                        <li>

                            <a href="#"
                                class="flex items-center gap-3 w-full px-7 self-end content-end py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">

                                Products</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center gap-3 w-full px-7 self-end content-end py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                                Billing</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center gap-3 w-full px-7 self-end content-end py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                                Invoice</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <button
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <img class="w-5 h-4 invert" src="../../assets//wallet.png" alt="">
                        Expose Type
                        <!-- <i class="fa fa-table ml-auto text-surface-400 text-xs"></i> -->
                    </button>
                </li>
                <li>
                    <button
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <!-- <i class="far fa-table text-base w-5"></i> -->
                        <img class="w-6  invert  " src="../../assets/vehicles.png" alt="">

                        Vehicles
                        <!-- <i class="fas fa-chevron-down ml-auto text-surface-400 text-xs"></i> -->
                    </button>
                </li>
                <li>
                    <button
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <img class="w-5  invert" src="../../assets/users.png" alt="">
                        Employees
                        <!-- <i class="fas fa-chevron-down ml-auto text-surface-400 text-xs"></i> -->
                    </button>
                </li>
                <li>
                    <button
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <i class="fa fa-location text-xl opacity-70 w-5"></i>
                        Location
                        <!-- <i class="fas fa-chevron-down ml-auto text-surface-400 text-xs"></i> -->
                    </button>
                </li>
                <li>
                    <button
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <img class="w-6  invert" src="../../assets/load.png" alt="">
                        Load Type
                        <!-- <i class="fas fa-chevron-down ml-auto text-surface-400 text-xs"></i> -->
                    </button>
                </li>
                <li>
                    <button
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <img class="w-5  invert" src="../../assets/bank.png" alt="">
                        Bank
                        <!-- <i class="fas fa-chevron-down ml-auto text-surface-400 text-xs"></i> -->
                    </button>
                </li>
            </ul>
        </div>

        <div class="mb-8">
            <p class="text-xs font-medium uppercase mb-3 text-surface-500 tracking-wider">
                User Management
            </p>
            <ul class="space-y-2">
                <li>
                    <button
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <img class="w-5 h-5 invert" src="../../assets/hund.png" alt="">
                        Clients
                        <!-- <i class="fa fa-table ml-auto text-surface-400 text-xs"></i> -->
                    </button>
                </li>
                <li>
                    <button
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors">
                        <!-- <i class="far fa-table text-base w-5"></i> -->
                        <img class="w-5  invert  " src="../../assets/user_lock.png" alt="">

                        System User
                        <!-- <i class="fas fa-chevron-down ml-auto text-surface-400 text-xs"></i> -->
                    </button>
                </li>
                <li>
                    <button
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg hover:bg-surface-100 font-medium text-surface-700 transition-colors cursor-pointer ">
                        <img class="w-5 h-4  invert  " src="../../assets/users.png" alt="">
                        Employees
                        <!-- <i class="fas fa-chevron-down ml-auto text-surface-400 text-xs"></i> -->
                    </button>
                </li>




            </ul>
        </div>

    </nav>



    <!-- <button id="bottom_dropdownAvatarNameButton" data-dropdown-toggle="bottom_dropdownAvatarName"
            class="p-4 border-t border-surface-200 cursor-pointer text-start  ">
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-surface-100">
                <div class="relative">
                    <img alt="User avatar" class="w-8 h-8 rounded-full object-cover"
                        src="https://storage.googleapis.com/a1aa/image/9b17cfa5-29f3-43f0-ea5a-c4ab7fc82603.jpg" />
                    <span
                        class="absolute bottom-0 right-0 block w-2 h-2 rounded-full bg-green-500 ring-2 ring-white"></span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-surface-900 truncate">Musharof Chowdhury</p>
                    <p class="text-xs text-surface-500 truncate">Admin</p>
                </div>
                <span class="text-surface-400 hover:text-surface-600">
                    <i class="fas fa-ellipsis-vertical text-sm"></i>
                </span>
            </div>
        </button>

        <div id="bottom_dropdownAvatarName"
            class="z-10 hidden  absolute bottom-20 left-5 bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-52">
            <div class="px-2 py-3 text-sm text-gray-900">
                <div class="font-medium">admin</div>
                <div class="truncate">name@flowbite.com</div>
            </div>
            <ul class="py-2 text-base text-gray-700"
                aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
                <li>
                    <a href="#"
                        class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex gap-2 content-between items-center">
                        <i class="fa fa-user "></i> Account</a>
                </li>
                <li>
                    <label
                        class="px-4 py-2 text-base text-gray-700 hover:bg-gray-100 gap-2 flex content-between items-center text-nowrap">
                        <i class="fa fa-moon "></i>
                        <span class="text-sm font-medium ">Dark Mode</span>
                        <div class="ml-10">
                            <input type="checkbox" value="" class="sr-only peer">
                            <div
                                class="relative w-10 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                            </div>
                        </div>
                    </label>

                </li>
            </ul>
            <div class="py-2">
                <a href="#"
                    class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex gap-2 content-between items-center">
                    <i class="fa fa-sign-out "></i> Sign Out</a>
            </div>
        </div> -->
</template>


<script setup>
import { ref } from 'vue';



const reportDropdownOpen = ref(false);

const toggleSidebar = () => {
    reportDropdownOpen.value = !reportDropdownOpen.value;
};

</script>