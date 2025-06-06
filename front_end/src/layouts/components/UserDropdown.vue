<template>
    <div class="relative" ref="dropdownRef">
        <!-- Toggle Button -->
        <button @click="toggleDropdown" id="dropdownAvatarNameButton" class="flex items-center gap-2 cursor-pointer">
            <span
                class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-surface-200 flex items-center justify-center text-surface-700 font-bold text-lg uppercase">
                {{ user_name ? user_name.charAt(0) : '' }}
            </span>
            <span class="hidden md:inline text-sm font-medium text-surface-900 capitalize">{{ user_name }}</span>
            <i class="fas sm:flex hidden fa-chevron-down text-surface-400 text-xs"></i>
        </button>

        <!-- Dropdown menu -->
        <transition name="fade">
            <div v-show="isOpen" id="dropdownAvatarName"
                class="z-20 absolute top-12 right-0 bg-white rounded-xl shadow-xl w-64 border border-gray-100 overflow-hidden">
                <!-- User Info -->
                <div class="flex items-center gap-3 px-5 py-4 bg-surface-100 border-b">
                    <span
                        class="w-10 h-10 rounded-full bg-surface-200 flex items-center justify-center text-surface-700 font-bold text-xl uppercase">
                        {{ user_name ? user_name.charAt(0) : '' }}
                    </span>
                    <div>
                        <div class="font-semibold text-surface-900 capitalize">{{ user_name || 'User' }}</div>
                        <div class="text-xs text-surface-500 truncate">{{ user_email || 'No email' }}</div>
                    </div>
                </div>
                <!-- Menu Items -->
                <ul class="py-2 text-base text-surface-700">
                    <li>
                        <a href="#" class="flex items-center gap-2 px-5 py-2 hover:bg-surface-200 transition rounded">
                            <i class="fa fa-user-circle"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="#" class="flex items-center gap-2 px-5 py-2 hover:bg-surface-200 transition rounded">
                            <i class="fa fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li> 
                    <li class="flex items-center gap-2 px-2 py-2  w-full  transition rounded">
                        <DarkModeToggle />
                    </li>-->
                </ul>
                <!-- Logout -->
                <div class="border-t px-2 py-3">
                    <LogoutButton class="w-full" />
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import DarkModeToggle from "./DarkModeToggle.vue";
import LogoutButton from "./LogoutButton.vue";

import authService from "@/services/auth";
import { ref, onMounted, onUnmounted } from "vue";


export default {
    data() {
        return {

            user_name: '',
            user_email: '',


        };
    },
    mounted() {
        const user = localStorage.getItem('user');
        if (user) {
            try {
                this.user_name = JSON.parse(user).name || '';
                this.user_email = JSON.parse(user).email || '';
            } catch (e) {
                this.user_name = '';
                this.user_email = '';
            }
        } else {
            this.user_name = '';
            this.user_email = '';

        }
    },

    setup() {
        const isOpen = ref(false);
        const dropdownRef = ref(null);

        const toggleDropdown = () => {
            isOpen.value = !isOpen.value;
        };

        const handleClickOutside = (event) => {
            if (
                dropdownRef.value &&
                !dropdownRef.value.contains(event.target)
            ) {
                isOpen.value = false;
            }
        };


        onMounted(() => {
            document.addEventListener("click", handleClickOutside);
        });

        onUnmounted(() => {
            document.removeEventListener("click", handleClickOutside);
        });

        return {
            isOpen,
            dropdownRef,
            toggleDropdown

        };
    },

    components: {
        LogoutButton,
        DarkModeToggle
    },



};
</script>
