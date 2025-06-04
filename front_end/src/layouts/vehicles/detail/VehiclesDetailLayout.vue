<template>
    <!-- Sidebar overlay -->
    <div @click="toggleSidebar" :class="[
        'fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden',
        sidebarOpen ? '' : 'hidden',
    ]" id="sidebar-overlay"></div>

    <!-- Sidebar -->
    <aside :class="[
        'fixed md:sticky top-0 w-fit bg-white border-r border-surface-200 h-screen flex flex-col z-50 transition-transform duration-300',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0',
    ]">
        <AppAside />
    </aside>

    <div class="flex-1 flex flex-col">
        <!-- Header with search -->
        <header
            class="sticky top-0 flex items-center justify-between px-4 md:px-6 py-4 border-b border-surface-200 bg-white/80 backdrop-blur-sm z-30">
            <div class="flex items-center gap-3">
                <button @click="toggleSidebar" id="sidebar-toggle"
                    class="p-2 rounded-lg text-surface-500 hover:text-surface-700 hover:bg-surface-100 md:hidden">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="text-xl font-semibold text-gray-800">Vehicle Details</h1>
            </div>
            <div class="flex items-center gap-3 md:gap-4">
                <button
                    class="p-2 sm:flex hidden rounded-lg text-surface-500 hover:text-surface-700 hover:bg-surface-100 transition-colors relative">
                    <i class="fas fa-bell"></i>
                    <span
                        class="absolute top-1.5 right-1.5 block w-2 h-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                </button>
                <UserDropdown />
            </div>
        </header>

        <main class="p-4 md:p-6">
            <!-- Loading State -->
            <div v-if="loading" class="flex justify-center items-center h-64">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
            </div>

            <!-- Error State -->
            <div v-else-if="error" class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">Failed to load vehicle: {{ error }}</p>
                    </div>
                </div>
            </div>

            <!-- Vehicle Details -->
            <div v-else-if="vehicle" class="bg-white rounded-xl shadow-sm overflow-hidden">
                <!-- Vehicle Header -->
                <div class="px-6 py-4 border-b border-surface-200 bg-surface-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-surface-900">{{ vehicle.make }} {{ vehicle.model }}
                                {{ vehicle.vehicle_name }}</h2>
                            <p class="text-sm text-surface-500">Vehicle Details
                            </p>
                        </div>
                        <span :class="[
                            'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium',
                            vehicle.status === 'active' ? 'bg-green-100 text-green-800' :
                                vehicle.status === 'maintenance' ? 'bg-yellow-100 text-yellow-800' :
                                    'bg-red-100 text-red-800'
                        ]">
                            {{ vehicle.status }}
                        </span>
                    </div>
                </div>

                <!-- Vehicle Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 p-6">
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-medium text-surface-500 uppercase tracking-wider">Basic Information</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Name</span>
                                <span class="text-sm font-medium text-surface-900">{{ vehicle.vehicle_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Plate Number

                                </span>
                                <span class="text-sm font-medium text-surface-900">{{ vehicle.plate_number
                                    }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Owner Type
                                </span>
                                <span class="text-sm font-medium text-surface-900">{{ vehicle.owner_type }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Owner Name

                                </span>
                                <span class="text-sm font-medium text-surface-900">{{ vehicle.owner_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-surface-500">Owner Phone
                                </span>
                                <span class="text-sm font-medium text-surface-900">{{ vehicle.owner_phone || 'N/A'
                                    }}</span>
                            </div>
                        </div>
                    </div>

                    <table class="w-full divide-y divide-surface-200">
                        <thead class="bg-surface-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    #
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Plate Number
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Vehicle Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Own Type
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Own Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    Own Phone
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                                    libre
                                </th>

                                <th scope="col" class="relative px-6 py-3">
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-surface-200 w-full">
                            <tr data-v-9ee1eba5="" class="hover:bg-surface-50">
                                <td data-v-9ee1eba5=""
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-surface-900">1</td>
                                <td data-v-9ee1eba5="" class="px-6 py-4 whitespace-nowrap">
                                    <div data-v-9ee1eba5="" class="flex items-center"><!-- <div
                                                class="flex-shrink-0 h-8 w-8 bg-blue-400 rounded-full flex items-center justify-center">
                                                <img class="h-7 w-7 object-contain rounded-full "
                                                    src="@/assets/vehicles.png" :alt="">
                                            </div> -->
                                        <div data-v-9ee1eba5="" class="ml-4"><a data-v-9ee1eba5="" href="#/vehicle/14"
                                                class="text-sm font-medium text-surface-900 hover:underline">3245678</a>
                                        </div>
                                    </div>
                                </td>
                                <td data-v-9ee1eba5="" class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">Busa
                                </td>
                                <td data-v-9ee1eba5="" class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">
                                    PRIVATE</td>
                                <td data-v-9ee1eba5="" class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">
                                    mintesnot</td>
                                <td data-v-9ee1eba5="" class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">
                                    0987654</td>
                                <td data-v-9ee1eba5="" class="px-6 py-4 whitespace-nowrap text-sm text-surface-500"><img
                                        data-v-9ee1eba5=""
                                        src="http://127.0.0.1:8000/storage/libres/jMhhzhTktkMqSzQiQka2JnRREuUgR3qj2c7GUMR5.webp"
                                        alt="Libre" class="h-10 w-10 object-cover rounded"
                                        style="max-width: 60px; max-height: 60px;"></td>
                                <td data-v-9ee1eba5=""
                                    class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div data-v-2b1d1b4e="" data-v-9ee1eba5="" class="relative inline-block text-left">
                                        <!-- Dropdown toggle button --><button data-v-2b1d1b4e=""
                                            class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all"
                                            aria-label="Actions"><svg data-v-2b1d1b4e=""
                                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path data-v-2b1d1b4e=""
                                                    d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                                </path>
                                            </svg>
                                        </button><!-- Dropdown menu -->

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>


                </div>

                <!-- libre Image -->
                <div v-if="vehicle.libre" class="px-6 pb-6">
                    <h3 class="text-sm font-medium text-surface-500 uppercase tracking-wider mb-4 ">libre
                        Image</h3>
                    <img @click="fullImageModal" :src="`http://127.0.0.1:8000/storage/${vehicle.libre}`"
                        :alt="`${vehicle.vehicle_name} `"
                        class="rounded-lg w-full max-w-md border border-surface-200 cursor-pointer">
                    <!-- Fullscreen Button -->


                    <!-- Fullscreen Modal -->
                    <div v-if="showImageModal"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80">
                        <div class="relative">
                            <button @click="fullImageModal"
                                class="absolute top-2 right-2 bg-white rounded-full w-8 h-8 shadow flex justify-center items-center hover:bg-gray-100">
                                <i class="fas fa-times text-gray-700"></i>
                            </button>
                            <img :src="`http://127.0.0.1:8000/storage/${vehicle.libre}`"
                                :alt="`${vehicle.vehicle_name}`" class="max-h-[90vh] max-w-[90vw] rounded shadow-lg">
                        </div>
                    </div>

                </div>

                <!-- Action Buttons -->

            </div>

            <!-- Empty State -->
            <div v-else class="bg-white rounded-xl shadow-sm p-8 text-center">
                <i class="fas fa-car text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">No vehicle found</h3>
                <p class="mt-1 text-sm text-gray-500">We couldn't find any vehicle with the specified ID.</p>
                <button @click="$router.go(-1)"
                    class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Vehicles
                </button>
            </div>


        </main>
    </div>
</template>

<script>
import vehicleService from '@/services/vehicle';
import AppAside from '@/layouts/components/AppAside.vue';
import UserDropdown from '@/layouts/components/UserDropdown.vue';

export default {
    components: {
        AppAside,
        UserDropdown
    },
    data() {
        return {
            vehicle: [],
            loading: false,
            error: null,
            sidebarOpen: false,
            showImageModal: false
        };
    },
    async created() {
        await this.fetchVehicle();
    },
    methods: {
        async fetchVehicle() {
            this.loading = true;
            this.error = null;
            try {
                const id = this.$route.params.id;
                const response = await vehicleService.getById(id);
                this.vehicle = response.vehicle;
            } catch (error) {
                this.error = error.response?.data?.message || error.message || "Failed to load vehicle";
            } finally {
                this.loading = false;
            }
        },
        editVehicle() {
            this.$router.push(`/vehicles/${this.vehicle.id}/edit`);
        },
        async deleteVehicle() {
            if (confirm(`Are you sure you want to delete ${this.vehicle.make} ${this.vehicle.model}?`)) {
                try {
                    await vehicleService.delete(this.vehicle.id);
                    this.$toast.success("Vehicle deleted successfully");
                    this.$router.push('/vehicles');
                } catch (error) {
                    this.$toast.error("Failed to delete vehicle");
                    console.error("Delete error:", error);
                }
            }
        },
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        },
        fullImageModal() {
            this.showImageModal = !this.showImageModal;
        }

    }
};
</script>