<template>

    <div id="side_form" class="md:max-w-md p-6 w-full h-full bg-white rounded-xl">
        <div class="flex justify-between items-center mb-3">
            <h2 class="font-bold text-gray-800 text-xl md:text-2xl leading-tight">
                Banks
            </h2>
        </div>
        <p class="text-sm text-indigo-600 mb-6 leading-relaxed font-medium">
            Fill Banks Information
        </p>
        <form @submit.prevent="handleSubmit" class="flex flex-col  space-y-6 js font-['Inter']">
            <div>
                <label for="siteName" class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">
                    Bank Name</label>
                <input v-model="form.name" id="siteName" type="text"
                    class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                    placeholder="Enter Bank name" />
            </div>

            <!-- Error Message -->
            <div v-if="error" class=" text-sm">
                {{ error }}
            </div>

            <!-- Submit Button -->
            <button :disabled="loading" type="submit"
                class="mt-6 w-full place-self-end-end bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md hover:shadow-lg">
                <span v-if="!loading">SAVE</span>
                <span v-else>Processing...</span> </button>
        </form>
    </div>
</template>


<script>


import bankService from "@/services/banks";

export default {
    data() {
        return {
            form: {
                name: "",
                created_by: localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')).id : null, // user id from localStorage
                updated_by: localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')).id : null, // user id from localStorage
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
                // Call bank service to store the data
                const response = await bankService.store(this.form);
                await this.$store.dispatch('fetchBanks');





                // Optionally show success message

                // Reset form
                this.form.name = "";
                // return to the show tables
                this.$router.push('banks');


                // Optionally fetch updated bank list
                // await this.$store.dispatch('fetchBanks');


            } catch (error) {
                this.error = error.response?.data?.message || error.message || "Failed to save bank information";
                console.error("Bank save error:", error);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
