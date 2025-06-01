<template>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-surface-200">
            <thead class="bg-surface-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                        Order Name</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                        Client Name</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                        Plate Number</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                        Driver Name</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                        Loading</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                        Destination</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                        Load Type</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                        Status</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                        Amount</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Action</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-surface-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-surface-900">#ORD-0001
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8">
                                <img class="h-8 w-8 rounded-full" src="https://randomuser.me/api/portraits/women/44.jpg"
                                    alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-surface-900">Leslie Alexander</div>
                                <div class="text-sm text-surface-500">leslie@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">3-A12797/33595</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">Kassaye Haile</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">Adama</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">Addis Ababa</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">Rice</td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Loaded</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-900">$249.00</td>

                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button class="text-accent-600 hover:text-accent-900"><i
                                class="fas fa-ellipsis-vertical"></i></button>
                    </td>
                </tr>

                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-surface-900">#ORD-0002
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8">
                                <img class="h-8 w-8 rounded-full" src="https://randomuser.me/api/portraits/men/32.jpg"
                                    alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-surface-900">Robert Fox</div>
                                <div class="text-sm text-surface-500">robert@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">3-A12797/33595</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">Kassaye Haile</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">Adama</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">Addis Ababa</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">Rice</td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Offloaded</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-900">$149.00</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button class="text-accent-600 hover:text-accent-900"><i
                                class="fas fa-ellipsis-vertical"></i></button>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-surface-900">#ORD-0003
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8">
                                <img class="h-8 w-8 rounded-full" src="https://randomuser.me/api/portraits/women/68.jpg"
                                    alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-surface-900">Jenny Wilson</div>
                                <div class="text-sm text-surface-500">jenny@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">3-A12797/33595</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">Kassaye Haile</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">Adama</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">Addis Ababa</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-500">Rice</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Offloaded</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-surface-900">$399.00</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button class="text-accent-600 hover:text-accent-900"><i
                                class="fas fa-ellipsis-vertical"></i></button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</template>