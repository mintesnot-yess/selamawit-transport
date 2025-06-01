<script setup>
import { ref } from 'vue';

// Toggle function
const isSideFormVisible = ref(false)

const toggleSideForm = () => {
    isSideFormVisible.value = !isSideFormVisible.value
}
//   Hide function
const hideSideForm = () => {
    isSideFormVisible.value = false
}
</script>



<template>
    <div
        class="fixed   z-50 -top-0.5 left-0 bg-slate-700 bg-opacity-50 h-full w-full   shadow-2xl border border-gray-10   flex    overflow-y-auto">
        <button aria-label="Close" @click="toggleSideForm"
            class="toggle_side_form_btn absolute top-0 right-2 text-gey-500 m-5 hover:text-gray-700 rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-100 transition-colors duration-200 ">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div @click="hideSideForm" id="side_form" class="w-0  md:w-full sticky top-0  bg-transparent cursor-pointer ">
        </div>
        <div id="side_form" class="md:max-w-md p-6 w-full h-fit bg-white rounded-xl">
            <div class="flex justify-between items-center mb-3">
                <h2 class="font-bold text-gray-800 text-xl md:text-2xl leading-tight">Site Management
                </h2>

            </div>
            <p class="text-sm text-indigo-600 mb-6 leading-relaxed font-medium">
                Manage your site and all associated data in one place
            </p>
            <form class="flex flex-col space-y-6 font-['Inter']">



                <div>
                    <label for="siteType" class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">SITE
                        TYPE</label>
                    <select id="siteType"
                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm appearance-none bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM2NjciIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS1jaGV2cm9uLWRvd24iPjxwYXRoIGQ9Im03IDE1IDUgNSA1LTUiLz48L3N2Zz4=')] bg-no-repeat bg-[right_1rem_center] bg-[length:1.25em]">
                        <option value="" disabled selected>Select site type</option>
                        <option value="residential">Residential</option>
                        <option value="commercial">Commercial</option>
                        <option value="industrial">Industrial</option>
                        <option value="mixed-use">Mixed-Use</option>
                    </select>
                </div>

                <!-- Site Name -->
                <div>
                    <label for="siteName" class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">SITE
                        NAME</label>
                    <input id="siteName" type="text"
                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                        placeholder="Enter site name" />
                </div>

                <!-- Site Description -->
                <div>
                    <label for="siteDescription"
                        class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">SITE
                        DESCRIPTION</label>
                    <textarea id="siteDescription" rows="3"
                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-500/70 resize-y focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm min-h-[120px]"
                        placeholder="Describe your site"></textarea>
                </div>

                <!-- Site Location Coordinates -->
                <div class="space-y-3">
                    <p class="text-sm font-semibold text-gray-800 tracking-wide">SITE LOCATION
                        COORDINATES
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="latitude"
                                class="block text-xs font-medium text-gray-600 mb-2 tracking-wider">LATITUDE</label>
                            <input id="latitude" type="text"
                                class="w-full rounded-xl border border-gray-300/80 px-4 py-2.5 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 bg-white/95 shadow-sm"
                                placeholder="00.0000° N" />
                        </div>
                        <div>
                            <label for="longitude"
                                class="block text-xs font-medium text-gray-600 mb-2 tracking-wider">LONGITUDE</label>
                            <input id="longitude" type="text"
                                class="w-full rounded-xl border border-gray-300/80 px-4 py-2.5 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 bg-white/95 shadow-sm"
                                placeholder="00.0000° W" />
                        </div>
                    </div>
                </div>

                <!-- Construction Timeline -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-800 tracking-wide">CONSTRUCTION
                        TIMELINE</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="order_date1"
                                class="block text-xs font-medium text-gray-600 mb-2 tracking-wider">START
                                DATE</label>
                            <input id="order_date1" type="date"
                                class="w-full rounded-xl border border-gray-300/80 px-4 py-2.5 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 bg-white/95 shadow-sm" />
                        </div>
                        <div>
                            <label for="order_date"
                                class="block text-xs font-medium text-gray-600 mb-2 tracking-wider">COMPLETION
                                DATE</label>
                            <input id="order_date" type="date"
                                class="w-full rounded-xl border border-gray-300/80 px-4 py-2.5 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 bg-white/95 shadow-sm" />
                        </div>
                    </div>
                </div>

                <!-- Site Address -->
                <div>
                    <label for="siteAddress" class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">SITE
                        ADDRESS</label>
                    <input id="siteAddress" type="text"
                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                        placeholder="Full street address" />
                </div>

                <!-- Site Plan Number -->
                <div>
                    <label for="sitePlanNumber"
                        class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">SITE PLAN
                        NUMBER</label>
                    <input id="sitePlanNumber" type="text"
                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-500/70 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm"
                        placeholder="Enter plan number" />
                </div>

                <!-- Site Type Dropdown -->
                <div>
                    <label for="siteType" class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">SITE
                        TYPE</label>
                    <select id="siteType"
                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm appearance-none bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM2NjciIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS1jaGV2cm9uLWRvd24iPjxwYXRoIGQ9Im03IDE1IDUgNSA1LTUiLz48L3N2Zz4=')] bg-no-repeat bg-[right_1rem_center] bg-[length:1.25em]">
                        <option value="" disabled selected>Select site type</option>
                        <option value="residential">Residential</option>
                        <option value="commercial">Commercial</option>
                        <option value="industrial">Industrial</option>
                        <option value="mixed-use">Mixed-Use</option>
                    </select>
                </div>

                <!-- Project Status Radio Buttons -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-800 tracking-wide">PROJECT
                        STATUS</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label
                            class="flex items-center space-x-3 cursor-pointer p-3 rounded-lg border border-gray-200/80 hover:border-blue-400/50 transition-colors duration-200">
                            <input type="radio" name="status" value="planning"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="text-sm font-medium text-gray-700">Planning</span>
                        </label>
                        <label
                            class="flex items-center space-x-3 cursor-pointer p-3 rounded-lg border border-gray-200/80 hover:border-blue-400/50 transition-colors duration-200">
                            <input type="radio" name="status" value="active"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="text-sm font-medium text-gray-700">Active</span>
                        </label>
                        <label
                            class="flex items-center space-x-3 cursor-pointer p-3 rounded-lg border border-gray-200/80 hover:border-blue-400/50 transition-colors duration-200">
                            <input type="radio" name="status" value="completed"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="text-sm font-medium text-gray-700">Completed</span>
                        </label>
                    </div>
                </div>

                <!-- Site Features Checkboxes -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-800 tracking-wide">SITE
                        FEATURES</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label
                            class="flex items-center space-x-3 cursor-pointer p-3 rounded-lg border border-gray-200/80 hover:border-blue-400/50 transition-colors duration-200">
                            <input type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 rounded border-gray-300">
                            <span class="text-sm font-medium text-gray-700">Parking Available</span>
                        </label>
                        <label
                            class="flex items-center space-x-3 cursor-pointer p-3 rounded-lg border border-gray-200/80 hover:border-blue-400/50 transition-colors duration-200">
                            <input type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 rounded border-gray-300">
                            <span class="text-sm font-medium text-gray-700">Accessibility</span>
                        </label>
                        <label
                            class="flex items-center space-x-3 cursor-pointer p-3 rounded-lg border border-gray-200/80 hover:border-blue-400/50 transition-colors duration-200">
                            <input type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 rounded border-gray-300">
                            <span class="text-sm font-medium text-gray-700">Security</span>
                        </label>
                        <label
                            class="flex items-center space-x-3 cursor-pointer p-3 rounded-lg border border-gray-200/80 hover:border-blue-400/50 transition-colors duration-200">
                            <input type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 rounded border-gray-300">
                            <span class="text-sm font-medium text-gray-700">WiFi</span>
                        </label>
                    </div>
                </div>

                <!-- Notification Preferences -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-800 tracking-wide">NOTIFICATION
                        PREFERENCES</label>
                    <div class="space-y-2">
                        <label
                            class="flex items-center space-x-3 cursor-pointer p-3 rounded-lg border border-gray-200/80 hover:border-blue-400/50 transition-colors duration-200">
                            <input type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 rounded border-gray-300">
                            <span class="text-sm font-medium text-gray-700">Email Alerts</span>
                        </label>
                        <label
                            class="flex items-center space-x-3 cursor-pointer p-3 rounded-lg border border-gray-200/80 hover:border-blue-400/50 transition-colors duration-200">
                            <input type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 rounded border-gray-300">
                            <span class="text-sm font-medium text-gray-700">SMS Notifications</span>
                        </label>
                        <label
                            class="flex items-center space-x-3 cursor-pointer p-3 rounded-lg border border-gray-200/80 hover:border-blue-400/50 transition-colors duration-200">
                            <input type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 rounded border-gray-300">
                            <span class="text-sm font-medium text-gray-700">Push Notifications</span>
                        </label>
                    </div>
                </div>

                <!-- Location Details -->
                <div>
                    <label for="siteLocation"
                        class="block text-sm font-medium text-gray-800 mb-2.5 tracking-wide">LOCATION
                        DETAILS</label>
                    <textarea id="siteLocation" rows="4"
                        class="w-full rounded-xl border border-gray-300/80 px-4 py-3 text-gray-900 placeholder-gray-500/70 resize-y focus:outline-none focus:ring-2 focus:ring-blue-500/90 focus:border-blue-500/50 transition-all duration-200 bg-white/95 shadow-sm min-h-[140px]"
                        placeholder="Additional location information"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="mt-6 w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md hover:shadow-lg">
                    SAVE CHANGES
                </button>
            </form>


        </div>
    </div>
</template>
