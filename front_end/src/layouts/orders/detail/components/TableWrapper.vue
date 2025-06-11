<template>
    <div class="bg-white rounded-xl shadow-sm border border-surface-200 max-h-fit ">
        <div class=" ">

            <table class="min-w-full divide-y divide-surface-200">
                <thead class="bg-surface-50">
                    <tr>
                        <th v-for="column in columns" :key="column.key" scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-surface-500 uppercase tracking-wider">
                            {{ column.label }}
                        </th>
                        <th class="relative px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y  ">
                    <tr v-for="(item, index) in items" :key="index" class="hover:bg-surface-50">
                        <td v-for="column in columns" :key="column.key" class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-medium  ">
                                        {{ item[column.key] }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <ActionsMenu @view="$emit('action', { type: 'view', item })"
                                @edit="$emit('action', { type: 'edit', item })"
                                @delete="$emit('action', { type: 'delete', item })" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>








</template>

<script>
import ActionsMenu from "./ActionsMenu.vue";

export default {
    components: { ActionsMenu },
    props: {
        columns: Array,
        items: Array
    }

};
</script>


<style scoped>
.over-x {

    overflow-x: scroll;
}
</style>