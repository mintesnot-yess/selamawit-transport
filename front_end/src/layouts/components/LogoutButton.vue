<template>
    <button @click="handleLogout"
        class="px-4 py-2 text-sm w-full text-gray-700 hover:bg-gray-100 flex gap-2 items-center">
        <i class="fa fa-sign-out"></i>
        <span v-if="!loading">Sign Out</span>
        <span v-else>Logging out...</span>
    </button>
</template>

<script>

import authService from "@/services/auth";

export default {
    data() {
        return {
            loading: false,
        };
    },
    methods: {
        async handleLogout() {
            this.loading = true;
            try {
                await authService.logout();
            } catch (error) {
                console.error("Logout failed:", error);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
