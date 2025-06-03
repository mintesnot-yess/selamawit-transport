<template>
    <div class="relative" ref="dropdownRef">
        <!-- Toggle Button -->
        <button @click="toggleDropdown" id="dropdownAvatarNameButton" class="flex items-center gap-2 cursor-pointer">
            <img alt="User avatar" class="w-8 h-8 md:w-10 md:h-10 rounded-full object-cover"
                src="https://storage.googleapis.com/a1aa/image/9b17cfa5-29f3-43f0-ea5a-c4ab7fc82603.jpg" />
            <span class="hidden md:inline text-sm font-medium text-surface-900">Musharof</span>
            <i class="fas sm:flex hidden fa-chevron-down text-surface-400 text-xs"></i>
        </button>

        <!-- Dropdown menu -->
        <div v-show="isOpen" id="dropdownAvatarName"
            class="z-10 absolute top-10 right-0 bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-52">
            <div class="px-2 py-3 text-sm text-gray-900">
                <div class="font-medium">admin</div>
                <div class="truncate">name@flowbite.com</div>
            </div>
            <ul class="py-2 text-base text-gray-700">
                <li>
                    <a href="#" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex gap-2 items-center">
                        <i class="fa fa-user"></i> Account
                    </a>
                </li>
                <li>
                    <DarkModeToggle />
                </li>
            </ul>
            <div class="py-2">
                <LogoutButton />

            </div>
        </div>
    </div>
</template>

<script>
import DarkModeToggle from "./DarkModeToggle.vue";
import LogoutButton from "./LogoutButton.vue";

import authService from "@/services/auth";
import { ref, onMounted, onUnmounted } from "vue";


export default {
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
