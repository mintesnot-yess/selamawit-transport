<template>
    <div class="flex justify-between">
        <dt class="text-sm text-surface-500">{{ label }}</dt>
        <dd class="text-sm font-medium text-surface-900">{{ value }}</dd>
    </div>
</template>

<script>
export default {
    props: {
        label: String,
        value: [String, Number]
    }
};
</script>