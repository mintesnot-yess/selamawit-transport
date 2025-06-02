<template>
    <div class="min-h-screen w-full flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Forgot your password?
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Enter your email and we'll send you a link to reset your password
                </p>
            </div>

            <form class="mt-8 space-y-6" @submit.prevent="submitForm">
                <!-- Success Message -->
                <div v-if="successMessage" class="rounded-md bg-green-50 p-4 mb-4">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="ml-3 text-sm font-medium text-green-800">
                            {{ successMessage }}
                        </p>
                    </div>
                </div>

                <!-- Error Message -->
                <div v-if="errorMessage" class="rounded-md bg-red-50 p-4 mb-4">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="ml-3 text-sm font-medium text-red-800">
                            {{ errorMessage }}
                        </p>
                    </div>
                </div>

                <!-- Email Input -->
                <div class="rounded-md shadow-sm -space-y-px">


                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input id="email" v-model="form.email" type="email" required placeholder="Enter your email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                            :disabled="loading" />
                    </div>

                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" :disabled="loading || !form.email"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span v-if="!loading">Send Reset Link</span>
                        <span v-else>
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Sending...
                        </span>
                    </button>
                </div>

                <!-- Back to Login -->
                <div class="text-center">
                    <router-link to="/login" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Back to login
                    </router-link>
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
                email: ''
            },
            loading: false,
            successMessage: '',
            errorMessage: ''
        };
    },
    methods: {
        async submitForm() {
            // Clear previous messages
            this.loading = true;
            this.successMessage = '';
            this.errorMessage = '';

            try {
                const response = await api.post('/forgot-password', this.form);

                // Handle successful response
                this.successMessage = response.data.message || 'Password reset link has been sent to your email';
                this.form.email = ''; // Clear the form on success
            } catch (error) {
                // Handle different error response formats
                if (error.response) {
                    // Laravel validation errors
                    if (error.response.data.errors?.email) {
                        this.errorMessage = error.response.data.errors.email[0];
                    }
                    // Custom API error message
                    else if (error.response.data.message) {
                        this.errorMessage = error.response.data.message;
                    }
                    // Fallback error message
                    else {
                        this.errorMessage = 'An error occurred while processing your request';
                    }
                } else if (error.request) {
                    // The request was made but no response was received
                    this.errorMessage = 'Network error. Please check your connection.';
                } else {
                    // Something happened in setting up the request
                    this.errorMessage = 'An unexpected error occurred';
                }
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>