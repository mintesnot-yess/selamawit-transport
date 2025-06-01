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
                    <label
                        class="px-4 py-2 text-base text-gray-700 hover:bg-gray-100 gap-2 flex items-center text-nowrap">
                        <i class="fa fa-moon"></i>
                        <span class="text-sm font-medium">Dark Mode</span>
                        <div class="ml-10">
                            <input type="checkbox" value="" class="sr-only peer" />
                            <div
                                class="relative w-10 h-6 bg-gray-200 rounded-full peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:bg-blue-600 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all">
                            </div>
                        </div>
                    </label>
                </li>
            </ul>
            <div class="py-2">
                <LogoutButton />
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from "vue";
import authService from "@/services/auth";
import LogoutButton from "./LogoutButton.vue";

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
        const SignOut = () => {
            console.log("Sign Out");
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
            toggleDropdown,
        };
    },
};
</script>
