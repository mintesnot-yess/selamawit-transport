<template>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-surface-200">
            <thead class="bg-surface-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                        #</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                        Bank Name</th>

                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Action</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-surface-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-surface-900">1
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8">
                                <img class="h-8 w-8 object-fit rounded-full bg-zinc-400" src="@/assets/bank.png" alt="">
                            </div>
                            <router-link to="/order" class="ml-4 hover:underline ">
                                <div class="text-sm font-medium text-surface-900">commercial bank of ethiopia</div>
                            </router-link>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button class="text-accent-600 hover:text-accent-900"><i
                                class="fas fa-ellipsis-vertical"></i></button>
                    </td>
                </tr>



            </tbody>
        </table>
    </div>
</template>