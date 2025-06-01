<template>
    <div class="min-h-screen  w-full flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Reset your password
                </h2>
            </div>

            <form class="mt-8 space-y-6" @submit.prevent="submitForm">
                <div v-if="successMessage" class="rounded-md bg-green-50 p-4 mb-4">
                    <div class="flex">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ successMessage }}
                            </p>
                        </div>
                    </div>
                </div>

                <div v-if="errorMessage" class="rounded-md bg-red-50 p-4 mb-4">
                    <div class="flex">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">
                                {{ errorMessage }}
                            </p>
                        </div>
                    </div>
                </div>

                <input type="hidden" v-model="form.token">

                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <input id="email" v-model="form.email" name="email" type="email" autocomplete="email" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Email address">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" v-model="form.password" name="password" type="password"
                            autocomplete="new-password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="New password">
                    </div>
                    <div>
                        <label for="password_confirmation" class="sr-only">Confirm Password</label>
                        <input id="password_confirmation" v-model="form.password_confirmation"
                            name="password_confirmation" type="password" autocomplete="new-password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Confirm new password">
                    </div>
                </div>

                <div>
                    <button type="submit" :disabled="loading"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        :class="{ 'opacity-50 cursor-not-allowed': loading }">
                        <span v-if="!loading">Reset Password</span>
                        <span v-else>Resetting...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import api from '@/api';

export default {
    data() {
        return {
            form: {
                token: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            loading: false,
            successMessage: '',
            errorMessage: ''
        };
    },
    created() {
        this.form.token = this.$route.query.token || '';
        this.form.email = this.$route.query.email || '';
    },
    methods: {
        async submitForm() {
            this.loading = true;
            this.successMessage = '';
            this.errorMessage = '';

            try {
                const response = await api.post('/reset-password', this.form);
                this.successMessage = response.data.message || 'Password reset successfully. You can now login with your new password.';

                // Redirect to login after 3 seconds
                setTimeout(() => {
                    this.$router.push('/login');
                }, 3000);
            } catch (error) {
                this.errorMessage = error.response?.data?.message ||
                    this.formatErrors(error.response?.data?.errors) ||
                    'Something went wrong. Please try again.';
            } finally {
                this.loading = false;
            }
        },
        formatErrors(errors) {
            if (!errors) return null;
            return Object.values(errors).flat().join(' ');
        }
    }
};
</script>