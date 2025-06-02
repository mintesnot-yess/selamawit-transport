<template>




    <!-- component -->
    <div class="min-h-screen w-full bg-gray-100 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Sign In</h2>

            <form @submit.prevent="handleSubmit" class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" v-model="form.email" type="email" required placeholder="Enter your email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" />
                </div>

                <div>
                    <label for="password" class=" block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" v-model="form.password" type="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                        placeholder="••••••••" />
                </div>

                <div class="flex items-center justify-between">


                    <span v-if="error" class="text-sm text-red-600 ">{{ error }}</span>
                    <span></span>
                    <router-link to="forgot-password" class="text-sm text-indigo-600 hover:text-indigo-500">Forgot
                        password?</router-link>

                </div>


                <button type="submit" :disabled="loading"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors flex items-center justify-center">
                    <div class="flex items-center justify-center h-10 w-full" v-if="loading">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Sign In...
                    </div>
                    <div class=" h-10 flex items-center content-center " v-else>
                        <span>Sign In</span>
                    </div>
                </button>
            </form>
        </div>
    </div>
</template>

<script>

import authService from "@/services/auth";


export default {
    data() {
        return {
            form: {
                email: "",
                password: "",
            },
            loading: false,
            error: null,
        };
    },
    methods: {
        async handleSubmit() {
            this.loading = true;
            this.error = null;

            try {
                // Call login API
                const { access_token } = await authService.login(this.form);

                authService.setAuthToken(access_token);

                // Fetch user data
                await authService.fetchUser();

                // Redirect to dashboard
                this.$router.push("/");
            } catch (error) {
                this.error = error.message;
            } finally {
                this.loading = false;
            }
        },
    },

};

</script>
